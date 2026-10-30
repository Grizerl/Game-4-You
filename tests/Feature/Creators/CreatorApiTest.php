<?php

namespace Tests\Feature\Creators;

use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatorApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function api_returns_slug_and_real_games_count(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);
        Creator::query()->whereKey($creator->id)->update(['games_count' => 40]);
        Game::factory()->count(3)->create(['creator_id' => $creator->id]);

        $this->getJson('/api/creators')
            ->assertOk()
            ->assertJsonPath('data.0.slug', 'ivan-petrenko')
            ->assertJsonPath('data.0.games_count', 3);
    }
}
