<?php

namespace Tests\Feature\Search;

use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Services\Search\SearchClient;
use App\Services\Search\SearchIndexer;
use App\Services\Search\SearchService;
use Elastic\Elasticsearch\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Throwable;

/**
 * Інтеграційні тести проти справжнього Elasticsearch (окремий псевдонім `games4you_test`).
 * Пропускаються, якщо Elasticsearch недоступний.
 */
class ElasticsearchIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private SearchClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'search.enabled' => true,
            'search.hosts' => [env('ELASTICSEARCH_HOST', 'http://elasticsearch-9:9200')],
            'search.index' => 'games4you_test',
        ]);

        $this->app->forgetInstance(SearchClient::class);
        $this->client = app(SearchClient::class);

        try {
            $this->client->call(fn (Client $es) => $es->info());
        } catch (Throwable) {
            $this->markTestSkipped('Elasticsearch is not available.');
        }
    }

    protected function tearDown(): void
    {
        if (isset($this->client)) {
            try {
                $this->client->call(function (Client $es): void {
                    foreach (array_keys($es->indices()->get(['index' => 'games4you_test_v*'])->asArray()) as $index) {
                        $es->indices()->delete(['index' => $index]);
                    }
                });
            } catch (Throwable) {
                // нічого прибирати
            }
        }

        parent::tearDown();
    }

    private function reindex(): array
    {
        $counts = app(SearchIndexer::class)->reindex();
        $this->refresh();

        return $counts;
    }

    private function refresh(): void
    {
        $this->client->call(fn (Client $es) => $es->indices()->refresh(['index' => 'games4you_test']));
    }

    /**
     * @return list<string> Заголовки знайдених документів у порядку релевантності.
     */
    private function titles(string $query, string $locale = 'uk'): array
    {
        return array_map(fn ($item) => $item->title, app(SearchService::class)->suggest($query, $locale));
    }

    private function seedGames(): void
    {
        Game::factory()->create([
            'name' => ['uk' => 'Космічні перегони', 'en' => 'Space Racing'],
            'description' => ['uk' => 'Швидка гонка на кораблях', 'en' => 'Fast ship race'],
        ]);
        Game::factory()->create([
            'name' => ['uk' => 'Лісова пригода', 'en' => 'Forest Adventure'],
            'description' => ['uk' => 'Подорож, де є космічні перегони у фіналі', 'en' => 'A journey with a space racing finale'],
        ]);
    }

    #[Test]
    public function reindex_counts_match_the_database_and_exclude_unpublished_news(): void
    {
        $this->seedGames();
        Category::factory()->create();
        Creator::factory()->create();
        Company::factory()->create();
        Article::factory()->create();
        Article::factory()->draft()->create();
        Article::factory()->scheduled()->create();

        $counts = $this->reindex();

        $this->assertSame(Game::count(), $counts['game']);
        $this->assertSame(Category::count(), $counts['category']);
        $this->assertSame(Creator::count(), $counts['creator']);
        $this->assertSame(Company::count(), $counts['company']);
        $this->assertSame(1, $counts['news']);
    }

    #[Test]
    public function repeated_reindex_leaves_a_single_index_behind_the_alias(): void
    {
        $this->seedGames();

        $this->reindex();
        $this->reindex();

        $indices = $this->client->call(fn (Client $es) => $es->indices()->get(['index' => 'games4you_test_v*'])->asArray());
        $aliased = $this->client->call(fn (Client $es) => $es->indices()->getAlias(['name' => 'games4you_test'])->asArray());

        $this->assertCount(1, $indices);
        $this->assertSame(array_keys($indices), array_keys($aliased));
    }

    #[Test]
    public function title_matches_outrank_description_matches(): void
    {
        $this->seedGames();
        $this->reindex();

        $titles = $this->titles('космічні перегони');

        $this->assertSame('Космічні перегони', $titles[0]);
        $this->assertContains('Лісова пригода', $titles);
    }

    #[Test]
    public function other_word_forms_match(): void
    {
        $this->seedGames();
        $this->reindex();

        $this->assertContains('Космічні перегони', $this->titles('космічних перегонів'));
    }

    #[Test]
    public function a_single_typo_is_tolerated(): void
    {
        $this->seedGames();
        $this->reindex();

        $this->assertContains('Космічні перегони', $this->titles('Spce Racing'));
    }

    #[Test]
    public function english_query_in_ukrainian_interface_finds_the_game_with_ukrainian_title(): void
    {
        $this->seedGames();
        $this->reindex();

        $this->assertContains('Космічні перегони', $this->titles('Space Racing', 'uk'));
        $this->assertContains('Space Racing', $this->titles('Space Racing', 'en'));
    }

    #[Test]
    public function unpublished_news_are_never_found_but_published_ones_are(): void
    {
        Article::factory()->create(['title' => ['uk' => 'Відкрита новина про зорі', 'en' => 'Open star news']]);
        Article::factory()->draft()->create(['title' => ['uk' => 'Секретна чернетка про зорі', 'en' => 'Secret draft about stars']]);
        Article::factory()->scheduled()->create(['title' => ['uk' => 'Запланована новина про зорі', 'en' => 'Scheduled star news']]);
        $this->reindex();

        $titles = $this->titles('зорі');

        $this->assertSame(['Відкрита новина про зорі'], $titles);
    }

    #[Test]
    public function scheduled_news_appear_after_their_publication_date(): void
    {
        $article = Article::factory()->scheduled()->create(['title' => ['uk' => 'Майбутня новина про дракона', 'en' => 'Future dragon news']]);
        $this->reindex();
        $this->assertSame([], $this->titles('дракона'));

        Article::query()->whereKey($article->id)->update(['published_at' => now()->subMinute()]);
        $this->artisan('search:sync-scheduled')->assertSuccessful();
        $this->refresh();

        $this->assertSame(['Майбутня новина про дракона'], $this->titles('дракона'));
    }

    #[Test]
    public function suggestions_match_word_beginnings_and_limit_results(): void
    {
        $this->seedGames();
        $this->reindex();

        $suggestions = $this->titles('Spa', 'en');

        $this->assertContains('Space Racing', $suggestions);
        $this->assertLessThanOrEqual(8, count($suggestions));
    }

    #[Test]
    public function model_changes_are_reflected_after_sync(): void
    {
        $game = Game::factory()->create(['name' => ['uk' => 'Стара назва', 'en' => 'Old name']]);
        $this->reindex();

        $game->update(['name' => ['uk' => 'Нова назва', 'en' => 'New name']]);
        $this->refresh();

        $this->assertContains('Нова назва', $this->titles('Нова назва'));
        $this->assertNotContains('Стара назва', $this->titles('Стара'));

        $game->delete();
        $this->refresh();

        $this->assertSame([], $this->titles('Нова назва'));
    }
}
