<?php

namespace Tests\Feature\Games;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminGameTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Http::fake();
    }

    private function admin(): static
    {
        return $this->actingAs(User::factory()->create());
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_replace_recursive([
            'name' => ['uk' => 'Кібер квест', 'en' => 'Cyber Quest'],
            'description' => ['uk' => 'Опис гри', 'en' => 'Game description'],
            'rating' => 1500,
            'platforms' => 'PC, PS5',
            'isNew' => 1,
            'category_id' => Category::factory()->create()->id,
            'creator_id' => Creator::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'cover_image' => UploadedFile::fake()->image('cover.jpg', 600, 900),
        ], $overrides);
    }

    /**
     * @return array<string, mixed>
     */
    private function updatePayload(Game $game, array $overrides = []): array
    {
        return array_replace_recursive([
            'name' => ['uk' => 'Назва', 'en' => 'Title'],
            'description' => ['uk' => 'Опис', 'en' => 'Description'],
            'rating' => $game->rating,
            'platforms' => $game->platforms,
            'isNew' => 0,
            'category_id' => $game->category_id,
            'creator_id' => $game->creator_id,
            'company_id' => $game->company_id,
        ], $overrides);
    }

    private function storedGame(array $attributes = []): Game
    {
        $cover = UploadedFile::fake()->image('c.jpg')->store('games', 'public');

        return Game::factory()->create(['cover_image' => $cover, ...$attributes]);
    }

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get(route('game.index'))->assertRedirect(route('login'));
        $this->post(route('game.store'), $this->payload())->assertRedirect(route('login'));

        $this->assertDatabaseCount('games', 0);
    }

    #[Test]
    public function list_is_paginated_searchable_and_shows_comment_counts(): void
    {
        $games = Game::factory()->count(16)->create();
        $latest = $games->last();
        Comment::create(['name' => 'A', 'content' => 'B', 'game_id' => $latest->id]);

        $this->admin()->get(route('game.index'))
            ->assertOk()
            ->assertViewHas('game', fn ($page): bool => $page->count() === 15 && $page->total() === 16
                && $page->firstWhere('id', $latest->id)->comments_count === 1)
            ->assertSee($latest->slug)
            ->assertSee(route('games.show.page', $latest), false);

        Game::factory()->create(['name' => ['uk' => 'Унікальна', 'en' => 'Zyxwv Unique']]);

        $this->admin()->get(route('game.index', ['q' => 'zyxwv']))
            ->assertSee('Zyxwv Unique')
            ->assertDontSee($latest->slug);
    }

    #[Test]
    public function search_survives_pagination(): void
    {
        Game::factory()->count(16)->create(['name' => ['uk' => 'Пошук', 'en' => 'Searchable']]);

        $this->admin()->get(route('game.index', ['q' => 'searchable']))
            ->assertSee('q=searchable&amp;page=2', false);
    }

    #[Test]
    public function forms_have_new_fields(): void
    {
        $this->admin()->get(route('game.create'))
            ->assertOk()
            ->assertSee('name="slug"', false)
            ->assertSee('name="released_at"', false)
            ->assertSee('name="trailer_url"', false)
            ->assertSee('name="screenshots[]"', false)
            ->assertSee('data-avatar-preview', false)
            ->assertSee('name="cover_image"', false);
    }

    #[Test]
    public function game_can_be_created_with_all_fields_and_notifies_telegram(): void
    {
        $this->admin()->post(route('game.store'), $this->payload([
            'slug' => 'custom-slug',
            'released_at' => '2021-03-05',
            'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'screenshots' => [UploadedFile::fake()->image('a.png'), UploadedFile::fake()->image('b.jpg')],
        ]))->assertRedirect(route('game.index'));

        $game = Game::firstOrFail();

        $this->assertSame('custom-slug', $game->slug);
        $this->assertSame('2021-03-05', $game->released_at->toDateString());
        $this->assertSame('dQw4w9WgXcQ', $game->trailerId());
        $this->assertTrue($game->isNew);
        $this->assertCount(2, $game->screenshots);
        Storage::disk('public')->assertExists($game->cover_image);
        foreach ($game->screenshots as $path) {
            Storage::disk('public')->assertExists($path);
        }

        Http::assertSent(fn (Request $request): bool => str_contains($request->url(), 'api.telegram.org')
            && str_contains((string) $request['text'], $game->name));
    }

    #[Test]
    public function telegram_failure_does_not_block_saving(): void
    {
        Http::fake(fn () => throw new ConnectionException('Telegram is down'));

        $this->admin()->post(route('game.store'), $this->payload())->assertRedirect(route('game.index'));

        $this->assertDatabaseCount('games', 1);
    }

    #[Test]
    public function missing_required_fields_are_rejected_and_input_preserved(): void
    {
        $this->admin()->from(route('game.create'))->post(route('game.store'), [
            'name' => ['uk' => '', 'en' => 'Only English'],
            'description' => ['uk' => 'Опис', 'en' => 'Description'],
        ])
            ->assertRedirect(route('game.create'))
            ->assertSessionHasErrors(['name.uk', 'cover_image', 'category_id', 'creator_id', 'company_id', 'rating', 'platforms'])
            ->assertSessionHasInput('name.en', 'Only English');

        $this->assertDatabaseCount('games', 0);
    }

    #[Test]
    public function generated_slug_is_unique_and_cyrillic_is_transliterated(): void
    {
        $this->admin()->post(route('game.store'), $this->payload());
        $this->admin()->post(route('game.store'), $this->payload());

        $this->assertSame(['cyber-quest', 'cyber-quest-2'], Game::orderBy('id')->pluck('slug')->all());

        $this->admin()->post(route('game.store'), $this->payload(['name' => ['en' => '', 'uk' => 'Українська гра']]));

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Game::orderByDesc('id')->first()->slug);
    }

    #[Test]
    public function manual_slug_must_be_unique_and_well_formed(): void
    {
        Game::factory()->create(['slug' => 'taken']);

        $this->admin()->post(route('game.store'), $this->payload(['slug' => 'taken']))->assertSessionHasErrors('slug');
        $this->admin()->post(route('game.store'), $this->payload(['slug' => 'Bad Slug!']))->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('games', 1);
    }

    #[Test]
    public function renaming_keeps_slug_and_slug_may_equal_its_own_value(): void
    {
        $game = $this->storedGame(['slug' => 'old-slug']);

        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game, ['slug' => '']))->assertSessionHasNoErrors();
        $this->assertSame('old-slug', $game->fresh()->slug);

        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game, ['slug' => 'old-slug']))->assertSessionHasNoErrors();
        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game, ['slug' => 'new-slug']))->assertSessionHasNoErrors();

        $this->assertSame('new-slug', $game->fresh()->slug);
    }

    #[Test]
    public function invalid_trailer_screenshots_rating_and_references_are_rejected(): void
    {
        $admin = $this->admin();

        $admin->post(route('game.store'), $this->payload(['trailer_url' => 'https://evil.example/watch?v=dQw4w9WgXcQ']))->assertSessionHasErrors('trailer_url');
        $admin->post(route('game.store'), $this->payload(['trailer_url' => 'javascript:alert(1)']))->assertSessionHasErrors('trailer_url');
        $admin->post(route('game.store'), $this->payload(['rating' => -5]))->assertSessionHasErrors('rating');
        $admin->post(route('game.store'), $this->payload(['creator_id' => 9999]))->assertSessionHasErrors('creator_id');
        $admin->post(route('game.store'), $this->payload(['cover_image' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')]))->assertSessionHasErrors('cover_image');
        $admin->post(route('game.store'), $this->payload(['cover_image' => UploadedFile::fake()->image('big.png')->size(5000)]))->assertSessionHasErrors('cover_image');

        $seven = array_map(fn (int $i) => UploadedFile::fake()->image("s$i.jpg"), range(1, 7));
        $admin->post(route('game.store'), $this->payload(['screenshots' => $seven]))->assertSessionHasErrors('screenshots');

        $admin->post(route('game.store'), $this->payload(['screenshots' => [UploadedFile::fake()->create('x.pdf', 10, 'application/pdf')]]))
            ->assertSessionHasErrors('screenshots.0');

        $this->assertDatabaseCount('games', 0);
    }

    #[Test]
    public function edit_form_is_prefilled(): void
    {
        $game = $this->storedGame([
            'name' => ['uk' => 'Назва', 'en' => 'Prefilled Game'],
            'slug' => 'prefilled',
            'released_at' => '2020-02-02',
            'trailer_url' => 'https://youtu.be/dQw4w9WgXcQ',
        ]);

        $this->admin()->get(route('game.edit', $game->id))
            ->assertOk()
            ->assertSee('value="Prefilled Game"', false)
            ->assertSee('value="prefilled"', false)
            ->assertSee('value="2020-02-02"', false)
            ->assertSee('value="https://youtu.be/dQw4w9WgXcQ"', false)
            ->assertSee($game->cover_url, false);
    }

    #[Test]
    public function update_without_file_keeps_cover_and_replacing_deletes_old_file(): void
    {
        $game = $this->storedGame();
        $old = $game->cover_image;

        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game))->assertRedirect(route('game.index'));

        $this->assertSame($old, $game->fresh()->cover_image);
        Storage::disk('public')->assertExists($old);

        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game, ['cover_image' => UploadedFile::fake()->image('new.png')]));

        $new = $game->fresh()->cover_image;
        $this->assertNotSame($old, $new);
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($new);
    }

    #[Test]
    public function screenshots_can_be_added_and_removed_within_the_limit(): void
    {
        $keep = UploadedFile::fake()->image('keep.jpg')->store('games/screenshots', 'public');
        $drop = UploadedFile::fake()->image('drop.jpg')->store('games/screenshots', 'public');
        $game = $this->storedGame(['screenshots' => [$keep, $drop]]);

        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game, [
            'remove_screenshots' => [$drop, 'games/screenshots/not-mine.jpg'],
            'screenshots' => [UploadedFile::fake()->image('new.jpg')],
        ]))->assertSessionHasNoErrors();

        $paths = $game->fresh()->screenshots;

        $this->assertCount(2, $paths);
        $this->assertContains($keep, $paths);
        $this->assertNotContains($drop, $paths);
        Storage::disk('public')->assertMissing($drop);
        Storage::disk('public')->assertExists($keep);
    }

    #[Test]
    public function total_screenshots_cannot_exceed_the_limit_on_update(): void
    {
        $existing = array_map(fn (int $i) => UploadedFile::fake()->image("e$i.jpg")->store('games/screenshots', 'public'), range(1, 5));
        $game = $this->storedGame(['screenshots' => $existing]);

        $this->admin()->put(route('game.update', $game->id), $this->updatePayload($game, [
            'screenshots' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')],
        ]))->assertSessionHasErrors('screenshots');

        $this->assertCount(5, $game->fresh()->screenshots);
    }

    #[Test]
    public function deleting_removes_record_files_and_comments(): void
    {
        $shot = UploadedFile::fake()->image('s.jpg')->store('games/screenshots', 'public');
        $game = $this->storedGame(['screenshots' => [$shot]]);
        Comment::create(['name' => 'A', 'content' => 'B', 'game_id' => $game->id]);
        $other = Game::factory()->create();
        Comment::create(['name' => 'C', 'content' => 'D', 'game_id' => $other->id]);

        $this->admin()->delete(route('game.destroy', $game->id))->assertRedirect(route('game.index'));

        $this->assertDatabaseMissing('games', ['id' => $game->id]);
        Storage::disk('public')->assertMissing($game->cover_image);
        Storage::disk('public')->assertMissing($shot);
        $this->assertDatabaseMissing('comments', ['game_id' => $game->id]);
        $this->assertDatabaseHas('comments', ['game_id' => $other->id]);
    }

    #[Test]
    public function admin_urls_keep_working_with_numeric_ids(): void
    {
        $game = $this->storedGame();

        $this->admin()->get('/control/game/'.$game->id.'/edit')->assertOk();
    }
}
