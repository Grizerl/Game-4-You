<?php

namespace Tests\Feature\Creators;

use App\Models\Creator;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Мова сайту визначається префіксом URL під час старту застосунку, тому тут її
 * перемикаємо напряму: перевіряється контент англійською. Самі посилання будуються
 * через route(), тож префікс мови додає пакет локалізації.
 */
class CreatorLocalizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->setLocale('en');
    }

    #[Test]
    public function english_listing_uses_english_content_and_labels(): void
    {
        $creator = Creator::factory()->create([
            'first_name' => 'Ivan', 'last_name' => 'Petrenko',
            'role' => ['uk' => 'режисер', 'en' => 'director'],
        ]);
        Game::factory()->count(2)->create(['creator_id' => $creator->id]);

        $this->get(route('creator.page'))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('2 games')
            ->assertSee('director')
            ->assertDontSee('режисер')
            ->assertSee('Sort by')
            ->assertSee('href="'.route('creator.show.page', $creator).'"', false);
    }

    #[Test]
    public function english_profile_shows_english_bio_country_and_labels(): void
    {
        $creator = Creator::factory()->create([
            'bio' => ['uk' => 'Українське біо', 'en' => 'English biography'],
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'career_start' => now()->year - 1,
        ]);

        $this->get(route('creator.show.page', $creator))
            ->assertOk()
            ->assertSee('English biography')
            ->assertDontSee('Українське біо')
            ->assertSee('Ukraine')
            ->assertSee('1 year')
            ->assertSee('hreflang="uk"', false)
            ->assertSee('hreflang="en"', false);
    }

    #[Test]
    public function ukrainian_pluralization_uses_three_forms(): void
    {
        app()->setLocale('uk');

        $this->assertSame('1 гра', trans_choice('creators.games_plural', 1));
        $this->assertSame('3 гри', trans_choice('creators.games_plural', 3));
        $this->assertSame('5 ігор', trans_choice('creators.games_plural', 5));
        $this->assertSame('21 гра', trans_choice('creators.games_plural', 21));
    }
}
