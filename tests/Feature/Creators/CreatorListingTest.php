<?php

namespace Tests\Feature\Creators;

use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatorListingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function listing_renders_cards_linking_to_profiles(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);

        $response = $this->get(route('creator.page'));

        $response->assertOk();
        $response->assertViewIs('pages.creator.creators');
        $response->assertSee('Ivan Petrenko');
        $response->assertSee('href="'.route('creator.show.page', $creator).'"', false);
    }

    #[Test]
    public function card_shows_at_most_three_newest_covers_and_real_games_count(): void
    {
        $creator = Creator::factory()->create();
        Creator::query()->whereKey($creator->id)->update(['games_count' => 40]);

        foreach (['Oldest', 'Older', 'Middle', 'Newer', 'Newest'] as $offset => $name) {
            Game::factory()->create([
                'creator_id' => $creator->id,
                'name' => $name.' game',
                'created_at' => now()->subDays(10 - $offset),
            ]);
        }

        $response = $this->get(route('creator.page'));

        $response->assertSee(trans_choice('creators.games_plural', 5));
        $response->assertDontSee(trans_choice('creators.games_plural', 40));
        $response->assertSee('title="Newest game"', false);
        $response->assertSee('title="Newer game"', false);
        $response->assertSee('title="Middle game"', false);
        $response->assertDontSee('title="Older game"', false);
        $response->assertDontSee('title="Oldest game"', false);
    }

    #[Test]
    public function pages_load_cyrillic_capable_fonts_and_creator_styles(): void
    {
        $creator = Creator::factory()->create();

        foreach ([route('creator.page'), route('creator.show.page', $creator)] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('family=Manrope', false)
                ->assertSee('family=Unbounded', false)
                ->assertSee('resources/scss/public/creators.scss', false);
        }
    }

    #[Test]
    public function creator_without_avatar_shows_placeholder(): void
    {
        Creator::factory()->withoutAvatar()->create();

        $this->get(route('creator.page'))
            ->assertOk()
            ->assertSee('assets/images/creators/placeholder.svg');
    }

    #[Test]
    public function search_filters_by_name_case_insensitively(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);
        Creator::factory()->create(['first_name' => 'Maksym', 'last_name' => 'Koval']);

        $this->get(route('creator.page', ['q' => 'ivan']))
            ->assertOk()
            ->assertSee('Ivan Petrenko')
            ->assertDontSee('Maksym Koval');
    }

    #[Test]
    public function empty_result_shows_message_with_reset_link(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan']);

        $this->get(route('creator.page', ['q' => 'zzzz']))
            ->assertOk()
            ->assertSee(__('creators.nothing_found'))
            ->assertSee(__('creators.reset'));
    }

    #[Test]
    public function wildcard_characters_are_literal(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);

        $this->get(route('creator.page', ['q' => '%']))
            ->assertOk()
            ->assertDontSee('Ivan Petrenko')
            ->assertSee(__('creators.nothing_found'));
    }

    #[Test]
    public function filters_combine_company_role_and_search(): void
    {
        $studio = Company::factory()->create();
        $other = Company::factory()->create();

        Creator::factory()->create([
            'first_name' => 'Match', 'last_name' => 'Alpha', 'company_id' => $studio->id,
            'role' => ['uk' => 'director, writer', 'en' => 'director, writer'],
        ]);
        Creator::factory()->create([
            'first_name' => 'WrongRole', 'last_name' => 'Alpha', 'company_id' => $studio->id,
            'role' => ['uk' => 'artist', 'en' => 'artist'],
        ]);
        Creator::factory()->create([
            'first_name' => 'WrongCompany', 'last_name' => 'Alpha', 'company_id' => $other->id,
            'role' => ['uk' => 'director', 'en' => 'director'],
        ]);

        $this->get(route('creator.page', ['company' => $studio->id]))
            ->assertSee('Match Alpha')->assertSee('WrongRole Alpha')->assertDontSee('WrongCompany Alpha');

        $response = $this->get(route('creator.page', ['company' => $studio->id, 'role' => 'director', 'q' => 'alpha']));

        $response->assertOk()
            ->assertSee('Match Alpha')
            ->assertDontSee('WrongRole Alpha')
            ->assertDontSee('WrongCompany Alpha');
    }

    #[Test]
    public function sorting_by_games_puts_most_productive_first(): void
    {
        $few = Creator::factory()->create(['first_name' => 'Fewgames']);
        $many = Creator::factory()->create(['first_name' => 'Manygames']);
        Game::factory()->count(3)->create(['creator_id' => $many->id]);
        Game::factory()->create(['creator_id' => $few->id]);

        $this->get(route('creator.page', ['sort' => 'games', 'q' => 'games']))
            ->assertSeeInOrder(['Manygames', 'Fewgames']);
    }

    #[Test]
    public function invalid_sort_value_falls_back_to_default(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan']);

        $this->get(route('creator.page', ['sort' => 'drop_table', 'company' => 'abc', 'q' => ['x']]))
            ->assertOk()
            ->assertSee('Ivan');
    }

    #[Test]
    public function pagination_keeps_filters_in_urls(): void
    {
        $studio = Company::factory()->create();
        Creator::factory()->count(13)->create(['company_id' => $studio->id]);
        Creator::factory()->create();

        $response = $this->get(route('creator.page', ['company' => $studio->id, 'sort' => 'name']));

        $response->assertOk();
        $this->assertMatchesRegularExpression(
            '/href="[^"]*company='.$studio->id.'&amp;sort=name&amp;page=2"/',
            $response->getContent()
        );

        $this->get(route('creator.page', ['company' => $studio->id, 'sort' => 'name', 'page' => 2]))
            ->assertOk()
            ->assertViewHas('creators', fn ($creators): bool => $creators->count() === 1);
    }

    #[Test]
    public function stars_block_shows_top_creators_only_on_clean_first_page(): void
    {
        $top = Creator::factory()->create(['first_name' => 'Topstar']);
        Game::factory()->count(2)->create(['creator_id' => $top->id]);

        $this->get(route('creator.page'))
            ->assertSee('cr-stars', false)
            ->assertViewHas('stars', fn ($stars): bool => $stars->pluck('id')->all() === [$top->id]);

        $this->get(route('creator.page', ['q' => 'top']))->assertDontSee('cr-stars', false);
        $this->get(route('creator.page', ['company' => $top->company_id]))->assertDontSee('cr-stars', false);
    }

    #[Test]
    public function stars_block_is_hidden_on_later_pages_and_without_games(): void
    {
        Creator::factory()->count(13)->create();

        $this->get(route('creator.page'))->assertDontSee('cr-stars', false);

        Game::factory()->create(['creator_id' => Creator::first()->id]);

        $this->get(route('creator.page'))->assertSee('cr-stars', false);
        $this->get(route('creator.page', ['page' => 2]))->assertDontSee('cr-stars', false);
    }

    #[Test]
    public function listing_does_not_run_per_creator_queries(): void
    {
        Creator::factory()->count(12)->has(Game::factory()->count(2))->create();

        \DB::enableQueryLog();
        $this->get(route('creator.page'))->assertOk();
        $queries = count(\DB::getQueryLog());

        $this->assertLessThanOrEqual(12, $queries, 'Listing must not issue queries per creator.');
    }
}
