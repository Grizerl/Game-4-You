<?php

namespace Tests\Feature\Games;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GameCatalogTest extends TestCase
{
    use RefreshDatabase;

    private function game(string $name, array $attributes = []): Game
    {
        return Game::factory()->create(['name' => ['uk' => $name, 'en' => $name], ...$attributes]);
    }

    #[Test]
    public function cards_link_to_slug_pages_and_show_genre_rating_and_new_badge(): void
    {
        $genre = Category::factory()->create(['title' => ['uk' => 'Рольові', 'en' => 'RPG']]);
        $game = $this->game('Cyber Quest', ['category_id' => $genre->id, 'rating' => 4321, 'isNew' => true]);

        $this->get(route('games.page'))
            ->assertOk()
            ->assertViewIs('pages.game.games')
            ->assertSee('Cyber Quest')
            ->assertSee('href="'.route('games.show.page', $game).'"', false)
            ->assertSee('4 321')
            ->assertSee(__('games.new_badge'))
            ->assertSee('/games/cyber-quest', false);
    }

    #[Test]
    public function game_without_cover_shows_placeholder(): void
    {
        $this->game('No Cover', ['cover_image' => '']);

        $this->get(route('games.page'))->assertOk()->assertSee('assets/images/games/placeholder.svg');
    }

    #[Test]
    public function pages_load_fonts_and_game_styles(): void
    {
        $this->get(route('games.page'))->assertOk()
            ->assertSee('family=Oswald', false)
            ->assertSee('family=Manrope', false)
            ->assertSee('assets/css/games.css', false)
            ->assertSee('assets/js/games/games.js', false);
    }

    #[Test]
    public function genre_chips_are_wrapped_in_a_scrollable_rail_with_arrow_buttons(): void
    {
        $genre = Category::factory()->create();
        $this->game('Any', ['category_id' => $genre->id]);

        $this->get(route('games.page'))
            ->assertOk()
            ->assertSee('data-gm-chips', false)
            ->assertSee('data-gm-rail', false)
            ->assertSee('data-gm-chips-prev', false)
            ->assertSee('data-gm-chips-next', false)
            ->assertSee(__('games.chips_prev'))
            ->assertSee(__('games.chips_next'));
    }

    #[Test]
    public function search_filters_by_name_and_wildcards_are_literal(): void
    {
        $this->game('Alpha Quest');
        $this->game('Beta Run');

        $this->get(route('games.page', ['q' => 'alpha']))->assertSee('Alpha Quest')->assertDontSee('Beta Run');
        $this->get(route('games.page', ['q' => '%']))->assertDontSee('Alpha Quest')->assertSee(__('games.nothing_found'));
    }

    #[Test]
    public function empty_result_shows_message_with_reset_link(): void
    {
        $this->game('Alpha');

        $this->get(route('games.page', ['q' => 'zzzz']))
            ->assertOk()
            ->assertSee(__('games.nothing_found'))
            ->assertSee(__('games.reset'));
    }

    #[Test]
    public function genre_chips_show_counts_and_filter(): void
    {
        $rpg = Category::factory()->create(['title' => ['uk' => 'Рольові', 'en' => 'Рольові']]);
        $empty = Category::factory()->create(['title' => ['uk' => 'Порожній жанр', 'en' => 'Порожній жанр']]);
        $this->game('In Rpg One', ['category_id' => $rpg->id]);
        $this->game('In Rpg Two', ['category_id' => $rpg->id]);
        $this->game('Elsewhere');

        $response = $this->get(route('games.page', ['category' => $rpg->id]));

        $response->assertSee('In Rpg One')->assertSee('In Rpg Two')->assertDontSee('Elsewhere')
            ->assertSee('<small>2</small>', false)
            ->assertDontSee($empty->title);
        $this->assertMatchesRegularExpression('/gm-chip\s+is-active\s*"[^>]*>\s*Рольові/u', $response->getContent());
    }

    #[Test]
    public function platform_filter_matches_whole_tokens(): void
    {
        $this->game('On Ps5', ['platforms' => 'PC, PS5']);
        $this->game('On Ps4', ['platforms' => 'PS4']);

        $this->get(route('games.page', ['platform' => 'PS5']))->assertSee('On Ps5')->assertDontSee('On Ps4');
        $this->get(route('games.page', ['platform' => 'PS']))->assertDontSee('On Ps5')->assertDontSee('On Ps4');
    }

    #[Test]
    public function filters_combine(): void
    {
        $rpg = Category::factory()->create();
        $this->game('Match Alpha', ['category_id' => $rpg->id, 'platforms' => 'PC']);
        $this->game('Wrong Platform Alpha', ['category_id' => $rpg->id, 'platforms' => 'PS5']);
        $this->game('Wrong Genre Alpha', ['platforms' => 'PC']);

        $this->get(route('games.page', ['q' => 'alpha', 'category' => $rpg->id, 'platform' => 'PC']))
            ->assertSee('Match Alpha')
            ->assertDontSee('Wrong Platform Alpha')
            ->assertDontSee('Wrong Genre Alpha');
    }

    #[Test]
    public function sorting_by_rating_and_invalid_values(): void
    {
        $this->game('Lowrated', ['rating' => 100]);
        $this->game('Toprated', ['rating' => 9000]);

        $this->get(route('games.page', ['sort' => 'rating']))->assertSeeInOrder(['Toprated', 'Lowrated']);
        $this->get(route('games.page', ['sort' => 'drop_table', 'category' => 'abc', 'q' => ['x'], 'platform' => ['y']]))
            ->assertOk()
            ->assertSee('Lowrated');
    }

    #[Test]
    public function pagination_keeps_filters_in_urls(): void
    {
        Game::factory()->count(13)->create(['platforms' => 'PC']);

        $response = $this->get(route('games.page', ['platform' => 'PC', 'sort' => 'rating']));

        $this->assertMatchesRegularExpression('/href="[^"]*platform=PC&amp;sort=rating&amp;page=2"/', $response->getContent());

        $this->get(route('games.page', ['platform' => 'PC', 'sort' => 'rating', 'page' => 2]))
            ->assertViewHas('games', fn ($page): bool => $page->count() === 1);
    }

    #[Test]
    public function catalog_does_not_run_per_game_queries(): void
    {
        Game::factory()->count(12)->create();

        DB::enableQueryLog();
        $this->get(route('games.page'))->assertOk();

        $this->assertLessThanOrEqual(12, count(DB::getQueryLog()));
    }

    #[Test]
    public function english_catalog_uses_english_labels(): void
    {
        app()->setLocale('en');

        $this->game('Alpha');

        $this->get(route('games.page'))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('1 game')
            ->assertSee('Top rated');
    }
}
