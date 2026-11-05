<?php

namespace Tests\Feature\News;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewsListingTest extends TestCase
{
    use RefreshDatabase;

    private function article(string $title, array $attributes = []): Article
    {
        return Article::factory()->create(['title' => ['uk' => $title, 'en' => $title], ...$attributes]);
    }

    private function tag(string $uk, string $en): Tag
    {
        return Tag::factory()->create(['name' => ['uk' => $uk, 'en' => $en]]);
    }

    #[Test]
    public function only_published_articles_are_listed(): void
    {
        $this->article('Visible story');
        Article::factory()->draft()->create(['title' => ['uk' => 'Hidden draft', 'en' => 'Hidden draft']]);
        Article::factory()->scheduled()->create(['title' => ['uk' => 'Hidden scheduled', 'en' => 'Hidden scheduled']]);

        $this->get(route('news.page'))
            ->assertOk()
            ->assertViewIs('pages.news.index')
            ->assertSee('Visible story')
            ->assertDontSee('Hidden draft')
            ->assertDontSee('Hidden scheduled');
    }

    #[Test]
    public function newest_article_is_the_featured_card_and_is_not_repeated_in_the_grid(): void
    {
        $this->article('Older story', ['published_at' => now()->subDays(5)]);
        $newest = $this->article('Newest story', ['published_at' => now()->subHour()]);

        $response = $this->get(route('news.page'));

        $response->assertViewHas('featured', fn ($featured): bool => $featured->is($newest))
            ->assertViewHas('articles', fn ($page): bool => $page->count() === 1 && $page->first()->getTranslation('title', 'en') === 'Older story')
            ->assertSee('nw-featured__title', false)
            ->assertSee(__('news.featured_badge'));

        // У топ-картці два посилання (заголовок і кнопка), а в сітці картки цієї статті немає.
        $this->assertSame(2, substr_count($response->getContent(), 'href="'.route('news.show.page', $newest).'"'));
        $this->assertSame(1, substr_count($response->getContent(), 'class="nw-card__title"'));
    }

    #[Test]
    public function featured_card_is_hidden_on_later_pages_and_with_filters(): void
    {
        Article::factory()->count(12)->create();

        $this->get(route('news.page'))->assertSee('nw-featured__title', false);
        $this->get(route('news.page', ['page' => 2]))->assertDontSee('nw-featured__title', false)
            ->assertViewHas('articles', fn ($page): bool => $page->count() === 2);
        $this->get(route('news.page', ['q' => 'a']))->assertDontSee('nw-featured__title', false);
    }

    #[Test]
    public function article_without_cover_shows_placeholder_and_cards_link_to_slug_pages(): void
    {
        $article = $this->article('Placeholder story');
        $this->article('Another story');

        $this->get(route('news.page'))
            ->assertSee('assets/images/news/placeholder.svg')
            ->assertSee('href="'.route('news.show.page', $article).'"', false);
    }

    #[Test]
    public function search_filters_by_title_and_wildcards_are_literal(): void
    {
        $this->article('Alpha launch');
        $this->article('Beta release');

        $this->get(route('news.page', ['q' => 'alpha']))->assertSee('Alpha launch')->assertDontSee('Beta release');
        $this->get(route('news.page', ['q' => '%']))->assertDontSee('Alpha launch')->assertSee(__('news.nothing_found'));
    }

    #[Test]
    public function tag_chips_count_only_published_articles_and_hide_tags_without_any(): void
    {
        $reviews = $this->tag('Огляди', 'Reviews');
        $drafts = $this->tag('Тільки чернетки', 'Draft only');

        foreach ([1, 2] as $i) {
            $this->article("Review $i")->tags()->attach($reviews);
        }
        Article::factory()->draft()->create()->tags()->attach($reviews);
        Article::factory()->draft()->create()->tags()->attach($drafts);

        $response = $this->get(route('news.page'));

        $response->assertSee('<small>2</small>', false)->assertDontSee('Тільки чернетки');
        $this->assertMatchesRegularExpression('#href="[^"]*tag=reviews"#', $response->getContent());
    }

