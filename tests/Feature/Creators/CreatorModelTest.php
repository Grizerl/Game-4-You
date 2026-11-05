<?php

namespace Tests\Feature\Creators;

use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatorModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function factories_build_related_records(): void
    {
        $game = Game::factory()->create();

        $this->assertNotNull($game->creator);
        $this->assertNotNull($game->category);
        $this->assertNotNull($game->company);
        $this->assertNotNull(Company::factory()->create()->name);
        $this->assertNotNull(User::factory()->create()->email_verified_at);
        $this->assertNull(User::factory()->unverified()->create()->email_verified_at);
        $this->assertNull(Creator::factory()->withoutAvatar()->create()->avatar);
    }

    #[Test]
    public function slug_is_generated_from_name(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko', 'slug' => null]);

        $this->assertSame('ivan-petrenko', $creator->slug);
    }

    #[Test]
    public function duplicate_generated_slug_gets_numeric_suffix(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko', 'slug' => null]);
        $second = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko', 'slug' => null]);
        $third = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko', 'slug' => null]);

        $this->assertSame('ivan-petrenko-2', $second->slug);
        $this->assertSame('ivan-petrenko-3', $third->slug);
    }

    #[Test]
    public function cyrillic_name_is_transliterated(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Іван', 'last_name' => 'Петренко', 'slug' => null]);

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $creator->slug);
    }

    #[Test]
    public function renaming_does_not_change_slug(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko', 'slug' => null]);

        $creator->update(['first_name' => 'Petro']);

        $this->assertSame('ivan-petrenko', $creator->fresh()->slug);
    }

    #[Test]
    public function avatar_url_resolves_placeholder_static_and_storage_paths(): void
    {
        $this->assertSame(asset('assets/images/creators/placeholder.svg'), Creator::factory()->make(['avatar' => null])->avatar_url);
        $this->assertSame(asset('assets/images/creators/a.png'), Creator::factory()->make(['avatar' => '/assets/images/creators/a.png'])->avatar_url);
        $this->assertSame(asset('storage/creators/hash.jpg'), Creator::factory()->make(['avatar' => 'creators/hash.jpg'])->avatar_url);
    }

    #[Test]
    public function search_matches_partially_and_treats_wildcards_literally(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);
        Creator::factory()->create(['first_name' => 'Olena', 'last_name' => '100% Real']);
        Creator::factory()->create(['first_name' => 'Maksym', 'last_name' => 'Koval']);

        $this->assertSame(['Ivan'], Creator::search('PETREN')->pluck('first_name')->all());
        $this->assertSame(['Ivan'], Creator::search('ivan petr')->pluck('first_name')->all());
        $this->assertSame(['Olena'], Creator::search('%')->pluck('first_name')->all());
        $this->assertCount(3, Creator::search('')->get());
        $this->assertCount(0, Creator::search('zzz')->get());
    }

    #[Test]
    public function role_filter_matches_whole_tokens_only(): void
    {
        Creator::factory()->create(['first_name' => 'A', 'role' => ['uk' => 'режисер', 'en' => 'writer, director']]);
        Creator::factory()->create(['first_name' => 'B', 'role' => ['uk' => 'режисер', 'en' => 'art director']]);
        Creator::factory()->create(['first_name' => 'C', 'role' => ['uk' => 'режисер', 'en' => 'producer']]);

        app()->setLocale('en');

        $this->assertSame(['A'], Creator::withRole('director')->pluck('first_name')->all());
        $this->assertSame(['B'], Creator::withRole('art director')->pluck('first_name')->all());
        $this->assertSame(
            ['art director', 'director', 'producer', 'writer'],
            Creator::roleOptions()->all()
        );
    }

    #[Test]
    public function sorting_supports_games_name_and_defaults_to_newest(): void
    {
        $few = Creator::factory()->create(['first_name' => 'Bob']);
        $many = Creator::factory()->create(['first_name' => 'Zed']);
        $none = Creator::factory()->create(['first_name' => 'Al']);
        Game::factory()->count(2)->create(['creator_id' => $many->id]);
        Game::factory()->create(['creator_id' => $few->id]);

        $this->assertSame(['Zed', 'Bob', 'Al'], Creator::sortedBy('games')->pluck('first_name')->all());
        $this->assertSame(['Al', 'Bob', 'Zed'], Creator::sortedBy('name')->pluck('first_name')->all());
        $this->assertSame(['Al', 'Zed', 'Bob'], Creator::sortedBy('new')->pluck('first_name')->all());
        $this->assertSame(['Al', 'Zed', 'Bob'], Creator::sortedBy('drop_table')->pluck('first_name')->all());
        $this->assertSame($none->id, Creator::sortedBy(null)->first()->id);
    }

    #[Test]
    public function social_links_keep_only_known_keys_with_http_schemes(): void
    {
        $creator = Creator::factory()->make(['socials' => [
            'website' => 'https://example.com',
            'x' => 'javascript:alert(1)',
            'youtube' => 'http://youtube.com/@x',
            'unknown' => 'https://evil.example',
        ]]);

        $this->assertSame(
            ['website' => 'https://example.com', 'youtube' => 'http://youtube.com/@x'],
            $creator->socialLinks()
        );
    }

    #[Test]
    public function stored_games_counter_is_shadowed_by_real_count(): void
    {
        $creator = Creator::factory()->create();
        Creator::query()->whereKey($creator->id)->update(['games_count' => 40]);
        Game::factory()->count(3)->create(['creator_id' => $creator->id]);

        $this->assertSame(3, Creator::withCount('games')->find($creator->id)->games_count);
    }
}
