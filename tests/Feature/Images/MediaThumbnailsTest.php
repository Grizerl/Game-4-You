<?php

namespace Tests\Feature\Images;

use App\Models\Article;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MediaThumbnailsTest extends TestCase
{
    use RefreshDatabase;

    private string $legacyFile = 'assets/_test_legacy_cover.png';

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    protected function tearDown(): void
    {
        @unlink(public_path($this->legacyFile));

        parent::tearDown();
    }

    private function widthOf(object $media, string $conversion): int
    {
        return getimagesize($media->getPath($conversion))[0];
    }

    #[Test]
    public function cover_upload_creates_webp_thumb_and_large_conversions(): void
    {
        $game = Game::factory()->create();
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 2000, 1000))->toMediaCollection('cover');

        $media = $game->fresh()->imageMedia();

        $this->assertTrue($media->hasGeneratedConversion('thumb'));
        $this->assertTrue($media->hasGeneratedConversion('large'));
        $this->assertSame(640, $this->widthOf($media, 'thumb'));
        $this->assertSame(1280, $this->widthOf($media, 'large'));
        $this->assertStringEndsWith('-thumb.webp', $game->fresh()->cover_thumb_url);
        $this->assertStringEndsWith('-large.webp', $game->fresh()->cover_large_url);
    }

    #[Test]
    public function small_images_are_not_upscaled(): void
    {
        $game = Game::factory()->create();
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 400, 600))->toMediaCollection('cover');

        $this->assertSame(400, $this->widthOf($game->fresh()->imageMedia(), 'thumb'));
    }

    #[Test]
    public function avatar_and_logo_get_a_480px_thumb_only(): void
    {
        $creator = Creator::factory()->create();
        $creator->addMedia(UploadedFile::fake()->image('a.png', 1200, 1200))->toMediaCollection('avatar');
        $company = Company::factory()->create();
        $company->addMedia(UploadedFile::fake()->image('l.png', 1200, 600))->toMediaCollection('logo');

        $this->assertSame(480, $this->widthOf($creator->fresh()->imageMedia(), 'thumb'));
        $this->assertFalse($creator->fresh()->imageMedia()->hasGeneratedConversion('large'));
        $this->assertSame(480, $this->widthOf($company->fresh()->imageMedia(), 'thumb'));
        $this->assertStringEndsWith('-thumb.webp', $creator->fresh()->avatar_thumb_url);
        $this->assertStringEndsWith('-thumb.webp', $company->fresh()->logo_thumb_url);
    }

    #[Test]
    public function new_cover_replaces_the_old_one_and_deleting_the_record_removes_files(): void
    {
        $article = Article::factory()->create();
        $article->addMedia(UploadedFile::fake()->image('one.jpg', 1000, 500))->toMediaCollection('cover');
        $first = $article->fresh()->imageMedia();
        $firstPath = $first->getPath();

        $article->fresh()->addMedia(UploadedFile::fake()->image('two.jpg', 1000, 500))->toMediaCollection('cover');

        $this->assertCount(1, $article->fresh()->getMedia('cover'));
        $this->assertFileDoesNotExist($firstPath);

        $path = $article->fresh()->imageMedia()->getPath('thumb');
        $article->fresh()->delete();

        $this->assertFileDoesNotExist($path);
        $this->assertDatabaseCount('media', 0);
    }

    #[Test]
    public function falls_back_to_legacy_path_and_placeholder(): void
    {
        $withLegacy = Game::factory()->create(['cover_image' => 'assets/images/games/legacy.jpg']);
        $this->assertTrue($withLegacy->hasImage());
        $this->assertSame(asset('assets/images/games/legacy.jpg'), $withLegacy->cover_thumb_url);
        $this->assertSame(asset('assets/images/games/legacy.jpg'), $withLegacy->cover_url);

        $none = Game::factory()->create(['cover_image' => null]);
        $this->assertFalse($none->hasImage());
        $this->assertSame(asset(Game::PLACEHOLDER_COVER), $none->cover_thumb_url);
    }

    #[Test]
    public function original_url_stays_the_original_file(): void
    {
        $game = Game::factory()->create();
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 2000, 1000))->toMediaCollection('cover');

        $this->assertStringEndsWith('.jpg', $game->fresh()->cover_url);
        $this->assertStringNotContainsString('conversions', $game->fresh()->cover_url);
    }

    #[Test]
    public function search_document_points_to_the_thumbnail(): void
    {
        $game = Game::factory()->create();
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 2000, 1000))->toMediaCollection('cover');

        $path = $game->fresh()->imageSearchPath();

        $this->assertStringStartsWith('/storage/', $path);
        $this->assertStringEndsWith('-thumb.webp', $path);
    }

    #[Test]
    public function import_command_moves_legacy_files_into_media_library_idempotently(): void
    {
        $image = imagecreatetruecolor(1500, 900);
        imagepng($image, public_path($this->legacyFile));
        imagedestroy($image);

        $game = Game::factory()->create(['cover_image' => $this->legacyFile]);
        $external = Game::factory()->create(['cover_image' => 'https://example.com/x.jpg']);

        $this->artisan('media:import-legacy')->assertSuccessful();

        $media = $game->fresh()->imageMedia();
        $this->assertNotNull($media);
        $this->assertTrue($media->hasGeneratedConversion('thumb'));
        $this->assertSame(640, $this->widthOf($media, 'thumb'));
        $this->assertFileExists(public_path($this->legacyFile), 'оригінал не видаляється');
        $this->assertSame($this->legacyFile, $game->fresh()->cover_image, 'стара колонка лишається');
        $this->assertNull($external->fresh()->imageMedia());

        $this->artisan('media:import-legacy')->assertSuccessful();
        $this->assertCount(1, $game->fresh()->getMedia('cover'));
    }

    #[Test]
    public function replacing_the_image_clears_the_legacy_column_but_keeps_seed_assets(): void
    {
        $game = Game::factory()->create(['cover_image' => 'assets/images/games/seed.jpg']);
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 800, 400))->toMediaCollection('cover');
        $game->deleteLegacyImage();

        $this->assertNull($game->fresh()->cover_image);
    }
}
