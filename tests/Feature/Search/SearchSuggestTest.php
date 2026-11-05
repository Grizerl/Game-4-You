<?php

namespace Tests\Feature\Search;

use App\Services\Search\SearchResult;
use App\Services\Search\SearchService;
use App\Services\Search\SearchUnavailableException;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SearchSuggestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['search.enabled' => true]);
    }

    private function mockSearch(callable $configure): void
    {
        $this->mock(SearchService::class, function (MockInterface $mock) use ($configure): void {
            $mock->shouldReceive('enabled')->andReturn(true)->byDefault();
            $configure($mock);
        });
    }

    private function sample(): SearchResult
    {
        return SearchResult::fromHit(['_source' => [
            'type' => 'game', 'model_id' => '7', 'slug' => 'cyber-quest',
            'title' => ['uk' => 'Кібер квест', 'en' => 'Cyber Quest'],
            'card' => ['label' => ['uk' => 'Екшн']],
        ]], 'uk');
    }

    #[Test]
    public function there_is_no_separate_search_page(): void
    {
        $this->assertFalse(\Route::has('search.page'));
        $this->get('/search?q=game')->assertNotFound();
    }

    #[Test]
    public function it_returns_items_with_type_title_label_and_url(): void
    {
        $this->mockSearch(fn (MockInterface $mock) => $mock->shouldReceive('suggest')->once()->andReturn([$this->sample()]));

        $this->getJson(route('search.suggest', ['q' => 'кібер']))
            ->assertOk()
            ->assertExactJson(['items' => [[
                'type' => 'game',
                'title' => 'Кібер квест',
                'label' => 'Екшн',
                'url' => route('games.show.page', 'cyber-quest'),
            ]]]);
    }

    #[Test]
    public function nothing_found_is_an_empty_list(): void
    {
        $this->mockSearch(fn (MockInterface $mock) => $mock->shouldReceive('suggest')->andReturn([]));

        $this->getJson(route('search.suggest', ['q' => 'zzzzzz']))->assertOk()->assertExactJson(['items' => []]);
    }

    #[Test]
    public function missing_empty_blank_and_too_short_queries_are_rejected_without_searching(): void
    {
        $this->mockSearch(fn (MockInterface $mock) => $mock->shouldNotReceive('suggest'));

        foreach ([[], ['q' => ''], ['q' => '    '], ['q' => 'к'], ['q' => ' к ']] as $params) {
            $this->getJson(route('search.suggest', $params))
                ->assertStatus(422)
                ->assertJsonValidationErrors('q');
        }
    }

    #[Test]
    public function long_query_is_truncated_and_whitespace_normalized(): void
    {
        $this->mockSearch(fn (MockInterface $mock) => $mock->shouldReceive('suggest')
            ->withArgs(fn (string $q): bool => mb_strlen($q) === 100 && ! str_contains($q, '  '))
            ->once()
            ->andReturn([]));

        $this->getJson(route('search.suggest', ['q' => str_repeat('а  ', 200)]))->assertOk();
    }

    #[Test]
    public function engine_failure_gives_503_without_technical_details(): void
    {
        $this->mockSearch(fn (MockInterface $mock) => $mock->shouldReceive('suggest')->andThrow(new SearchUnavailableException('secret-details')));

        $this->getJson(route('search.suggest', ['q' => 'кібер']))
            ->assertStatus(503)
            ->assertExactJson(['items' => []])
            ->assertDontSee('secret-details');
    }

    #[Test]
    public function disabled_search_gives_503(): void
    {
        config(['search.enabled' => false]);

        $this->getJson(route('search.suggest', ['q' => 'кібер']))->assertStatus(503);
    }

    #[Test]
    public function it_is_rate_limited(): void
    {
        $this->mockSearch(fn (MockInterface $mock) => $mock->shouldReceive('suggest')->andReturn([]));

        for ($i = 0; $i < 30; $i++) {
            $this->getJson(route('search.suggest', ['q' => 'кібер']))->assertOk();
        }

        $this->getJson(route('search.suggest', ['q' => 'кібер']))->assertStatus(429);
    }

    #[Test]
    public function header_has_search_box_and_no_form_action_when_enabled(): void
    {
        $html = $this->get(route('home.page'))->assertOk()->getContent();

        $this->assertStringContainsString('data-hs-search', $html);
        $this->assertStringContainsString('id="sh-search-toggle"', $html);
        $this->assertStringContainsString(__('search.placeholder'), $html);
        $this->assertStringNotContainsString('/search?q=', $html);
    }

    #[Test]
    public function header_hides_search_when_disabled(): void
    {
        config(['search.enabled' => false]);

        $this->get(route('home.page'))->assertOk()->assertDontSee('data-hs-search', false);
    }
}
