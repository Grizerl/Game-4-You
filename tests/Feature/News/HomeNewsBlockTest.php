<?php

namespace Tests\Feature\News;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HomeNewsBlockTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function home_shows_three_latest_published_articles_and_a_link_to_all_news(): void
    {
        foreach (range(1, 5) as $i) {
            Article::factory()->create([
                'title' => ['uk' => "Home story $i", 'en' => "Home story $i"],
                'published_at' => now()->subDays(10 - $i),
            ]);
        }

        Article::factory()->draft()->create(['title' => ['uk' => 'Home draft', 'en' => 'Home draft']]);
        Article::factory()->scheduled()->create(['title' => ['uk' => 'Home scheduled', 'en' => 'Home scheduled']]);

        $this->get(route('home.page'))
            ->assertOk()
            ->assertViewHas('latestNews', fn ($news): bool => $news->count() === 3)
            ->assertSee(__('news.home_title'))
            ->assertSee('Home story 5')->assertSee('Home story 4')->assertSee('Home story 3')
            ->assertDontSee('Home story 2')
            ->assertDontSee('Home draft')
            ->assertDontSee('Home scheduled')
            ->assertSee('href="'.route('news.page').'"', false)
            ->assertSee('resources/scss/public/news.scss', false);
    }

    #[Test]
    public function home_has_no_news_block_without_published_articles(): void
    {
        Article::factory()->draft()->create();

        $this->get(route('home.page'))
            ->assertOk()
            ->assertDontSee('id="news"', false)
            ->assertDontSee(__('news.home_title'));
    }
}
