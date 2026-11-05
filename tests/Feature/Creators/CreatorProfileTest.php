<?php

namespace Tests\Feature\Creators;

use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatorProfileTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function existing_slug_renders_profile(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);

        $this->get(route('creator.show.page', $creator))
            ->assertOk()
            ->assertViewIs('pages.creator.show')
            ->assertSee('Ivan Petrenko');
    }

    #[Test]
    public function unknown_slug_returns_404(): void
    {
        $this->get(route('creator.show.page', ['creator' => 'no-such-creator']))->assertNotFound();
    }

    #[Test]
    public function profile_url_uses_slug_not_id(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);

        $this->assertStringEndsWith('/creators/ivan-petrenko', route('creator.show.page', $creator));
    }

    #[Test]
    public function statistics_are_computed_from_real_games(): void
    {
        $creator = Creator::factory()->create();
        $rpg = Category::factory()->create(['title' => ['uk' => 'Рольові', 'en' => 'RPG']]);
        Game::factory()->create(['creator_id' => $creator->id, 'category_id' => $rpg->id, 'rating' => 100]);
        Game::factory()->create(['creator_id' => $creator->id, 'category_id' => $rpg->id, 'rating' => 300]);

        $response = $this->get(route('creator.show.page', $creator));

        $response->assertOk()
            ->assertViewHas('stats', fn (array $stats): bool => $stats['count'] === 2
                && $stats['average'] === 200
                && $stats['max'] === 300
                && $stats['main_genre']->is($rpg))
            ->assertSee('200 ⭐')
            ->assertSee('300 ⭐');
    }

    #[Test]
    public function genre_distribution_shows_percentages_and_breaks_ties_by_lower_id(): void
    {
        $creator = Creator::factory()->create();
        $first = Category::factory()->create();
        $second = Category::factory()->create();
        Game::factory()->count(2)->create(['creator_id' => $creator->id, 'category_id' => $second->id]);
        Game::factory()->create(['creator_id' => $creator->id, 'category_id' => $first->id]);

        $this->get(route('creator.show.page', $creator))
            ->assertSee('67%')
            ->assertSee('33%')
            ->assertViewHas('stats', fn (array $stats): bool => $stats['main_genre']->is($second));

        $tied = Creator::factory()->create();
        Game::factory()->create(['creator_id' => $tied->id, 'category_id' => $second->id]);
        Game::factory()->create(['creator_id' => $tied->id, 'category_id' => $first->id]);

        $this->get(route('creator.show.page', $tied))
            ->assertViewHas('stats', fn (array $stats): bool => $stats['main_genre']->is($first));
    }

    #[Test]
    public function creator_without_games_shows_empty_state_instead_of_statistics(): void
    {
        $creator = Creator::factory()->create();

        $this->get(route('creator.show.page', $creator))
            ->assertOk()
            ->assertSee(__('creators.no_games_profile'))
            ->assertDontSee(__('creators.stat_avg_rating'))
            ->assertDontSee(__('creators.timeline_title'))
            ->assertDontSee(__('creators.genres_title'));
    }

    #[Test]
    public function games_are_listed_newest_first_with_links(): void
    {
        $creator = Creator::factory()->create();
        $older = Game::factory()->create(['creator_id' => $creator->id, 'name' => 'Olderone', 'created_at' => now()->subDays(5)]);
        $newer = Game::factory()->create(['creator_id' => $creator->id, 'name' => 'Newerone', 'created_at' => now()->subDay()]);

        $this->get(route('creator.show.page', $creator))
            ->assertSeeInOrder(['Newerone', 'Olderone'])
            ->assertSee('href="'.route('games.show.page', $newer).'"', false)
            ->assertSee('href="'.route('games.show.page', $older).'"', false);
    }

    #[Test]
    public function co_creators_come_from_the_same_company_and_exclude_self(): void
    {
        $studio = Company::factory()->create();
        $me = Creator::factory()->create(['company_id' => $studio->id, 'first_name' => 'Selfy']);
        Creator::factory()->create(['company_id' => $studio->id, 'first_name' => 'Colleague']);
        Creator::factory()->create(['company_id' => $studio->id, 'first_name' => 'Teammate']);
        Creator::factory()->create(['first_name' => 'Stranger']);

        $this->get(route('creator.show.page', $me))
            ->assertViewHas('coCreators', fn ($list): bool => $list->count() === 2)
            ->assertSee('Colleague')
            ->assertSee('Teammate')
            ->assertDontSee('Stranger');
    }

    #[Test]
    public function co_creators_are_limited_to_four_and_hidden_when_alone(): void
    {
        $studio = Company::factory()->create();
        $me = Creator::factory()->create(['company_id' => $studio->id]);

        $this->get(route('creator.show.page', $me))
            ->assertViewHas('coCreators', fn ($list): bool => $list->isEmpty())
            ->assertDontSee(__('creators.co_creators_title'));

        Creator::factory()->count(6)->create(['company_id' => $studio->id]);

        $this->get(route('creator.show.page', $me))
            ->assertViewHas('coCreators', fn ($list): bool => $list->count() === 4)
            ->assertSee(__('creators.co_creators_title'));
    }

    #[Test]
    public function previous_and_next_links_respect_boundaries(): void
    {
        [$first, $middle, $last] = Creator::factory()->count(3)->create()->all();

        $this->get(route('creator.show.page', $first))
            ->assertDontSee('rel="prev"', false)
            ->assertSee('rel="next"', false)
            ->assertSee('href="'.route('creator.show.page', $middle).'"', false);

        $this->get(route('creator.show.page', $middle))
            ->assertSee('rel="prev"', false)
            ->assertSee('rel="next"', false);

        $this->get(route('creator.show.page', $last))
            ->assertSee('rel="prev"', false)
            ->assertDontSee('rel="next"', false);
    }

    #[Test]
    public function only_configured_safe_social_links_are_rendered(): void
    {
        $creator = Creator::factory()->create(['socials' => [
            'website' => 'https://example.com/me',
            'youtube' => 'https://www.youtube.com/@me',
            'x' => 'javascript:alert(1)',
        ]]);

        $response = $this->get(route('creator.show.page', $creator));

        $response->assertSee('href="https://example.com/me"', false)
            ->assertSee('href="https://www.youtube.com/@me"', false)
            ->assertSee('rel="noopener noreferrer"', false)
            ->assertDontSee('javascript:alert', false)
            ->assertDontSee('aria-label="'.__('creators.social.x').'"', false)
            ->assertDontSee('aria-label="'.__('creators.social.twitch').'"', false);
    }

    #[Test]
    public function optional_fields_are_skipped_when_empty(): void
    {
        $creator = Creator::factory()->create([
            'country' => null, 'career_start' => null, 'socials' => null,
            'bio' => ['uk' => null, 'en' => null],
        ]);

        $this->get(route('creator.show.page', $creator))
            ->assertOk()
            ->assertDontSee(__('creators.country'))
            ->assertDontSee(__('creators.career'))
            ->assertDontSee('class="cr-social"', false)
            ->assertDontSee('class="cr-bio"', false);
    }

    #[Test]
    public function years_of_activity_are_shown_when_career_start_is_set(): void
    {
        $creator = Creator::factory()->create(['career_start' => now()->year - 10]);

        $this->get(route('creator.show.page', $creator))
            ->assertSee(__('creators.since', ['year' => now()->year - 10]))
            ->assertSee(trans_choice('creators.years', 10));
    }

    #[Test]
    public function seo_meta_and_structured_data_are_present(): void
    {
        $creator = Creator::factory()->create([
            'first_name' => 'Ivan', 'last_name' => 'Petrenko',
            'socials' => ['website' => 'https://example.com/me'],
        ]);

        $response = $this->get(route('creator.show.page', $creator));

        $response->assertSee('property="og:title" content="Ivan Petrenko"', false)
            ->assertSee('property="og:description"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('property="og:url" content="'.route('creator.show.page', $creator).'"', false)
            ->assertSee('rel="canonical" href="'.route('creator.show.page', $creator).'"', false)
            ->assertSee('hreflang="uk"', false)
            ->assertSee('hreflang="en"', false);

        $data = $this->structuredData($response->getContent());

        $this->assertSame('Person', $data['@type']);
        $this->assertSame('Ivan Petrenko', $data['name']);
        $this->assertSame($creator->company->name, $data['worksFor']['name']);
        $this->assertSame(['https://example.com/me'], $data['sameAs']);
    }

    #[Test]
    public function hostile_bio_cannot_break_out_of_structured_data(): void
    {
        $evil = '</script><script>alert(1)</script>';
        $creator = Creator::factory()->create(['bio' => ['uk' => $evil, 'en' => $evil]]);

        $response = $this->get(route('creator.show.page', $creator));

        $response->assertOk()->assertDontSee('<script>alert(1)</script>', false);
        $this->assertSame(1, substr_count($response->getContent(), 'application/ld+json'));
        $this->assertSame($evil, $this->structuredData($response->getContent())['description']);
    }

    #[Test]
    public function profile_does_not_run_per_game_queries(): void
    {
        $creator = Creator::factory()->create();
        Game::factory()->count(10)->create(['creator_id' => $creator->id]);
        Creator::factory()->count(5)->create(['company_id' => $creator->company_id]);

        \DB::enableQueryLog();
        $this->get(route('creator.show.page', $creator))->assertOk();

        $this->assertLessThanOrEqual(12, count(\DB::getQueryLog()));
    }

    #[Test]
    public function uk_and_en_translation_files_have_the_same_keys(): void
    {
        $uk = require lang_path('uk/creators.php');
        $en = require lang_path('en/creators.php');

        $this->assertSame(array_keys(Arr::dot($uk)), array_keys(Arr::dot($en)));
    }

    /**
     * @return array<string, mixed>
     */
    private function structuredData(string $html): array
    {
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches));

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
    }
}
