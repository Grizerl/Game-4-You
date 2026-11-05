<?php

namespace Tests\Feature\Companies;

use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CompanyListingTest extends TestCase
{
    use RefreshDatabase;

    private function company(string $name, array $attributes = []): Company
    {
        return Company::factory()->create(['name' => ['uk' => $name, 'en' => $name], ...$attributes]);
    }

    #[Test]
    public function cards_link_to_profiles_and_show_counts(): void
    {
        $company = $this->company('Big Studio');
        Game::factory()->count(5)->create(['company_id' => $company->id]);
        Creator::factory()->count(2)->create(['company_id' => $company->id]);

        $response = $this->get(route('company.page'));

        $response->assertOk()
            ->assertViewIs('pages.store.stores')
            ->assertSee('Big Studio')
            ->assertSee('href="'.route('company.show.page', $company).'"', false)
            ->assertSee(trans_choice('companies.games_plural', 5))
            ->assertSee(trans_choice('companies.creators_plural', 2));
    }

    #[Test]
    public function card_shows_at_most_three_newest_covers(): void
    {
        $company = $this->company('Covers');

        foreach (['Oldest', 'Older', 'Middle', 'Newer', 'Newest'] as $offset => $name) {
            Game::factory()->create([
                'company_id' => $company->id,
                'name' => $name.' game',
                'created_at' => now()->subDays(10 - $offset),
            ]);
        }

        $this->get(route('company.page'))
            ->assertSee('title="Newest game"', false)
            ->assertSee('title="Newer game"', false)
            ->assertSee('title="Middle game"', false)
            ->assertDontSee('title="Older game"', false)
            ->assertDontSee('title="Oldest game"', false);
    }

    #[Test]
    public function company_without_logo_shows_placeholder(): void
    {
        Company::factory()->withoutLogo()->create();

        $this->get(route('company.page'))->assertOk()->assertSee('assets/images/companies/placeholder.svg');
    }

    #[Test]
    public function pages_load_fonts_and_company_styles(): void
    {
        $company = Company::factory()->create();

        foreach ([route('company.page'), route('company.show.page', $company)] as $url) {
            $this->get($url)->assertOk()
                ->assertSee('family=Manrope', false)
                ->assertSee('family=Unbounded', false)
                ->assertSee('assets/css/creators.css', false)
                ->assertSee('assets/css/companies.css', false);
        }
    }

    #[Test]
    public function search_filters_by_name_case_insensitively(): void
    {
        $this->company('Alpha Games');
        $this->company('Beta Works');

        $this->get(route('company.page', ['q' => 'alpha']))
            ->assertOk()
            ->assertSee('Alpha Games')
            ->assertDontSee('Beta Works');
    }

    #[Test]
    public function empty_result_shows_message_with_reset_link(): void
    {
        $this->company('Alpha');

        $this->get(route('company.page', ['q' => 'zzzz']))
            ->assertOk()
            ->assertSee(__('companies.nothing_found'))
            ->assertSee(__('companies.reset'));
    }

    #[Test]
    public function wildcard_characters_are_literal(): void
    {
        $this->company('Alpha Games');

        $this->get(route('company.page', ['q' => '%']))
            ->assertDontSee('Alpha Games')
            ->assertSee(__('companies.nothing_found'));
    }

    #[Test]
    public function country_filter_and_search_combine(): void
    {
        $this->company('Polish Alpha', ['country' => ['uk' => 'Польща', 'en' => 'Польща']]);
        $this->company('Ukrainian Alpha', ['country' => ['uk' => 'Україна', 'en' => 'Україна']]);
        $this->company('Ukrainian Beta', ['country' => ['uk' => 'Україна', 'en' => 'Україна']]);

        $this->get(route('company.page', ['country' => 'Україна']))
            ->assertSee('Ukrainian Alpha')->assertSee('Ukrainian Beta')->assertDontSee('Polish Alpha');

        $this->get(route('company.page', ['country' => 'Україна', 'q' => 'alpha']))
            ->assertSee('Ukrainian Alpha')->assertDontSee('Ukrainian Beta')->assertDontSee('Polish Alpha');
    }

    #[Test]
    public function sorting_by_games_puts_most_productive_first(): void
    {
        $few = $this->company('Fewgames');
        $many = $this->company('Manygames');
        Game::factory()->count(3)->create(['company_id' => $many->id]);
        Game::factory()->create(['company_id' => $few->id]);

        $this->get(route('company.page', ['sort' => 'games', 'q' => 'games']))
            ->assertSeeInOrder(['Manygames', 'Fewgames']);
    }

    #[Test]
    public function invalid_parameters_fall_back_to_defaults(): void
    {
        $this->company('Alpha');

        $this->get(route('company.page', ['sort' => 'drop_table', 'country' => ['x'], 'q' => ['x']]))
            ->assertOk()
            ->assertSee('Alpha');
    }

    #[Test]
    public function pagination_keeps_filters_in_urls(): void
    {
        Company::factory()->count(13)->create(['country' => ['uk' => 'Польща', 'en' => 'Польща']]);
        Company::factory()->create();

        $response = $this->get(route('company.page', ['country' => 'Польща', 'sort' => 'name']));

        $this->assertMatchesRegularExpression(
            '/href="[^"]*country=[^"]+&amp;sort=name&amp;page=2"/',
            $response->getContent()
        );

        $this->get(route('company.page', ['country' => 'Польща', 'sort' => 'name', 'page' => 2]))
            ->assertViewHas('companies', fn ($page): bool => $page->count() === 1);
    }

    #[Test]
    public function top_block_shows_only_on_clean_first_page_and_only_with_games(): void
    {
        $this->company('Alpha');
        $this->get(route('company.page'))->assertDontSee('co-top-title', false);

        $top = $this->company('Topstudio');
        Game::factory()->count(2)->create(['company_id' => $top->id]);

        $this->get(route('company.page'))
            ->assertSee('co-top-title', false)
            ->assertViewHas('top', fn ($top_): bool => $top_->pluck('id')->all() === [$top->id]);

        $this->get(route('company.page', ['q' => 'top']))->assertDontSee('co-top-title', false);
        $this->get(route('company.page', ['country' => 'Україна']))->assertDontSee('co-top-title', false);
    }

    #[Test]
    public function top_block_is_hidden_on_later_pages(): void
    {
        $companies = Company::factory()->count(13)->create();
        Game::factory()->create(['company_id' => $companies->first()->id]);

        $this->get(route('company.page'))->assertSee('co-top-title', false);
        $this->get(route('company.page', ['page' => 2]))->assertDontSee('co-top-title', false);
    }

    #[Test]
    public function listing_does_not_run_per_company_queries(): void
    {
        Company::factory()->count(12)->has(Game::factory()->count(2), 'games')->create();

        DB::enableQueryLog();
        $this->get(route('company.page'))->assertOk();

        $this->assertLessThanOrEqual(12, count(DB::getQueryLog()));
    }
}