    #[Test]
    public function tag_filter_and_search_combine(): void
    {
        $reviews = $this->tag('Огляди', 'Reviews');
        $this->article('Reviewed alpha')->tags()->attach($reviews);
        $this->article('Reviewed beta')->tags()->attach($reviews);
        $this->article('Untagged alpha');

        $this->get(route('news.page', ['tag' => 'reviews']))
            ->assertSee('Reviewed alpha')->assertSee('Reviewed beta')->assertDontSee('Untagged alpha');

        $this->get(route('news.page', ['tag' => 'reviews', 'q' => 'alpha']))
            ->assertSee('Reviewed alpha')->assertDontSee('Reviewed beta')->assertDontSee('Untagged alpha');
    }

    #[Test]
    public function invalid_parameters_are_ignored(): void
    {
        $this->article('Anything');

        $this->get(route('news.page', ['tag' => ['x'], 'q' => ['y']]))->assertOk()->assertSee('Anything');
        $this->get(route('news.page', ['tag' => 'Bad Tag!!']))->assertOk()->assertSee('Anything');
    }

    #[Test]
    public function empty_result_shows_message_and_reset_link(): void
    {
        $this->article('Existing');

        $this->get(route('news.page', ['q' => 'zzzz']))
            ->assertOk()
            ->assertSee(__('news.nothing_found'))
            ->assertSee(__('news.reset'));
    }

    #[Test]
    public function pagination_keeps_filters_in_urls(): void
    {
        $tag = $this->tag('Тема', 'Topic');
        Article::factory()->count(12)->create()->each(fn (Article $article) => $article->tags()->attach($tag));

        $response = $this->get(route('news.page', ['tag' => 'topic']));

        $this->assertMatchesRegularExpression('#href="[^"]*tag=topic&amp;page=2"#', $response->getContent());
    }

    #[Test]
    public function listing_advertises_the_rss_feed_and_loads_assets(): void
    {
        $this->get(route('news.page'))
            ->assertSee('type="application/rss+xml"', false)
            ->assertSee('href="'.route('news.feed.page').'"', false)
            ->assertSee('resources/scss/public/news.scss', false)
            ->assertSee('family=Oswald', false)
            ->assertSee('rel="canonical" href="'.route('news.page').'"', false)
            ->assertSee('hreflang="en"', false);
    }

    #[Test]
    public function header_links_to_news_from_the_drawer_menu(): void
    {
        $response = $this->get(route('home.page'));

        $this->assertSame(1, substr_count($response->getContent(), 'href="'.route('news.page').'"'));
    }

    #[Test]
    public function listing_does_not_run_per_article_queries(): void
    {
        $tag = $this->tag('Тема', 'Topic');
        Article::factory()->count(12)->create()->each(fn (Article $article) => $article->tags()->attach($tag));

        DB::enableQueryLog();
        $this->get(route('news.page'))->assertOk();

        $this->assertLessThanOrEqual(12, count(DB::getQueryLog()));
    }

    #[Test]
    public function english_listing_uses_english_labels_and_titles(): void
    {
        app()->setLocale('en');

        Article::factory()->create(['title' => ['uk' => 'Українська назва', 'en' => 'English headline']]);

        $this->get(route('news.page'))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('English headline')
            ->assertDontSee('Українська назва')
            ->assertSee('Top story');
    }

    #[Test]
    public function translation_files_have_the_same_keys(): void
    {
        foreach (['news', 'header'] as $file) {
            $uk = require lang_path("uk/$file.php");
            $en = require lang_path("en/$file.php");

            $this->assertSame(array_keys(Arr::dot($uk)), array_keys(Arr::dot($en)), $file);
        }
    }
}
