<?php

namespace Tests\Feature\Companies;

use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    private function company(string $name, array $attributes = []): Company
    {
        return Company::factory()->create(['name' => ['uk' => $name, 'en' => $name], ...$attributes]);
    }

    /**
     * @return array<string, mixed>
     */
    private function structuredData(string $html): array
    {
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches));

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
    }

    #[Test]
    public function existing_slug_renders_profile_and_unknown_returns_404(): void
    {
        $company = $this->company('Big Studio');

        $this->get(route('company.show.page', $company))
            ->assertOk()
            ->assertViewIs('pages.store.show')
            ->assertSee('Big Studio');

        $this->assertStringEndsWith('/company/big-studio', route('company.show.page', $company));
        $this->get(route('company.show.page', ['company' => 'no-such']))->assertNotFound();
    }

    #[Test]
    public function statistics_are_computed_from_real_games_and_creators(): void
    {
        $company = Company::factory()->create();
        $rpg = Category::factory()->create(['title' => ['uk' => 'Рольові', 'en' => 'RPG']]);
        Game::factory()->create(['company_id' => $company->id, 'category_id' => $rpg->id, 'rating' => 100]);
        Game::factory()->create(['company_id' => $company->id, 'category_id' => $rpg->id, 'rating' => 300]);
        Creator::factory()->count(3)->create(['company_id' => $company->id]);

        $this->get(route('company.show.page', $company))
            ->assertOk()
            ->assertViewHas('stats', fn (array $stats): bool => $stats['count'] === 2
                && $stats['creators'] === 3
                && $stats['average'] === 200
                && $stats['max'] === 300
                && $stats['main_genre']->is($rpg))
            ->assertSee('200 ⭐')
            ->assertSee('300 ⭐');
    }

    #[Test]
    public function genre_distribution_shows_percentages(): void
    {
        $company = Company::factory()->create();
        $first = Category::factory()->create();
        $second = Category::factory()->create();
        Game::factory()->count(2)->create(['company_id' => $company->id, 'category_id' => $second->id]);
        Game::factory()->create(['company_id' => $company->id, 'category_id' => $first->id]);

        $this->get(route('company.show.page', $company))->assertSee('67%')->assertSee('33%');
    }

    #[Test]
    public function company_without_games_shows_empty_state(): void
    {
        $company = Company::factory()->create();

        $this->get(route('company.show.page', $company))
            ->assertOk()
            ->assertSee(__('companies.no_games_profile'))
            ->assertDontSee(__('companies.stat_avg_rating'))
            ->assertDontSee(__('companies.games_title'))
            ->assertDontSee(__('companies.genres_title'));
    }

    #[Test]
    public function games_are_listed_newest_first_with_links(): void
    {
        $company = Company::factory()->create();
        Game::factory()->create(['company_id' => $company->id, 'name' => 'Olderone', 'created_at' => now()->subDays(5)]);
        $newer = Game::factory()->create(['company_id' => $company->id, 'name' => 'Newerone', 'created_at' => now()->subDay()]);

        $this->get(route('company.show.page', $company))
            ->assertSeeInOrder(['Newerone', 'Olderone'])
            ->assertSee('href="'.route('games.show.page', $newer->id).'"', false);
    }

    #[Test]
    public function team_lists_company_creators_with_links_and_hides_when_empty(): void
    {
        $company = Company::factory()->create();

        $this->get(route('company.show.page', $company))->assertDontSee(__('companies.team_title'));

        $member = Creator::factory()->create(['company_id' => $company->id, 'first_name' => 'Teammate']);
        Creator::factory()->create(['first_name' => 'Stranger']);

        $this->get(route('company.show.page', $company))
            ->assertSee(__('companies.team_title'))
            ->assertSee('Teammate')
            ->assertDontSee('Stranger')
            ->assertSee('href="'.route('creator.show.page', $member).'"', false);
    }

    #[Test]
    public function previous_and_next_links_respect_boundaries(): void
    {
        [$first, $middle, $last] = Company::factory()->count(3)->create()->all();

        $this->get(route('company.show.page', $first))
            ->assertDontSee('rel="prev"', false)
            ->assertSee('rel="next"', false)
            ->assertSee('href="'.route('company.show.page', $middle).'"', false);

        $this->get(route('company.show.page', $last))
            ->assertSee('rel="prev"', false)
            ->assertDontSee('rel="next"', false);
    }

    #[Test]
    public function only_safe_social_links_are_rendered(): void
    {
        $company = Company::factory()->create(['socials' => [
            'website' => 'https://example.com/studio',
            'x' => 'javascript:alert(1)',
        ]]);

        $this->get(route('company.show.page', $company))
            ->assertSee('href="https://example.com/studio"', false)
            ->assertSee('rel="noopener noreferrer"', false)
            ->assertDontSee('javascript:alert', false)
            ->assertDontSee('aria-label="'.__('companies.social.x').'"', false);
    }

    #[Test]
    public function optional_fields_are_skipped_when_empty(): void
    {
        $company = Company::factory()->create([
            'country' => ['uk' => null, 'en' => null],
            'description' => ['uk' => null, 'en' => null],
            'founded_year' => null,
            'socials' => null,
        ]);

        $this->get(route('company.show.page', $company))
            ->assertOk()
            ->assertDontSee(__('companies.founded'))
            ->assertDontSee(__('companies.about_title'))
            ->assertDontSee('class="cr-social"', false)
            ->assertDontSee('class="cr-bio"', false);
    }

    #[Test]
    public function years_in_business_are_shown(): void
    {
        $company = Company::factory()->create(['founded_year' => now()->year - 20]);

        $this->get(route('company.show.page', $company))
            ->assertSee(__('companies.since', ['year' => now()->year - 20]))
            ->assertSee(trans_choice('companies.years', 20));
    }

    #[Test]
    public function seo_meta_and_structured_data_are_present(): void
    {
        $company = $this->company('Big Studio', ['socials' => ['website' => 'https://example.com/studio']]);

        $response = $this->get(route('company.show.page', $company));

        $response->assertSee('property="og:title" content="Big Studio"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('rel="canonical" href="'.route('company.show.page', $company).'"', false)
            ->assertSee('hreflang="uk"', false)
            ->assertSee('hreflang="en"', false);

        $data = $this->structuredData($response->getContent());

        $this->assertSame('Organization', $data['@type']);
        $this->assertSame('Big Studio', $data['name']);
        $this->assertSame(['https://example.com/studio'], $data['sameAs']);
    }

    #[Test]
    public function hostile_description_cannot_break_out_of_structured_data(): void
    {
        $evil = '</script><script>alert(1)</script>';
        $company = Company::factory()->create(['description' => ['uk' => $evil, 'en' => $evil]]);

        $response = $this->get(route('company.show.page', $company));

        $response->assertOk()->assertDontSee('<script>alert(1)</script>', false);
        $this->assertSame(1, substr_count($response->getContent(), 'application/ld+json'));
        $this->assertSame($evil, $this->structuredData($response->getContent())['description']);
    }

    #[Test]
    public function profile_does_not_run_per_game_queries(): void
    {
        $company = Company::factory()->create();
        Game::factory()->count(10)->create(['company_id' => $company->id]);
        Creator::factory()->count(5)->create(['company_id' => $company->id]);

        DB::enableQueryLog();
        $this->get(route('company.show.page', $company))->assertOk();

        $this->assertLessThanOrEqual(14, count(DB::getQueryLog()));
    }

    #[Test]
    public function uk_and_en_translation_files_have_the_same_keys(): void
    {
        $uk = require lang_path('uk/companies.php');
        $en = require lang_path('en/companies.php');

        $this->assertSame(array_keys(Arr::dot($uk)), array_keys(Arr::dot($en)));
    }

    #[Test]
    public function english_profile_shows_english_content_and_labels(): void
    {
        app()->setLocale('en');

        $company = Company::factory()->create([
            'name' => ['uk' => 'Студія', 'en' => 'English Studio'],
            'description' => ['uk' => 'Український опис', 'en' => 'English description'],
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'founded_year' => now()->year - 1,
        ]);

        $this->get(route('company.show.page', $company))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('English Studio')
            ->assertSee('English description')
            ->assertDontSee('Український опис')
            ->assertSee('Ukraine')
            ->assertSee('1 year')
            ->assertSee('About');
    }
}
