<?php

namespace Tests\Feature\News;

use App\Models\Article;
use App\Models\Company;
use App\Models\Game;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewsArticleTest extends TestCase
{
    use RefreshDatabase;

    private function article(string $title, array $attributes = []): Article
    {
        return Article::factory()->create(['title' => ['uk' => $title, 'en' => $title], ...$attributes]);
    }

    /**
     * @return array<string, mixed>
     */
    private function structuredData(string $html): array
    {
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches));

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
    }

    // ---------- сторінка ----------

    #[Test]
    public function published_article_renders_title_date_reading_time_and_tags(): void
    {
        $tag = Tag::factory()->create(['name' => ['uk' => 'Огляди', 'en' => 'Reviews']]);
        $article = $this->article('Big announcement', ['published_at' => '2026-03-05 10:00:00']);
        $article->tags()->attach($tag);

        $this->get(route('news.show.page', $article))
            ->assertOk()
            ->assertViewIs('pages.news.show')
            ->assertSee('Big announcement')
            ->assertSee('2026')
            ->assertSee(__('news.min_read', ['count' => 1]))
            ->assertSee('href="'.route('news.page', ['tag' => 'reviews']).'"', false)
            ->assertSee('data-nw-share', false)
            ->assertSee('data-nw-progress', false)
            ->assertSee('assets/js/news/news.js', false);
    }

    #[Test]
    public function unknown_draft_and_scheduled_articles_are_404_for_guests(): void
    {
        $draft = Article::factory()->draft()->create();
        $scheduled = Article::factory()->scheduled()->create();

        $this->get(route('news.show.page', ['article' => 'no-such-article']))->assertNotFound();
        $this->get(route('news.show.page', $draft))->assertNotFound();
        $this->get(route('news.show.page', $scheduled))->assertNotFound();
    }

    #[Test]
    public function admin_can_preview_drafts_and_scheduled_articles_with_a_notice(): void
    {
        $draft = Article::factory()->draft()->create();
        $scheduled = Article::factory()->scheduled()->create();

        $this->actingAs(User::factory()->create());

        $this->get(route('news.show.page', $draft))->assertOk()->assertSee(__('news.draft_notice'));
        $this->get(route('news.show.page', $scheduled))->assertOk()
            ->assertSee(__('news.scheduled_notice', ['date' => $scheduled->published_at->translatedFormat('j F Y, H:i')]));
    }

    #[Test]
    public function published_article_has_no_preview_notice(): void
    {
        $article = Article::factory()->create();

        $this->get(route('news.show.page', $article))
            ->assertDontSee(__('news.draft_notice'))
            ->assertDontSee('nw-notice', false);
    }

    // ---------- Markdown ----------

    #[Test]
    public function markdown_body_is_rendered_and_hostile_content_is_neutralized(): void
    {
        $body = "## Section heading\n\nText with **bold**.\n\n<script>alert('x')</script>\n\n[bad](javascript:alert(1)) and [good](https://example.org/page)";
        $article = $this->article('Markdown story', ['body' => ['uk' => $body, 'en' => $body]]);

        $response = $this->get(route('news.show.page', $article));

        $response->assertSee('<h2>Section heading</h2>', false)
            ->assertSee('<strong>bold</strong>', false)
            ->assertDontSee("<script>alert('x')</script>", false)
            ->assertDontSee('javascript:alert', false)
            ->assertSee('href="https://example.org/page"', false)
            ->assertSee('rel="noopener noreferrer"', false);
    }

    // ---------- пов'язані сутності ----------

    #[Test]
    public function linked_games_and_studios_are_shown_with_links(): void
    {
        $game = Game::factory()->create(['name' => ['uk' => 'Згадана гра', 'en' => 'Mentioned Game']]);
        $company = Company::factory()->create(['name' => ['uk' => 'Згадана студія', 'en' => 'Mentioned Studio']]);
        $article = $this->article('Linked story');
        $article->games()->attach($game);
        $article->companies()->attach($company);

        $this->get(route('news.show.page', $article))
            ->assertSee(__('news.mentioned_games'))
            ->assertSee('href="'.route('games.show.page', $game).'"', false)
            ->assertSee(__('news.mentioned_studios'))
            ->assertSee('href="'.route('company.show.page', $company).'"', false);
    }

    #[Test]
    public function linked_blocks_are_hidden_when_empty(): void
    {
        $article = $this->article('Plain story');

        $this->get(route('news.show.page', $article))
            ->assertDontSee(__('news.mentioned_games'))
            ->assertDontSee(__('news.mentioned_studios'));
    }

    // ---------- читайте також ----------

    #[Test]
    public function read_next_excludes_self_prefers_shared_tags_and_is_limited_to_three(): void
    {
        $tag = Tag::factory()->create(['name' => ['uk' => 'Тема', 'en' => 'Topic']]);
        $main = $this->article('Main story', ['published_at' => now()->subDays(10)]);
        $main->tags()->attach($tag);

        $related = $this->article('Related by tag', ['published_at' => now()->subDays(9)]);
        $related->tags()->attach($tag);

        foreach (range(1, 4) as $i) {
            $this->article("Unrelated $i", ['published_at' => now()->subDays($i)]);
        }

        Article::factory()->draft()->create(['title' => ['uk' => 'Draft related', 'en' => 'Draft related']])->tags()->attach($tag);

        $this->get(route('news.show.page', $main))
            ->assertViewHas('related', fn ($items): bool => $items->count() === 3
                && $items->first()->is($related)
                && ! $items->contains('id', $main->id)
                && $items->doesntContain(fn ($a) => $a->getTranslation('title', 'en') === 'Draft related'))
            ->assertSee(__('news.read_next'));
    }

    #[Test]
    public function read_next_is_hidden_when_there_are_no_other_published_articles(): void
    {
        $article = $this->article('Lonely story');

        $this->get(route('news.show.page', $article))->assertDontSee(__('news.read_next'));
    }

    // ---------- SEO ----------

    #[Test]
    public function seo_meta_and_news_article_structured_data_are_present(): void
    {
        $tag = Tag::factory()->create(['name' => ['uk' => 'Огляди', 'en' => 'Reviews']]);
        $article = $this->article('SEO story', ['published_at' => '2026-03-05 10:00:00']);
        $article->tags()->attach($tag);

        $response = $this->get(route('news.show.page', $article));

        $response->assertSee('property="og:title" content="SEO story"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('rel="canonical" href="'.route('news.show.page', $article).'"', false)
            ->assertSee('hreflang="uk"', false)
            ->assertSee('hreflang="en"', false);

        $data = $this->structuredData($response->getContent());

        $this->assertSame('NewsArticle', $data['@type']);
        $this->assertSame('SEO story', $data['headline']);
        $this->assertSame('Огляди', $data['keywords']);
        $this->assertStringStartsWith('2026-03-05', $data['datePublished']);
    }

    #[Test]
    public function hostile_title_cannot_break_out_of_structured_data(): void
    {
        $evil = '</script><script>alert(1)</script>';
        $article = $this->article($evil);

        $response = $this->get(route('news.show.page', $article));

        $response->assertOk()->assertDontSee('<script>alert(1)</script>', false);
        $this->assertSame(1, substr_count($response->getContent(), 'application/ld+json'));
        $this->assertSame($evil, $this->structuredData($response->getContent())['headline']);
    }

    // ---------- загальне ----------

    #[Test]
    public function page_does_not_run_per_item_queries(): void
    {
        $tag = Tag::factory()->create();
        $main = Article::factory()->create();
        $main->tags()->attach($tag);
        $main->games()->attach(Game::factory()->count(4)->create());
        $main->companies()->attach(Company::factory()->count(3)->create());

        Article::factory()->count(6)->create()->each(fn (Article $a) => $a->tags()->attach($tag));

        DB::enableQueryLog();
        $this->get(route('news.show.page', $main))->assertOk();

        $this->assertLessThanOrEqual(16, count(DB::getQueryLog()));
    }

    #[Test]
    public function english_article_uses_english_content_and_labels(): void
    {
        app()->setLocale('en');

        $article = Article::factory()->create([
            'title' => ['uk' => 'Українська назва', 'en' => 'English headline'],
            'excerpt' => ['uk' => 'Український анонс', 'en' => 'English excerpt'],
            'body' => ['uk' => 'Український текст', 'en' => 'English body text'],
        ]);

        $this->get(route('news.show.page', $article))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('English headline')
            ->assertSee('English excerpt')
            ->assertSee('English body text')
            ->assertDontSee('Український текст')
            ->assertSee('Published');
    }

    // ---------- RSS ----------

    #[Test]
    public function rss_feed_lists_only_published_articles_as_valid_xml(): void
    {
        $this->article('Feed story one', ['published_at' => now()->subDays(2)]);
        $latest = $this->article('Feed story two', ['published_at' => now()->subDay()]);
        Article::factory()->draft()->create(['title' => ['uk' => 'Feed draft', 'en' => 'Feed draft']]);

        $response = $this->get(route('news.feed.page'));

        $response->assertOk()->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');

        $xml = simplexml_load_string($response->getContent());

        $this->assertNotFalse($xml);
        $this->assertSame('2.0', (string) $xml['version']);
        $this->assertCount(2, $xml->channel->item);
        $this->assertSame('Feed story two', (string) $xml->channel->item[0]->title);
        $this->assertSame(route('news.show.page', $latest), (string) $xml->channel->item[0]->link);
        $this->assertStringNotContainsString('Feed draft', $response->getContent());
    }

    #[Test]
    public function rss_feed_escapes_content_and_is_limited_to_twenty_items(): void
    {
        $this->article('Tom & <b>Jerry</b> "story"', ['excerpt' => ['uk' => 'A & B < C', 'en' => 'A & B < C']]);
        Article::factory()->count(24)->create();

        $response = $this->get(route('news.feed.page'));

        $xml = simplexml_load_string($response->getContent());

        $this->assertNotFalse($xml);
        $this->assertCount(20, $xml->channel->item);
        $this->assertStringNotContainsString('<b>Jerry</b>', $response->getContent());
    }

    #[Test]
    public function feed_is_not_treated_as_an_article_slug(): void
    {
        Article::factory()->create(['slug' => 'real-article']);

        $this->get('/news/feed')->assertOk()->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
        $this->get('/news/real-article')->assertOk();
    }
}
