<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Game;


class PageControllerTest extends TestCase
{
   use RefreshDatabase;

    #[Test]
    public function it_shows_homepage_with_categories(): void
    {
        $categories = Category::factory()
            ->count(9)
            ->has(Game::factory()->count(3))
            ->create();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.home.main');
        $response->assertViewHas('categories');
        
    }

    #[Test]
    public function it_return_filtered_games(): void
    {
        $category = Category::factory()->create();

        Game::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->get(route('games', ['category_id' => $category->id]));

        $response->assertStatus(200);
        $response->assertSee('<div', false);
    }

    #[Test]
    public function it_shows_creators_page(): void
    {
        Category::factory()->count(5)->create();

        $response = $this->get(route('creators'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.creator.creators');
        $response->assertViewHas('creators');
    }

    #[Test]
    public function it_shows_stores_pages(): void
    {
        $response = $this->get(route('stores'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.store.stores');
    }

    #[Test]
    public function it_show_games_page(): void
    {
        $category = Category::factory()->create();

        Game::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->get(route('all.games'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.game.games');
        $response->assertViewHas('games');
    }

    #[Test]
    public function it_shows_detail_about_game(): void
    {
        $category = Category::factory()->create();
        $game = Game::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('detail', $game->id));

        $response->assertStatus(200);
        $response->assertViewIs('pages.details.detail');
        $response->assertViewHas('game', $game);
    }

    #[Test]
    public function it_return_404_for_non_exist_game(): void
    {
        $response = $this->get(route('detail', 999999));

        $response->assertStatus(404);
    }
}
