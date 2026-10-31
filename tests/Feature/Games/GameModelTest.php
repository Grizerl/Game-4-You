<?php

namespace Tests\Feature\Games;

use App\Models\Category;
use App\Models\Game;
use App\Support\YouTube;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GameModelTest extends TestCase
{
    use RefreshDatabase;

    private function game(string $en, array $attributes = []): Game
    {
        return Game::factory()->create(['name' => ['uk' => $en.' UA', 'en' => $en], ...$attributes]);
    }

    #[Test]
    public function slug_is_generated_from_english_name_and_made_unique(): void
    {
        $first = $this->game('Cyber Quest', ['slug' => null]);
        $second = $this->game('Cyber Quest', ['slug' => null]);

        $this->assertSame('cyber-quest', $first->slug);
        $this->assertSame('cyber-quest-2', $second->slug);
    }

    #[Test]
    public function slug_falls_back_to_other_language_and_ignores_renames(): void
    {
        $game = Game::factory()->create(['name' => ['uk' => 'Лише українська'], 'slug' => null]);

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $game->slug);

        $slug = $game->slug;
        $game->update(['name' => ['uk' => 'Нова', 'en' => 'Brand New']]);

        $this->assertSame($slug, $game->fresh()->slug);
    }

    #[Test]
    public function route_binding_accepts_slug_and_legacy_numeric_id(): void
    {
        $game = $this->game('Cyber Quest', ['slug' => null]);

        $this->assertTrue($game->is((new Game)->resolveRouteBinding('cyber-quest')));
        $this->assertTrue($game->is((new Game)->resolveRouteBinding((string) $game->id)));
        $this->assertNull((new Game)->resolveRouteBinding('missing'));
        $this->assertStringEndsWith('/games/cyber-quest', route('games.show.page', $game));
    }

    #[Test]
    public function cover_url_resolves_placeholder_static_and_storage_paths(): void
    {
        $this->assertSame(asset('assets/images/games/placeholder.svg'), Game::factory()->make(['cover_image' => null])->cover_url);
        $this->assertSame(asset('assets/images/games/a.jpg'), Game::factory()->make(['cover_image' => '/assets/images/games/a.jpg'])->cover_url);
        $this->assertSame(asset('storage/games/a.jpg'), Game::factory()->make(['cover_image' => 'games/a.jpg'])->cover_url);
    }

    #[Test]
    public function platform_list_trailer_and_screenshots_helpers(): void
    {
        $game = Game::factory()->make([
            'platforms' => 'PC, PS5 ,  Xbox',
            'trailer_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'screenshots' => ['games/screenshots/a.jpg', '', 'games/screenshots/b.jpg'],
        ]);

        $this->assertSame(['PC', 'PS5', 'Xbox'], $game->platformList());
        $this->assertSame('dQw4w9WgXcQ', $game->trailerId());
        $this->assertSame([asset('storage/games/screenshots/a.jpg'), asset('storage/games/screenshots/b.jpg')], $game->screenshotUrls());
    }

    #[Test]
    public function search_is_partial_case_insensitive_and_literal_for_wildcards(): void
    {
        $this->game('Alpha Quest');
        $this->game('100% Fun');
        $this->game('Beta');

        $names = fn (?string $q): array => Game::search($q)->get()->map(fn ($g) => $g->getTranslation('name', 'en'))->all();

        $this->assertSame(['Alpha Quest'], $names('ALPHA'));
        $this->assertSame(['100% Fun'], $names('%'));
        $this->assertCount(3, Game::search('')->get());
        $this->assertCount(0, Game::search('zzz')->get());
    }

    #[Test]
    public function category_and_platform_filters(): void
    {
        $rpg = Category::factory()->create();
        $this->game('A', ['category_id' => $rpg->id, 'platforms' => 'PC, PS5']);
        $this->game('B', ['platforms' => 'PS4']);

        $this->assertCount(1, Game::inCategory($rpg->id)->get());
        $this->assertCount(2, Game::inCategory(null)->get());
        $this->assertCount(1, Game::onPlatform('PS5')->get());
        $this->assertCount(0, Game::onPlatform('PS')->get());
        $this->assertSame(['PC', 'PS4', 'PS5'], Game::platformOptions()->all());
    }

    #[Test]
    public function sorting_supports_new_rating_name_and_defaults_to_new(): void
    {
        $this->game('Bravo', ['rating' => 500, 'released_at' => '2020-01-01']);
        $this->game('Zulu', ['rating' => 900, 'released_at' => '2024-01-01']);
        $this->game('Alpha', ['rating' => 100, 'released_at' => null]);

        app()->setLocale('en');

        $names = fn (?string $sort): array => Game::sortedBy($sort)->get()->map(fn ($g) => $g->getTranslation('name', 'en'))->all();

        $this->assertSame(['Alpha', 'Zulu', 'Bravo'], $names('new')); // Alpha без дати виходу: береться дата додавання (сьогодні)
        $this->assertSame(['Zulu', 'Bravo', 'Alpha'], $names('rating'));
        $this->assertSame(['Alpha', 'Bravo', 'Zulu'], $names('name'));
        $this->assertSame(['Alpha', 'Zulu', 'Bravo'], $names('drop_table'));
    }

    #[Test]
    public function youtube_parser_accepts_known_hosts_only(): void
    {
        $id = 'dQw4w9WgXcQ';

        foreach ([
            "https://www.youtube.com/watch?v=$id&t=5",
            "https://youtube.com/embed/$id",
            "https://m.youtube.com/shorts/$id",
            "http://youtu.be/$id?si=x",
        ] as $url) {
            $this->assertSame($id, YouTube::id($url), $url);
        }

        foreach ([null, '', 'not a url', "https://evil.example/watch?v=$id", "javascript:alert('$id')", "https://youtube.com.evil.example/watch?v=$id", 'https://youtube.com/watch?v=short', "ftp://youtube.com/watch?v=$id"] as $url) {
            $this->assertNull(YouTube::id($url), (string) $url);
        }
    }
}
