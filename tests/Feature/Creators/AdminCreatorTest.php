<?php

namespace Tests\Feature\Creators;

use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminCreatorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function admin(): static
    {
        return $this->actingAs(User::factory()->create());
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_replace_recursive([
            'first_name' => 'Ivan',
            'last_name' => 'Petrenko',
            'company_id' => Company::factory()->create()->id,
            'role' => ['uk' => 'режисер', 'en' => 'director'],
        ], $overrides);
    }

    // ---------- доступ ----------

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get(route('creator.index'))->assertRedirect(route('login'));
        $this->get(route('creator.create'))->assertRedirect(route('login'));
        $this->post(route('creator.store'), $this->payload())->assertRedirect(route('login'));

        $this->assertDatabaseCount('creators', 0);
    }

    // ---------- список ----------

    #[Test]
    public function list_is_paginated_and_shows_real_games_count(): void
    {
        $creators = Creator::factory()->count(16)->create();
        $latest = $creators->last();
        Game::factory()->count(2)->create(['creator_id' => $latest->id]);

        $this->admin()->get(route('creator.index'))
            ->assertOk()
            ->assertViewHas('creators', fn ($page): bool => $page->count() === 15 && $page->total() === 16)
            ->assertSee($latest->slug)
            ->assertSee(route('creator.show.page', $latest), false);

        $this->admin()->get(route('creator.index', ['page' => 2]))
            ->assertViewHas('creators', fn ($page): bool => $page->count() === 1);
    }

    #[Test]
    public function list_can_be_searched_and_search_survives_pagination(): void
    {
        Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko']);
        Creator::factory()->create(['first_name' => 'Maksym', 'last_name' => 'Koval']);

        $this->admin()->get(route('creator.index', ['q' => 'petren']))
            ->assertOk()
            ->assertSee('Ivan Petrenko')
            ->assertDontSee('Maksym Koval');

        Creator::factory()->count(16)->create(['last_name' => 'Searchable']);

        $this->admin()->get(route('creator.index', ['q' => 'searchable']))
            ->assertSee('q=searchable&amp;page=2', false);
    }

    // ---------- створення ----------

    #[Test]
    public function create_form_has_new_fields_and_no_games_count(): void
    {
        $this->admin()->get(route('creator.create'))
            ->assertOk()
            ->assertSee('name="slug"', false)
            ->assertSee('name="country[uk]"', false)
            ->assertSee('name="country[en]"', false)
            ->assertSee('name="career_start"', false)
            ->assertSee('name="socials[website]"', false)
            ->assertSee('name="bio[uk]"', false)
            ->assertSee('name="role[en]"', false)
            ->assertSee('data-avatar-preview', false)
            ->assertDontSee('name="games_count"', false);
    }

    #[Test]
    public function creator_can_be_created_with_all_fields(): void
    {
        $response = $this->admin()->post(route('creator.store'), $this->payload([
            'slug' => 'custom-slug',
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'career_start' => 2005,
            'bio' => ['uk' => str_repeat('а', 1000), 'en' => 'Long biography'],
            'socials' => ['website' => 'https://example.com', 'youtube' => 'https://youtube.com/@ivan'],
            'avatar' => UploadedFile::fake()->image('ivan.jpg'),
        ]));

        $response->assertRedirect(route('creator.index'));

        $creator = Creator::firstOrFail();
        $this->assertSame('custom-slug', $creator->slug);
        $this->assertSame('Ukraine', $creator->getTranslation('country', 'en'));
        $this->assertSame(2005, $creator->career_start);
        $this->assertSame(1000, mb_strlen($creator->getTranslation('bio', 'uk')));
        $this->assertSame(['website' => 'https://example.com', 'youtube' => 'https://youtube.com/@ivan'], $creator->socials);
        Storage::disk('public')->assertExists($creator->avatar);
    }

    #[Test]
    public function creator_can_be_created_without_avatar(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload())->assertRedirect(route('creator.index'));

        $creator = Creator::firstOrFail();
        $this->assertNull($creator->avatar);
        $this->assertStringContainsString('placeholder.svg', $creator->avatar_url);
        $this->assertSame('ivan-petrenko', $creator->slug);
    }

    #[Test]
    public function missing_required_fields_are_rejected_and_input_is_preserved(): void
    {
        $this->admin()->from(route('creator.create'))->post(route('creator.store'), [
            'last_name' => 'Petrenko',
            'role' => ['uk' => 'режисер', 'en' => ''],
        ])
            ->assertRedirect(route('creator.create'))
            ->assertSessionHasErrors(['first_name', 'company_id', 'role.en'])
            ->assertSessionHasInput('last_name', 'Petrenko');

        $this->assertDatabaseCount('creators', 0);
    }

    // ---------- slug ----------

    #[Test]
    public function generated_slug_is_unique(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload());
        $this->admin()->post(route('creator.store'), $this->payload());

        $this->assertSame(['ivan-petrenko', 'ivan-petrenko-2'], Creator::orderBy('id')->pluck('slug')->all());
    }

    #[Test]
    public function cyrillic_name_gets_latin_slug(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload(['first_name' => 'Іван', 'last_name' => 'Петренко']));

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Creator::firstOrFail()->slug);
    }

    #[Test]
    public function manual_slug_must_be_unique_and_well_formed(): void
    {
        Creator::factory()->create(['slug' => 'taken']);

        $this->admin()->post(route('creator.store'), $this->payload(['slug' => 'taken']))
            ->assertSessionHasErrors('slug');
        $this->admin()->post(route('creator.store'), $this->payload(['slug' => 'Bad Slug!']))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('creators', 1);
    }

    #[Test]
    public function renaming_keeps_slug_and_blank_slug_keeps_current(): void
    {
        $creator = Creator::factory()->create(['first_name' => 'Ivan', 'last_name' => 'Petrenko', 'slug' => 'ivan-petrenko']);

        $this->admin()->put(route('creator.update', $creator->id), $this->payload([
            'first_name' => 'Petro', 'slug' => '', 'company_id' => $creator->company_id,
        ]))->assertRedirect(route('creator.index'));

        $creator->refresh();
        $this->assertSame('Petro', $creator->first_name);
        $this->assertSame('ivan-petrenko', $creator->slug);
    }

    #[Test]
    public function slug_can_be_changed_explicitly_and_may_equal_its_own_current_value(): void
    {
        $creator = Creator::factory()->create(['slug' => 'old-slug']);
        $payload = $this->payload(['company_id' => $creator->company_id]);

        $this->admin()->put(route('creator.update', $creator->id), $payload + ['slug' => 'old-slug'])
            ->assertSessionHasNoErrors();
        $this->admin()->put(route('creator.update', $creator->id), $payload + ['slug' => 'new-slug'])
            ->assertSessionHasNoErrors();

        $this->assertSame('new-slug', $creator->fresh()->slug);
    }

    // ---------- валідація ----------

    #[Test]
    public function career_start_must_be_in_range(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload(['career_start' => now()->year + 1]))
            ->assertSessionHasErrors('career_start');
        $this->admin()->post(route('creator.store'), $this->payload(['career_start' => 1900]))
            ->assertSessionHasErrors('career_start');
        $this->admin()->post(route('creator.store'), $this->payload(['career_start' => now()->year]))
            ->assertSessionHasNoErrors();
    }

    #[Test]
    public function unsafe_or_unknown_social_links_are_rejected(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload(['socials' => ['website' => 'javascript:alert(1)']]))
            ->assertSessionHasErrors('socials.website');
        $this->admin()->post(route('creator.store'), $this->payload(['socials' => ['website' => 'ftp://example.com']]))
            ->assertSessionHasErrors('socials.website');
        $this->admin()->post(route('creator.store'), $this->payload(['socials' => ['myspace' => 'https://example.com']]))
            ->assertSessionHasErrors('socials');

        $this->assertDatabaseCount('creators', 0);
    }

    #[Test]
    public function empty_social_links_are_not_stored(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload([
            'socials' => ['website' => 'https://example.com', 'x' => '', 'youtube' => '  '],
        ]));

        $this->assertSame(['website' => 'https://example.com'], Creator::firstOrFail()->socials);

        $this->admin()->post(route('creator.store'), $this->payload(['socials' => ['website' => '']]));

        $this->assertNull(Creator::orderByDesc('id')->first()->socials);
    }

    #[Test]
    public function avatar_must_be_a_small_image(): void
    {
        $this->admin()->post(route('creator.store'), $this->payload(['avatar' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')]))
            ->assertSessionHasErrors('avatar');
        $this->admin()->post(route('creator.store'), $this->payload(['avatar' => UploadedFile::fake()->image('big.jpg')->size(3000)]))
            ->assertSessionHasErrors('avatar');
    }

    // ---------- редагування ----------

    #[Test]
    public function edit_form_is_prefilled_and_shows_current_avatar(): void
    {
        $file = UploadedFile::fake()->image('a.jpg')->store('creators', 'public');
        $creator = Creator::factory()->create([
            'first_name' => 'Ivan', 'slug' => 'ivan-the-great', 'avatar' => $file, 'career_start' => 2001,
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'bio' => ['uk' => 'Біо укр', 'en' => 'Bio en'],
            'socials' => ['website' => 'https://example.com/ivan'],
        ]);

        $this->admin()->get(route('creator.edit', $creator->id))
            ->assertOk()
            ->assertSee('value="Ivan"', false)
            ->assertSee('value="ivan-the-great"', false)
            ->assertSee('value="2001"', false)
            ->assertSee('value="Україна"', false)
            ->assertSee('Біо укр')
            ->assertSee('value="https://example.com/ivan"', false)
            ->assertSee($creator->avatar_url, false)
            ->assertDontSee('name="games_count"', false);
    }

    #[Test]
    public function update_without_file_keeps_avatar(): void
    {
        $file = UploadedFile::fake()->image('a.jpg')->store('creators', 'public');
        $creator = Creator::factory()->create(['avatar' => $file]);

        $this->admin()->put(route('creator.update', $creator->id), $this->payload([
            'company_id' => $creator->company_id, 'bio' => ['uk' => 'Нове біо'],
        ]))->assertRedirect(route('creator.index'));

        $this->assertSame($file, $creator->fresh()->avatar);
        Storage::disk('public')->assertExists($file);
        $this->assertSame('Нове біо', $creator->fresh()->getTranslation('bio', 'uk'));
    }

    #[Test]
    public function replacing_avatar_deletes_the_old_file(): void
    {
        $old = UploadedFile::fake()->image('old.jpg')->store('creators', 'public');
        $creator = Creator::factory()->create(['avatar' => $old]);

        $this->admin()->put(route('creator.update', $creator->id), $this->payload([
            'company_id' => $creator->company_id,
            'avatar' => UploadedFile::fake()->image('new.png'),
        ]))->assertRedirect(route('creator.index'));

        $new = $creator->fresh()->avatar;
        $this->assertNotSame($old, $new);
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($new);
    }

    #[Test]
    public function clearing_optional_fields_removes_their_values(): void
    {
        $creator = Creator::factory()->create([
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
            'bio' => ['uk' => 'Біо', 'en' => 'Bio'],
            'socials' => ['website' => 'https://example.com'],
            'career_start' => 2000,
        ]);

        $this->admin()->put(route('creator.update', $creator->id), $this->payload([
            'company_id' => $creator->company_id,
            'country' => ['uk' => '', 'en' => ''],
            'bio' => ['uk' => '', 'en' => ''],
            'socials' => ['website' => ''],
            'career_start' => '',
        ]))->assertSessionHasNoErrors();

        $creator->refresh();
        $this->assertTrue(blank($creator->country));
        $this->assertTrue(blank($creator->bio));
        $this->assertNull($creator->socials);
        $this->assertNull($creator->career_start);
    }

    // ---------- видалення ----------

    #[Test]
    public function deleting_removes_record_and_avatar_file(): void
    {
        $file = UploadedFile::fake()->image('a.jpg')->store('creators', 'public');
        $creator = Creator::factory()->create(['avatar' => $file]);

        $this->admin()->delete(route('creator.destroy', $creator->id))->assertRedirect(route('creator.index'));

        $this->assertDatabaseMissing('creators', ['id' => $creator->id]);
        Storage::disk('public')->assertMissing($file);
    }

    #[Test]
    public function deleting_creator_without_avatar_works(): void
    {
        $creator = Creator::factory()->withoutAvatar()->create();

        $this->admin()->delete(route('creator.destroy', $creator->id))->assertRedirect(route('creator.index'));

        $this->assertDatabaseMissing('creators', ['id' => $creator->id]);
    }
}
