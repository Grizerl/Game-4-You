<?php

namespace Tests\Feature\Images;

use App\Jobs\RegenerateImageConversions;
use App\Models\Game;
use App\Models\User;
use App\Support\ImageSizes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImageSizesSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ImageSizes::forget();
    }

    protected function tearDown(): void
    {
        ImageSizes::forget();

        parent::tearDown();
    }

    private function admin(): static
    {
        return $this->actingAs(User::factory()->create());
    }

    /**
     * @param  array<string, int>  $overrides
     * @return array<string, int>
     */
    private function payload(array $overrides = []): array
    {
        return $overrides + [
            'cover_thumb_desktop' => 800,
            'cover_thumb_mobile' => 400,
            'cover_large_desktop' => 1600,
            'cover_large_mobile' => 800,
            'avatar_thumb' => 300,
            'logo_thumb' => 240,
        ];
    }

    #[Test]
    public function settings_page_is_for_authenticated_users_only(): void
    {
        $this->get(route('settings.images'))->assertRedirect(route('login'));
        $this->put(route('settings.images.update'), $this->payload())->assertRedirect(route('login'));
        $this->post(route('settings.images.regenerate'))->assertRedirect(route('login'));
    }

    #[Test]
    public function page_shows_defaults_and_saved_values(): void
    {
        $this->admin()->get(route('settings.images'))
            ->assertOk()
            ->assertSee('name="cover_thumb_desktop" value="640"', false)
            ->assertSee('name="cover_thumb_mobile" value="360"', false)
            ->assertSee('name="cover_large_mobile" value="720"', false);

        ImageSizes::save(['cover.thumb.desktop' => 900]);

        $this->get(route('settings.images'))->assertSee('name="cover_thumb_desktop" value="900"', false);
    }

    #[Test]
    public function saving_new_sizes_persists_them_and_queues_regeneration(): void
    {
        Queue::fake();

        $this->admin()->put(route('settings.images.update'), $this->payload())
            ->assertRedirect(route('settings.images'))
            ->assertSessionHas('status');

        $this->assertSame(800, ImageSizes::width('cover.thumb.desktop'));
        $this->assertSame(400, ImageSizes::width('cover.thumb.mobile'));
        $this->assertSame(240, ImageSizes::width('logo.thumb'));
        Queue::assertPushed(RegenerateImageConversions::class, 1);
    }

    #[Test]
    public function saving_unchanged_sizes_does_not_queue_regeneration(): void
    {
        Queue::fake();

        $this->admin()->put(route('settings.images.update'), $this->payload(['cover_thumb_desktop' => 640, 'cover_thumb_mobile' => 360, 'cover_large_desktop' => 1280, 'cover_large_mobile' => 720, 'avatar_thumb' => 480, 'logo_thumb' => 480]))
            ->assertRedirect(route('settings.images'));

        Queue::assertNothingPushed();
    }

    #[Test]
    public function invalid_sizes_are_rejected(): void
    {
        Queue::fake();

        $this->admin()->from(route('settings.images'))
            ->put(route('settings.images.update'), $this->payload([
                'cover_thumb_mobile' => 900, // більше за десктоп (800)
                'cover_large_desktop' => 50, // менше мінімуму
                'avatar_thumb' => 99999,
                'logo_thumb' => 'abc',
            ]))
            ->assertRedirect(route('settings.images'))
            ->assertSessionHasErrors(['cover_thumb_mobile', 'cover_large_desktop', 'avatar_thumb', 'logo_thumb']);

        $this->assertSame(640, ImageSizes::width('cover.thumb.desktop'));
        Queue::assertNothingPushed();
    }

    #[Test]
    public function regenerate_button_queues_the_job(): void
    {
        Queue::fake();

        $this->admin()->post(route('settings.images.regenerate'))->assertRedirect(route('settings.images'));

        Queue::assertPushed(RegenerateImageConversions::class);
    }

    #[Test]
    public function new_uploads_use_configured_desktop_and_mobile_widths(): void
    {
        ImageSizes::save(['cover.thumb.desktop' => 800, 'cover.thumb.mobile' => 400, 'cover.large.desktop' => 1600, 'cover.large.mobile' => 900]);

        $game = Game::factory()->create();
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 2400, 1200))->toMediaCollection('cover');
        $media = $game->fresh()->imageMedia();

        $this->assertSame(800, getimagesize($media->getPath('thumb'))[0]);
        $this->assertSame(400, getimagesize($media->getPath('thumb_mobile'))[0]);
        $this->assertSame(1600, getimagesize($media->getPath('large'))[0]);
        $this->assertSame(900, getimagesize($media->getPath('large_mobile'))[0]);
    }

    #[Test]
    public function cover_component_offers_mobile_source_only_when_available(): void
    {
        $game = Game::factory()->create(['cover_image' => null]);

        // без медіа — звичайний <img>
        $plain = Blade::render('<x-cover :model="$game" kind="thumb" alt="x" />', ['game' => $game]);
        $this->assertStringNotContainsString('<picture>', $plain);
        $this->assertStringContainsString('<img src="', $plain);
        $this->assertStringContainsString('alt="x"', $plain);

        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 2000, 1000))->toMediaCollection('cover');
        $game = $game->fresh();

        $html = Blade::render('<x-cover :model="$game" kind="thumb" alt="x" loading="lazy" width="300" height="450" />', ['game' => $game]);
        $this->assertStringNotContainsString('<picture', $html);
        $this->assertMatchesRegularExpression('/srcset="[^"]*-thumb_mobile.webp 360w, [^"]*-thumb.webp 640w"/', $html);
        $this->assertStringContainsString('sizes="(max-width: 720px) 1px, 100000px"', $html);
        $this->assertStringContainsString('loading="lazy"', $html);
    }

    #[Test]
    public function catalog_serves_the_mobile_poster(): void
    {
        $game = Game::factory()->create();
        $game->addMedia(UploadedFile::fake()->image('cover.jpg', 1200, 1800))->toMediaCollection('cover');

        $this->get(route('games.page'))
            ->assertOk()
            ->assertDontSee('<picture', false)
            ->assertSee('sizes="(max-width: 720px) 1px, 100000px"', false)
            ->assertSee('-thumb_mobile.webp 360w', false);
    }
}
