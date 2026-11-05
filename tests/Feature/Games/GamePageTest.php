<?php

namespace Tests\Feature\Games;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GamePageTest extends TestCase
{
    use RefreshDatabase;

    private function game(string $name, array $attributes = []): Game
    {
        return Game::factory()->create(['name' => ['uk' => $name, 'en' => $name], ...$attributes]);
    }

    /**
     * @return array<string, mixed>
     */
    private function structuredData(string $html): array
    {
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches));

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
    }

    // ---------- маршрут ----------

    #[Test]
    public function slug_renders_legacy_id_redirects_and_unknown_is_404(): void
    {
        $game = $this->game('Cyber Quest');

        $this->get(route('games.show.page', $game))->assertOk()->assertViewIs('pages.details.detail')->assertSee('Cyber Quest');

        $legacy = $this->get('/games/'.$game->id);
        $legacy->assertStatus(301);
        $this->assertSame(route('games.show.page', $game), $legacy->headers->get('Location'));

        $this->get('/games/no-such-game')->assertNotFound();
    }

    // ---------- hero ----------

    #[Test]
    public function hero_shows_platform_badges_release_date_and_profile_links(): void
    {
        $company = Company::factory()->create();
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);
        $game = $this->game('Cyber Quest', [
            'platforms' => 'PC, PS5',
            'released_at' => '2021-03-05',
            'company_id' => $company->id,
            'creator_id' => $creator->id,
            'isNew' => true,
        ]);

        $this->get(route('games.show.page', $game))
            ->assertSee('<li><a href="'.route('games.page', ['platform' => 'PC']).'">PC</a></li>', false)
            ->assertSee('PS5')
            ->assertSee('2021')
            ->assertSee('href="'.route('company.show.page', $company).'"', false)
            ->assertSee('href="'.route('creator.show.page', $creator).'"', false)
            ->assertSee(__('game.new_badge'));
    }

    #[Test]
    public function missing_release_date_is_not_replaced_by_creation_date(): void
    {
        $game = $this->game('Undated', ['released_at' => null]);

        $this->get(route('games.show.page', $game))
            ->assertOk()
            ->assertDontSee(__('game.release_date'));
    }

    #[Test]
    public function full_description_is_shown_and_navigation_has_anchors(): void
    {
        $long = str_repeat('Lorem ipsum dolor. ', 60);
        $game = $this->game('Long', ['description' => ['uk' => $long, 'en' => $long]]);

        $this->get(route('games.show.page', $game))
            ->assertSee(trim($long))
            ->assertSee('href="#overview"', false)
            ->assertSee('href="#comments"', false)
            ->assertDontSee('href="#trailer"', false)
            ->assertDontSee('href="#screenshots"', false)
            ->assertDontSee('id="trailer"', false);
    }

    // ---------- трейлер та скріншоти ----------

    #[Test]
    public function valid_youtube_trailer_is_shown_and_foreign_link_is_not(): void
    {
        $ok = $this->game('With Trailer', ['trailer_url' => 'https://youtu.be/dQw4w9WgXcQ']);
        $bad = $this->game('Bad Trailer', ['trailer_url' => 'https://evil.example/watch?v=dQw4w9WgXcQ']);

        $this->get(route('games.show.page', $ok))
            ->assertSee('data-gm-trailer="dQw4w9WgXcQ"', false)
            ->assertSee('href="#trailer"', false);

        $this->get(route('games.show.page', $bad))
            ->assertDontSee('data-gm-trailer', false)
            ->assertDontSee('evil.example');
    }

    #[Test]
    public function screenshots_gallery_and_lightbox_are_rendered(): void
    {
        $game = $this->game('Shots', ['screenshots' => ['games/screenshots/a.jpg', 'games/screenshots/b.jpg', 'games/screenshots/c.jpg']]);

        $response = $this->get(route('games.show.page', $game));

        $response->assertSee('href="#screenshots"', false)->assertSee('data-gm-lightbox', false);
        $this->assertSame(3, substr_count($response->getContent(), 'data-gm-shot='));
    }

    // ---------- пов'язані ігри ----------

    #[Test]
    public function similar_games_share_genre_and_exclude_self(): void
    {
        $genre = Category::factory()->create();
        $game = $this->game('Main Game', ['category_id' => $genre->id]);
        $this->game('Same Genre One', ['category_id' => $genre->id, 'rating' => 500]);
        $this->game('Same Genre Two', ['category_id' => $genre->id, 'rating' => 900]);
        $this->game('Other Genre');

        $this->get(route('games.show.page', $game))
            ->assertViewHas('similar', fn ($similar): bool => $similar->pluck('name')->sort()->values()->all() === ['Same Genre One', 'Same Genre Two'])
            ->assertSeeInOrder(['Same Genre Two', 'Same Genre One'])
            ->assertDontSee('Other Genre');
    }

    #[Test]
    public function more_from_studio_or_creator_and_hidden_when_empty(): void
    {
        $company = Company::factory()->create();
        $creator = Creator::factory()->create();
        $game = $this->game('Alone', ['company_id' => $company->id, 'creator_id' => $creator->id]);

        $this->get(route('games.show.page', $game))
            ->assertViewHas('more', fn ($more): bool => $more->isEmpty())
            ->assertDontSee(__('game.more_title'))
            ->assertDontSee(__('game.similar_title'));

        $this->game('Studio Sibling', ['company_id' => $company->id]);
        $this->game('Creator Sibling', ['creator_id' => $creator->id]);

        $this->get(route('games.show.page', $game))
            ->assertSee(__('game.more_title'))
            ->assertSee('Studio Sibling')
            ->assertSee('Creator Sibling');
    }

    #[Test]
    public function related_blocks_are_limited_to_six(): void
    {
        $genre = Category::factory()->create();
        $game = $this->game('Main', ['category_id' => $genre->id]);
        Game::factory()->count(9)->create(['category_id' => $genre->id]);

        $this->get(route('games.show.page', $game))
            ->assertViewHas('similar', fn ($similar): bool => $similar->count() === 6);
    }

    // ---------- коментарі ----------

    #[Test]
    public function comments_are_listed_newest_first_with_count(): void
    {
        $game = $this->game('Commented');
        Comment::create(['name' => 'Olena', 'content' => 'First comment', 'game_id' => $game->id]);
        Comment::create(['name' => 'Taras', 'content' => 'Second comment', 'game_id' => $game->id]);

        $this->get(route('games.show.page', $game))
            ->assertSeeInOrder(['Second comment', 'First comment'])
            ->assertSee(trans_choice('game.comments_plural', 2));
    }

    #[Test]
    public function comments_are_paginated_four_per_page_with_total_count(): void
    {
        $game = $this->game('Popular');
        foreach (range(1, 9) as $i) {
            Comment::create(['name' => "User $i", 'content' => "Comment number $i", 'game_id' => $game->id]);
        }

        $page = $this->get(route('games.show.page', $game));

        $page->assertSee('Comment number 9')->assertSee('Comment number 6')
            ->assertDontSee('Comment number 5')
            ->assertSee(trans_choice('game.comments_plural', 9))
            ->assertSee(__('game.nav_comments').' · 9')
            ->assertSee('gm-pager', false);
        $this->assertMatchesRegularExpression('/href="[^"]*comments_page=2#comments"/', $page->getContent());

        $this->get(route('games.show.page', ['game' => $game, 'comments_page' => 2]))
            ->assertSee('Comment number 5')->assertSee('Comment number 2')
            ->assertDontSee('Comment number 6')->assertDontSee('Comment number 1<', false);

        $this->get(route('games.show.page', ['game' => $game, 'comments_page' => 3]))
            ->assertSee('Comment number 1')->assertDontSee('Comment number 2');
    }

    #[Test]
    public function comments_page_out_of_range_redirects_to_last_page(): void
    {
        $game = $this->game('Popular');
        foreach (range(1, 9) as $i) {
            Comment::create(['name' => "User $i", 'content' => "Comment $i", 'game_id' => $game->id]);
        }

        $response = $this->get(route('games.show.page', ['game' => $game, 'comments_page' => 99]));

        $response->assertRedirect(route('games.show.page', ['game' => $game, 'comments_page' => 3]).'#comments');
    }

    #[Test]
    public function pagination_is_hidden_when_four_or_fewer_comments(): void
    {
        $game = $this->game('Quiet');
        foreach (range(1, 4) as $i) {
            Comment::create(['name' => "User $i", 'content' => "Comment $i", 'game_id' => $game->id]);
        }

        $this->get(route('games.show.page', $game))->assertOk()->assertDontSee('gm-pager', false);
    }

    #[Test]
    public function posting_a_comment_redirects_to_comments_section_with_status(): void
    {
        $game = $this->game('Commented');

        $response = $this->post(route('comments.store'), ['game_id' => $game->id, 'name' => 'Olena', 'content' => 'Great game']);

        $response->assertRedirect(route('games.show.page', $game).'#comments')->assertSessionHas('comment_status');
        $this->assertDatabaseHas('comments', ['game_id' => $game->id, 'name' => 'Olena', 'content' => 'Great game']);

        $this->get(route('games.show.page', $game))->assertSee('Great game')->assertSee(__('game.comment_sent'));
    }

    #[Test]
    public function validation_errors_go_back_to_comments_and_keep_input(): void
    {
        $game = $this->game('Commented');
        $page = route('games.show.page', $game);

        $this->from($page)->post(route('comments.store'), ['game_id' => $game->id, 'name' => '', 'content' => 'Keep me'])
            ->assertRedirect($page.'#comments')
            ->assertSessionHasErrors('name')
            ->assertSessionHasInput('content', 'Keep me');

        $this->assertDatabaseCount('comments', 0);
    }

    #[Test]
    public function honeypot_submissions_are_silently_ignored(): void
    {
        $game = $this->game('Commented');

        $this->post(route('comments.store'), ['game_id' => $game->id, 'name' => 'Bot', 'content' => 'Buy now', 'website' => 'http://spam.example'])
            ->assertRedirect(route('games.show.page', $game).'#comments')
            ->assertSessionMissing('comment_status');

        $this->assertDatabaseCount('comments', 0);
    }

    #[Test]
    public function comment_posting_is_rate_limited(): void
    {
        $game = $this->game('Commented');

        foreach (range(1, 5) as $i) {
            $this->post(route('comments.store'), ['game_id' => $game->id, 'name' => 'User', 'content' => "Comment $i"])->assertRedirect();
        }

        $this->post(route('comments.store'), ['game_id' => $game->id, 'name' => 'User', 'content' => 'One too many'])->assertStatus(429);

        $this->assertDatabaseCount('comments', 5);
    }

    #[Test]
    public function html_in_comments_is_escaped_and_mass_assignment_is_ignored(): void
    {
        $game = $this->game('Commented');

        $this->post(route('comments.store'), [
            'game_id' => $game->id, 'name' => 'Mallory', 'content' => '<script>alert(1)</script>', 'id' => 999, 'created_at' => '2000-01-01',
        ]);

        $this->assertDatabaseMissing('comments', ['id' => 999]);

        $this->get(route('games.show.page', $game))
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    // ---------- SEO ----------

    #[Test]
    public function seo_meta_and_structured_data_are_present(): void
    {
        $genre = Category::factory()->create(['title' => ['uk' => 'Рольові', 'en' => 'RPG']]);
        $game = $this->game('Cyber Quest', ['category_id' => $genre->id, 'platforms' => 'PC, PS5', 'released_at' => '2021-03-05']);

        $response = $this->get(route('games.show.page', $game));

        $response->assertSee('property="og:title" content="Cyber Quest"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('rel="canonical" href="'.route('games.show.page', $game).'"', false)
            ->assertSee('hreflang="uk"', false)
            ->assertSee('hreflang="en"', false);

        $data = $this->structuredData($response->getContent());

        $this->assertSame('VideoGame', $data['@type']);
        $this->assertSame('Cyber Quest', $data['name']);
        $this->assertSame(['PC', 'PS5'], $data['gamePlatform']);
        $this->assertSame('2021-03-05', $data['datePublished']);
    }

    #[Test]
    public function hostile_description_cannot_break_out_of_structured_data(): void
    {
        $evil = '</script><script>alert(1)</script>';
        $game = $this->game('Hostile', ['description' => ['uk' => $evil, 'en' => $evil]]);

        $response = $this->get(route('games.show.page', $game));

        $response->assertOk()->assertDontSee('<script>alert(1)</script>', false);
        $this->assertSame(1, substr_count($response->getContent(), 'application/ld+json'));
        $this->assertSame($evil, $this->structuredData($response->getContent())['description']);
    }

    // ---------- загальне ----------

    #[Test]
    public function page_does_not_run_per_item_queries(): void
    {
        $genre = Category::factory()->create();
        $game = $this->game('Busy', ['category_id' => $genre->id]);
        Game::factory()->count(8)->create(['category_id' => $genre->id, 'company_id' => $game->company_id]);
        foreach (range(1, 15) as $i) {
            Comment::create(['name' => "User $i", 'content' => 'Hi', 'game_id' => $game->id]);
        }

        DB::enableQueryLog();
        $this->get(route('games.show.page', $game))->assertOk();

        $this->assertLessThanOrEqual(14, count(DB::getQueryLog()));
    }

    #[Test]
    public function english_page_shows_english_content_and_labels(): void
    {
        app()->setLocale('en');

        $game = Game::factory()->create([
            'name' => ['uk' => 'Гра', 'en' => 'English Game'],
            'description' => ['uk' => 'Український опис', 'en' => 'English description'],
        ]);

        $this->get(route('games.show.page', $game))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('English Game')
            ->assertSee('English description')
            ->assertDontSee('Український опис')
            ->assertSee('About the game');
    }

    #[Test]
    public function translation_files_have_the_same_keys(): void
    {
        foreach (['game', 'games'] as $file) {
            $uk = require lang_path("uk/$file.php");
            $en = require lang_path("en/$file.php");

            $this->assertSame(array_keys(Arr::dot($uk)), array_keys(Arr::dot($en)), $file);
        }
    }
}
