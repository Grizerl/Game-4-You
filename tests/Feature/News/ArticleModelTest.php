<?php

namespace Tests\Feature\News;

use App\Models\Article;
use App\Models\Company;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ArticleModelTest extends TestCase
{
    use RefreshDatabase;

    private function article(string $en, array $attributes = []): Article
    {
        return Article::factory()->create(['title' => ['uk' => $en.' UA', 'en' => $en], ...$attributes]);
    }

    private function withBody(string $markdown): Article
    {
        return Article::factory()->make(['body' => ['uk' => $markdown, 'en' => $markdown]]);
    }

    #[Test]
    public function slug_is_generated_from_english_title_and_made_unique(): void
    {
        $first = $this->article('Big News', ['slug' => null]);
        $second = $this->article('Big News', ['slug' => null]);

        $this->assertSame('big-news', $first->slug);
        $this->assertSame('big-news-2', $second->slug);
    }

    #[Test]
    public function slug_falls_back_to_other_language_and_ignores_renames(): void
    {
        $article = Article::factory()->create(['title' => ['uk' => 'Лише українською'], 'slug' => null]);

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $article->slug);

        $slug = $article->slug;
        $article->update(['title' => ['uk' => 'Нова', 'en' => 'Brand New']]);

        $this->assertSame($slug, $article->fresh()->slug);
    }

    #[Test]
    public function reserved_and_numeric_slugs_are_avoided(): void
    {
        $this->assertSame('feed-news', $this->article('Feed', ['slug' => null])->slug);
        $this->assertSame('news-2024', $this->article('2024', ['slug' => null])->slug);
    }

    #[Test]
    public function status_and_published_scope_follow_publication_date(): void
    {
        $published = Article::factory()->create(['published_at' => now()->subHour()]);
        $draft = Article::factory()->draft()->create();
        $scheduled = Article::factory()->scheduled()->create();

        $this->assertSame('published', $published->status());
        $this->assertSame('draft', $draft->status());
        $this->assertSame('scheduled', $scheduled->status());
        $this->assertTrue($published->isPublished());
        $this->assertFalse($draft->isPublished());
        $this->assertFalse($scheduled->isPublished());
        $this->assertSame([$published->id], Article::published()->pluck('id')->all());
    }

    #[Test]
    public function scheduled_article_becomes_published_when_its_time_comes(): void
    {
        $article = Article::factory()->create(['published_at' => now()->addMinutes(10)]);

        $this->assertCount(0, Article::published()->get());

        $this->travel(11)->minutes();

        $this->assertCount(1, Article::published()->get());
        $this->assertSame('published', $article->fresh()->status());
    }

    #[Test]
    public function cover_url_resolves_placeholder_upload_and_storage_paths(): void
    {
        $this->assertSame(asset('assets/images/news/placeholder.svg'), Article::factory()->make(['cover_image' => null])->cover_url);
        $this->assertSame(asset('assets/images/news/a.jpg'), Article::factory()->make(['cover_image' => '/assets/images/news/a.jpg'])->cover_url);
        $this->assertSame(asset('storage/news/a.jpg'), Article::factory()->make(['cover_image' => 'news/a.jpg'])->cover_url);
    }

    #[Test]
    public function markdown_is_rendered_to_html_elements(): void
    {
        $html = $this->withBody("## Heading\n\nSome **bold** text.\n\n- one\n- two\n\n> quote")->bodyHtml();

        $this->assertStringContainsString('<h2>Heading</h2>', $html);
        $this->assertStringContainsString('<strong>bold</strong>', $html);
        $this->assertStringContainsString('<li>two</li>', $html);
        $this->assertStringContainsString('<blockquote>', $html);
    }

    #[Test]
    public function markdown_strips_html_and_blocks_unsafe_links(): void
    {
        $html = $this->withBody("<script>alert(1)</script>\n\n<img src=x onerror=alert(1)>\n\n[click](javascript:alert(1)) and [data](data:text/html;base64,AAAA)")->bodyHtml();

        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('onerror', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('data:text', $html);
    }

    #[Test]
    public function external_links_get_noopener_noreferrer_and_internal_do_not(): void
    {
        $html = $this->withBody('[ext](https://example.org/page) and [own]('.config('app.url').'/games)')->bodyHtml();

        $this->assertMatchesRegularExpression('#<a [^>]*rel="noopener noreferrer"[^>]*href="https://example\.org/page"#', $html);
        $this->assertStringContainsString('<a href="'.config('app.url').'/games">own</a>', $html);
    }

    #[Test]
    public function reading_time_is_at_least_one_minute_and_grows_with_length(): void
    {
        $this->assertSame(1, $this->withBody('Short text')->readingTime());
        $this->assertSame(3, $this->withBody(str_repeat('слово ', 501))->readingTime());
    }

    #[Test]
    public function search_is_partial_case_insensitive_and_literal_for_wildcards(): void
    {
        $this->article('Alpha Launch');
        $this->article('100% Fun');
        $this->article('Beta');

        $titles = fn (?string $q): array => Article::search($q)->get()->map(fn ($a) => $a->getTranslation('title', 'en'))->all();

        $this->assertSame(['Alpha Launch'], $titles('ALPHA'));
        $this->assertSame(['100% Fun'], $titles('%'));
        $this->assertCount(3, Article::search('')->get());
        $this->assertCount(0, Article::search('zzz')->get());
    }

    #[Test]
    public function relations_attach_tags_games_and_companies(): void
    {
        $article = Article::factory()->create();
        $article->tags()->attach(Tag::factory()->count(2)->create());
        $article->games()->attach(Game::factory()->create());
        $article->companies()->attach(Company::factory()->create());

        $article->refresh()->loadCount(['tags', 'games', 'companies']);

        $this->assertSame([2, 1, 1], [$article->tags_count, $article->games_count, $article->companies_count]);
    }

    #[Test]
    public function with_tag_scope_filters_by_slug(): void
    {
        $tag = Tag::factory()->create(['name' => ['uk' => 'Огляди', 'en' => 'Reviews']]);
        $tagged = Article::factory()->create();
        $tagged->tags()->attach($tag);
        Article::factory()->create();

        $this->assertSame([$tagged->id], Article::withTag('reviews')->pluck('id')->all());
        $this->assertCount(2, Article::withTag('')->get());
    }

    #[Test]
    public function tag_input_is_parsed_into_language_pairs_without_duplicates(): void
    {
        $parsed = Tag::parseInput(' Огляди|Reviews , Новини, reviews|Reviews ,, |  ');

        $this->assertSame([
            ['uk' => 'Огляди', 'en' => 'Reviews'],
            ['uk' => 'Новини', 'en' => 'Новини'],
        ], $parsed);
        $this->assertSame([], Tag::parseInput(null));
    }

    #[Test]
    public function tags_are_resolved_by_slug_and_reused(): void
    {
        $first = Tag::resolve(['uk' => 'Огляди', 'en' => 'Reviews']);
        $second = Tag::resolve(['uk' => 'Інша назва', 'en' => 'reviews']);

        $this->assertTrue($first->is($second));
        $this->assertSame('reviews', $first->slug);
        $this->assertDatabaseCount('tags', 1);
    }
}
