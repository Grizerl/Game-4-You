<?php

namespace Tests\Feature\Search;

use App\Jobs\Search\IndexModelJob;
use App\Jobs\Search\ReindexDependentsJob;
use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Game;
use App\Services\Search\DocumentMapper;
use App\Services\Search\SearchClient;
use App\Services\Search\SearchIndexer;
use App\Services\Search\SearchUnavailableException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SearchSyncTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function nothing_is_queued_when_search_is_disabled(): void
    {
        Queue::fake();
        config(['search.enabled' => false]);

        Game::factory()->create();

        Queue::assertNothingPushed();
    }

    #[Test]
    public function saving_and_deleting_models_queue_index_jobs(): void
    {
        config(['search.enabled' => true]);
        Queue::fake();

        $game = Game::factory()->create();

        Queue::assertPushed(IndexModelJob::class, fn (IndexModelJob $job): bool => $job->type === 'game' && $job->id === $game->id);

        Queue::fake();
        $game->delete();

        Queue::assertPushed(IndexModelJob::class, fn (IndexModelJob $job): bool => $job->type === 'game' && $job->id === $game->id);
    }

    #[Test]
    public function changing_a_category_or_company_reindexes_dependents(): void
    {
        config(['search.enabled' => true]);
        Queue::fake();

        $category = Category::factory()->create();
        $company = Company::factory()->create();

        Queue::assertPushed(ReindexDependentsJob::class, fn (ReindexDependentsJob $job): bool => $job->type === 'category' && $job->id === $category->id);
        Queue::assertPushed(ReindexDependentsJob::class, fn (ReindexDependentsJob $job): bool => $job->type === 'company' && $job->id === $company->id);
    }

    #[Test]
    public function saving_a_model_succeeds_when_the_queue_is_unreachable(): void
    {
        // Черга sync виконує джоб одразу; Elasticsearch недосяжний — збереження все одно успішне.
        config(['search.enabled' => true, 'search.hosts' => ['http://127.0.0.1:1']]);

        $game = Game::factory()->create();

        $this->assertDatabaseHas('games', ['id' => $game->id]);
    }

    #[Test]
    public function index_job_throws_for_retry_when_engine_is_unreachable(): void
    {
        config(['search.enabled' => false]);
        $game = Game::factory()->create();

        config(['search.enabled' => true, 'search.hosts' => ['http://127.0.0.1:1']]);

        $this->expectException(SearchUnavailableException::class);

        (new IndexModelJob('game', $game->id))->handle(app(SearchIndexer::class));
    }

    #[Test]
    public function unpublished_news_are_not_mapped(): void
    {
        $mapper = new DocumentMapper;

        $this->assertNull($mapper->map(Article::factory()->draft()->create()));
        $this->assertNull($mapper->map(Article::factory()->scheduled()->create()));
        $this->assertSame('news', $mapper->map(Article::factory()->create()->load('tags'))['type']);
    }

    #[Test]
    public function mapper_builds_document_with_both_languages_and_tolerates_missing_translation(): void
    {
        $game = Game::factory()->create([
            'name' => ['uk' => 'Кібер квест', 'en' => 'Cyber Quest'],
            'description' => ['uk' => 'Опис <b>гри</b>'],
        ]);

        $document = (new DocumentMapper)->map($game->fresh());

        $this->assertSame('game', $document['type']);
        $this->assertSame((string) $game->id, $document['model_id']);
        $this->assertSame($game->slug, $document['slug']);
        $this->assertSame(['uk' => 'Кібер квест', 'en' => 'Cyber Quest'], $document['title']);
        $this->assertSame(['uk' => 'Опис гри'], $document['body']);
        $this->assertSame('game-'.$game->id, DocumentMapper::documentId('game', $game->id));
    }

    #[Test]
    public function disabled_client_refuses_calls(): void
    {
        config(['search.enabled' => false]);

        $this->expectException(SearchUnavailableException::class);

        app(SearchClient::class)->call(fn () => 'never');
    }
}
