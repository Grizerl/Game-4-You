<?php

namespace Tests\Feature\Home;

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

class HomePageTest extends TestCase
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

    // ---------- hero ----------

    #[Test]
    public function hero_has_looping_muted_video_with_both_sources_poster_and_single_h1(): void
    {
        $response = $this->get(route('home.page'));

        $response->assertOk()
            ->assertViewIs('pages.home.index')
            ->assertSee('data-hm-video', false)
            ->assertSee('muted loop autoplay playsinline', false)
            ->assertSee('preload="metadata"', false)
            ->assertSee('assets/video/hero-poster.jpg', false)
            ->assertSee('assets/video/hero.webm', false)
            ->assertSee('assets/video/hero.mp4', false)
            ->assertSee('type="video/webm"', false)
            ->assertSee('type="video/mp4"', false);

        $this->assertSame(1, substr_count($response->getContent(), '<h1'));

        foreach (['hero.mp4', 'hero.webm', 'hero-poster.jpg'] as $file) {
            $this->assertFileExists(public_path('assets/video/'.$file));
        }
    }

    #[Test]
    public function hero_has_no_video_pause_and_mute_controls(): void
    {
        $this->get(route('home.page'))
            ->assertSee('data-hm-video', false)
            ->assertDontSee('data-hm-pause', false)
            ->assertDontSee('data-hm-mute', false)
            ->assertDontSee('hm-ctrl', false);
    }

    #[Test]
    public function hero_links_go_to_catalog_and_configured_steam_url(): void
    {
        config(['services.social.steam' => 'https://store.example/steam']);

        $this->get(route('home.page'))
            ->assertSee('href="'.route('games.page').'"', false)
            ->assertSee('href="https://store.example/steam" target="_blank" rel="noopener noreferrer"', false);
    }

    #[Test]
    public function hero_has_no_own_search_form(): void
    {
        config(['search.enabled' => true]);

        $this->get(route('home.page'))
            ->assertDontSee('class="gm-search hm-search"', false)
            ->assertSee('data-hs-search', false);
    }

    #[Test]
    public function statistics_show_real_counts(): void
    {
        $companies = Company::factory()->count(2)->create();
        $creators = Creator::factory()->count(5)->create(['company_id' => $companies->first()->id]);
        $category = Category::factory()->create();

        foreach (range(1, 3) as $i) {
            Game::factory()->create([
                'company_id' => $companies->first()->id,
                'creator_id' => $creators->first()->id,
                'category_id' => $category->id,
            ]);
        }

        $this->get(route('home.page'))
            ->assertViewHas('stats', ['games' => 3, 'companies' => 2, 'creators' => 5])
            ->assertSee('data-hm-count="3"', false)
            ->assertSee('data-hm-count="2"', false)
            ->assertSee('data-hm-count="5"', false);
    }

    // ---------- тренди ----------

    #[Test]
    public function top_tab_is_ordered_by_rating_and_new_tab_by_release_date(): void
    {
        $this->game('Low rated', ['rating' => 100, 'released_at' => '2024-01-01']);
        $this->game('High rated', ['rating' => 900, 'released_at' => '2020-01-01']);
        $this->game('Mid rated', ['rating' => 500, 'released_at' => '2022-01-01']);

        $response = $this->get(route('home.page'));

        $response->assertViewHas('topGames', fn ($games): bool => $games->pluck('rating')->all() === [900, 500, 100]);
        $response->assertViewHas('newGames', fn ($games): bool => $games->map(fn ($g) => $g->getTranslation('name', 'en'))->all() === ['Low rated', 'Mid rated', 'High rated']);

        $response->assertSee('data-hm-tab="new"', false)->assertSee('data-hm-tab="top"', false)
            ->assertSee('role="tabpanel"', false);
    }

    #[Test]
    public function trending_strips_are_limited_to_six_games(): void
    {
        Game::factory()->count(9)->create();

        $this->get(route('home.page'))
            ->assertViewHas('newGames', fn ($games): bool => $games->count() === 6)
            ->assertViewHas('topGames', fn ($games): bool => $games->count() === 6);
    }

    #[Test]
    public function posters_link_to_slug_pages_and_use_placeholder_for_missing_cover(): void
    {
        $game = $this->game('Poster Game', ['cover_image' => '']);

        $this->get(route('home.page'))
            ->assertSee('href="'.route('games.show.page', $game).'"', false)
            ->assertSee('assets/images/games/placeholder.svg');
    }

    // ---------- spotlight ----------

    #[Test]
    public function spotlight_prefers_new_game_with_trailer_then_new_by_rating_then_top_rated(): void
    {
        $this->game('Top old', ['rating' => 9000, 'isNew' => false]);
        $newPlain = $this->game('New plain', ['rating' => 800, 'isNew' => true, 'trailer_url' => null]);

        $this->get(route('home.page'))->assertViewHas('spotlight', fn ($game): bool => $game->is($newPlain));

        $newTrailer = $this->game('New with trailer', ['rating' => 100, 'isNew' => true, 'trailer_url' => 'https://youtu.be/dQw4w9WgXcQ']);
        $this->game('New foreign trailer', ['rating' => 5000, 'isNew' => true, 'trailer_url' => 'https://evil.example/x']);

        $response = $this->get(route('home.page'));

        $response->assertViewHas('spotlight', fn ($game): bool => $game->is($newTrailer))
            ->assertSee('href="'.route('games.show.page', $newTrailer).'#trailer"', false);

        Game::query()->update(['isNew' => false]);

        $this->get(route('home.page'))
            ->assertViewHas('spotlight', fn ($game): bool => $game->rating === 9000);
    }

    #[Test]
    public function spotlight_is_absent_without_games(): void
    {
        $this->get(route('home.page'))
            ->assertOk()
            ->assertViewHas('spotlight', null)
            ->assertDontSee('hm-spot__title', false);
    }

    // ---------- жанри, студії, творці ----------

    #[Test]
    public function genre_tiles_show_only_genres_with_games(): void
    {
        $rpg = Category::factory()->create(['title' => ['uk' => 'Рольові', 'en' => 'RPG']]);
        $empty = Category::factory()->create(['title' => ['uk' => 'Порожній жанр', 'en' => 'Empty genre']]);
        $this->game('One', ['category_id' => $rpg->id]);
        $this->game('Two', ['category_id' => $rpg->id]);

        $this->get(route('home.page'))
            ->assertSee('href="'.route('games.page', ['category' => $rpg->id]).'"', false)
            ->assertSee(trans_choice('home.games_plural', 2))
            ->assertDontSee($empty->title);
    }

    #[Test]
    public function studios_marquee_links_to_profiles_with_logo_or_name_and_duplicates_are_hidden_from_a11y(): void
    {
        $withLogo = Company::factory()->create(['name' => ['uk' => 'Лого студія', 'en' => 'Logo Studio'], 'logo_path' => 'uploads/company/x.png']);
        $noLogo = Company::factory()->create(['name' => ['uk' => 'Безлого студія', 'en' => 'Nologo Studio'], 'logo_path' => null]);

        $response = $this->get(route('home.page'));

        $response->assertSee('href="'.route('company.show.page', $withLogo).'"', false)
            ->assertSee('href="'.route('company.show.page', $noLogo).'"', false)
            ->assertSee(asset('uploads/company/x.png'), false)
            ->assertSee('<span>'.$noLogo->name.'</span>', false)
            ->assertSee('hm-marquee__dup', false);

        $this->assertSame(2, substr_count($response->getContent(), 'href="'.route('company.show.page', $withLogo).'"'));
    }

    #[Test]
    public function creators_block_shows_top_four_with_games_only(): void
    {
        $busy = Creator::factory()->create(['first_name' => 'Busy', 'last_name' => 'Creator']);
        Game::factory()->count(3)->create(['creator_id' => $busy->id]);
        $idle = Creator::factory()->create(['first_name' => 'Idle', 'last_name' => 'Creator']);

        foreach (range(1, 5) as $i) {
            $other = Creator::factory()->create();
            Game::factory()->create(['creator_id' => $other->id]);
        }

        $this->get(route('home.page'))
            ->assertViewHas('creators', fn ($creators): bool => $creators->count() === 4 && $creators->first()->is($busy))
            ->assertSee('href="'.route('creator.show.page', $busy).'"', false)
            ->assertDontSee('Idle Creator');
    }

    // ---------- відгуки ----------

    #[Test]
    public function comments_feed_links_to_games_escapes_text_and_skips_orphans(): void
    {
        $game = $this->game('Reviewed Game');
        Comment::create(['name' => 'Mallory', 'content' => '<script>alert(1)</script>', 'game_id' => $game->id]);
        Comment::create(['name' => 'Orphan', 'content' => 'Game was deleted', 'game_id' => 99999]);

        $this->get(route('home.page'))
            ->assertSee('href="'.route('games.show.page', $game).'#comments"', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('Game was deleted');
    }

    #[Test]
    public function comments_feed_is_limited_to_six_newest(): void
    {
        $game = $this->game('Popular');

        foreach (range(1, 8) as $i) {
            Comment::create(['name' => "User $i", 'content' => "Review number $i", 'game_id' => $game->id]);
        }

        $this->get(route('home.page'))
            ->assertViewHas('comments', fn ($comments): bool => $comments->count() === 6)
            ->assertSee('Review number 8')
            ->assertDontSee('Review number 2<', false);
    }

    // ---------- спільнота, анімації, редірект, SEO ----------

    #[Test]
    public function community_buttons_use_configured_urls(): void
    {
        config(['services.social.discord' => 'https://discord.example/invite']);

        $this->get(route('home.page'))
            ->assertSee('href="https://discord.example/invite" target="_blank" rel="noopener noreferrer"', false);
    }

    #[Test]
    public function animation_hidden_state_applies_only_when_javascript_adds_its_class(): void
    {
        $this->get(route('home.page'))->assertSee("document.documentElement.classList.add('hm-js')", false);

        $css = file_get_contents(public_path('assets/css/home.css'));

        $this->assertStringContainsString('.hm-js .hm-reveal', $css);
        $this->assertDoesNotMatchRegularExpression('/^\.hm-reveal\s*\{/m', $css);
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $css);
    }

    #[Test]
    public function legacy_category_filter_redirects_to_catalog(): void
    {
        $this->get(route('home.page', ['category_id' => 3]))
            ->assertStatus(301)
            ->assertRedirect(route('games.page', ['category' => 3]));

        $this->get(route('home.page', ['category_id' => 'abc']))->assertOk();
    }

    #[Test]
    public function seo_meta_and_website_structured_data_are_present(): void
    {
        $response = $this->get(route('home.page'));

        $response->assertSee('property="og:title" content="'.__('home.meta_title').'"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('rel="canonical" href="'.route('home.page').'"', false)
            ->assertSee('hreflang="uk"', false)
            ->assertSee('hreflang="en"', false);

        $data = $this->structuredData($response->getContent());

        $this->assertSame('WebSite', $data['@type']);
        $this->assertSame(route('games.page').'?q={search_term_string}', $data['potentialAction']['target']['urlTemplate']);
    }

    #[Test]
    public function empty_site_renders_hero_without_empty_sections(): void
    {
        $this->get(route('home.page'))
            ->assertOk()
            ->assertSee('data-hm-video', false)
            ->assertDontSee('id="trending"', false)
            ->assertDontSee('hm-genres', false)
            ->assertDontSee('hm-marquee', false)
            ->assertDontSee('hm-people', false)
            ->assertDontSee('hm-reviews', false);
    }

    #[Test]
    public function swiper_is_no_longer_loaded_on_any_public_page(): void
    {
        $this->assertFileDoesNotExist(public_path('assets/js/swiper/swiper.js'));

        foreach ([route('home.page'), route('games.page'), route('creator.page'), route('company.page')] as $url) {
            $this->get($url)->assertOk()->assertDontSee('swiper', false);
        }
    }

    #[Test]
    public function page_does_not_run_per_item_queries(): void
    {
        $genre = Category::factory()->create();
        $company = Company::factory()->create();
        $creator = Creator::factory()->create(['company_id' => $company->id]);

        foreach (range(1, 12) as $i) {
            $game = Game::factory()->create(['category_id' => $genre->id, 'company_id' => $company->id, 'creator_id' => $creator->id]);
            Comment::create(['name' => "User $i", 'content' => 'Hi', 'game_id' => $game->id]);
        }

        DB::enableQueryLog();
        $this->get(route('home.page'))->assertOk();

        $this->assertLessThanOrEqual(18, count(DB::getQueryLog()));
    }

    #[Test]
    public function english_home_uses_english_labels_and_content(): void
    {
        app()->setLocale('en');

        $this->game('English Title Game');

        $this->get(route('home.page'))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('Discover.', false)
            ->assertSee(__('home.trending_title'))
            ->assertSee('English Title Game');
    }

    #[Test]
    public function translation_files_have_the_same_keys(): void
    {
        $uk = require lang_path('uk/home.php');
        $en = require lang_path('en/home.php');

        $this->assertSame(array_keys(Arr::dot($uk)), array_keys(Arr::dot($en)));
    }
}
