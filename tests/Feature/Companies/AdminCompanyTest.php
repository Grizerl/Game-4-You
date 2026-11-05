<?php

namespace Tests\Feature\Companies;

use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @var list<string> */
    private array $existingLogos = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->existingLogos = glob(public_path('uploads/company/*')) ?: [];
    }

    protected function tearDown(): void
    {
        foreach (glob(public_path('uploads/company/*')) ?: [] as $file) {
            if (! in_array($file, $this->existingLogos, true)) {
                @unlink($file);
            }
        }

        parent::tearDown();
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
            'name' => ['uk' => 'Велика студія', 'en' => 'Big Studio'],
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
        ], $overrides);
    }

    private function existingLogo(): string
    {
        $path = 'uploads/company/test_'.uniqid().'.png';
        @mkdir(public_path('uploads/company'), 0777, true);
        $fake = UploadedFile::fake()->image('x.png');
        copy($fake->getPathname(), public_path($path));

        return $path;
    }

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get(route('companies.index'))->assertRedirect(route('login'));
        $this->post(route('companies.store'), $this->payload())->assertRedirect(route('login'));

        $this->assertDatabaseCount('companies', 0);
    }

    #[Test]
    public function list_is_paginated_searchable_and_shows_counts(): void
    {
        $companies = Company::factory()->count(16)->create();
        $latest = $companies->last();
        $creator = Creator::factory()->create(['company_id' => $latest->id]);
        Game::factory()->count(2)->create([
            'company_id' => $latest->id,
            'creator_id' => $creator->id,
            'category_id' => Category::factory()->create()->id,
        ]);

        $this->admin()->get(route('companies.index'))
            ->assertOk()
            ->assertViewHas('company', fn ($page): bool => $page->count() === 15 && $page->total() === 16)
            ->assertSee($latest->slug)
            ->assertSee(route('company.show.page', $latest), false);

        Company::factory()->create(['name' => ['uk' => 'Унікальна', 'en' => 'Zyxwv Unique']]);

        $this->admin()->get(route('companies.index', ['q' => 'zyxwv']))
            ->assertSee('Zyxwv Unique')
            ->assertDontSee($latest->slug);
    }

    #[Test]
    public function search_survives_pagination(): void
    {
        Company::factory()->count(16)->create(['name' => ['uk' => 'Пошук', 'en' => 'Searchable']]);

        $this->admin()->get(route('companies.index', ['q' => 'searchable']))
            ->assertSee('q=searchable&amp;page=2', false);
    }

    #[Test]
    public function forms_have_new_fields(): void
    {
        $this->admin()->get(route('companies.create'))
            ->assertOk()
            ->assertSee('name="slug"', false)
            ->assertSee('name="founded_year"', false)
            ->assertSee('name="socials[website]"', false)
            ->assertSee('name="name[uk]"', false)
            ->assertSee('data-logo-preview', false)
            ->assertSee('name="logo_path"', false);
    }

    #[Test]
    public function company_can_be_created_with_all_fields_and_logo(): void
    {
        $this->admin()->post(route('companies.store'), $this->payload([
            'slug' => 'custom-slug',
            'description' => ['uk' => 'Опис', 'en' => str_repeat('a', 1000)],
            'founded_year' => 2001,
            'socials' => ['website' => 'https://example.com', 'youtube' => 'https://youtube.com/@x'],
            'logo_path' => UploadedFile::fake()->image('logo.png'),
        ]))->assertRedirect(route('companies.index'));

        $company = Company::firstOrFail();
        $this->assertSame('custom-slug', $company->slug);
        $this->assertSame(2001, $company->founded_year);
        $this->assertSame(1000, mb_strlen($company->getTranslation('description', 'en')));
        $this->assertSame(['website' => 'https://example.com', 'youtube' => 'https://youtube.com/@x'], $company->socials);
        $this->assertFileExists(public_path($company->logo_path));
    }

    #[Test]
    public function company_can_be_created_without_logo(): void
    {
        $this->admin()->post(route('companies.store'), $this->payload())->assertRedirect(route('companies.index'));

        $company = Company::firstOrFail();
        $this->assertNull($company->logo_path);
        $this->assertStringContainsString('placeholder.svg', $company->logo_url);
        $this->assertSame('big-studio', $company->slug);
    }

    #[Test]
    public function missing_required_fields_are_rejected_and_input_preserved(): void
    {
        $this->admin()->from(route('companies.create'))->post(route('companies.store'), [
            'name' => ['uk' => '', 'en' => 'Only English'],
            'country' => ['uk' => 'Україна', 'en' => 'Ukraine'],
        ])
            ->assertRedirect(route('companies.create'))
            ->assertSessionHasErrors(['name.uk'])
            ->assertSessionHasInput('name.en', 'Only English');

        $this->assertDatabaseCount('companies', 0);
    }

    #[Test]
    public function generated_slug_is_unique_and_cyrillic_is_transliterated(): void
    {
        $this->admin()->post(route('companies.store'), $this->payload());
        $this->admin()->post(route('companies.store'), $this->payload());

        $this->assertSame(['big-studio', 'big-studio-2'], Company::orderBy('id')->pluck('slug')->all());

        $this->admin()->post(route('companies.store'), $this->payload(['name' => ['en' => '', 'uk' => 'Українська студія']]));

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Company::orderByDesc('id')->first()->slug);
    }

    #[Test]
    public function manual_slug_must_be_unique_and_well_formed(): void
    {
        Company::factory()->create(['slug' => 'taken']);

        $this->admin()->post(route('companies.store'), $this->payload(['slug' => 'taken']))->assertSessionHasErrors('slug');
        $this->admin()->post(route('companies.store'), $this->payload(['slug' => 'Bad Slug!']))->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('companies', 1);
    }

    #[Test]
    public function renaming_keeps_slug_and_slug_may_equal_its_own_value(): void
    {
        $company = Company::factory()->create(['slug' => 'old-slug']);

        $this->admin()->put(route('companies.update', $company->id), $this->payload(['slug' => '']))
            ->assertSessionHasNoErrors();
        $this->assertSame('old-slug', $company->fresh()->slug);

        $this->admin()->put(route('companies.update', $company->id), $this->payload(['slug' => 'old-slug']))
            ->assertSessionHasNoErrors();
        $this->admin()->put(route('companies.update', $company->id), $this->payload(['slug' => 'new-slug']))
            ->assertSessionHasNoErrors();

        $this->assertSame('new-slug', $company->fresh()->slug);
    }

    #[Test]
    public function invalid_year_socials_and_logo_are_rejected(): void
    {
        $admin = $this->admin();

        $admin->post(route('companies.store'), $this->payload(['founded_year' => now()->year + 1]))->assertSessionHasErrors('founded_year');
        $admin->post(route('companies.store'), $this->payload(['founded_year' => 1900]))->assertSessionHasErrors('founded_year');
        $admin->post(route('companies.store'), $this->payload(['socials' => ['website' => 'javascript:alert(1)']]))->assertSessionHasErrors('socials.website');
        $admin->post(route('companies.store'), $this->payload(['socials' => ['myspace' => 'https://example.com']]))->assertSessionHasErrors('socials');
        $admin->post(route('companies.store'), $this->payload(['logo_path' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')]))->assertSessionHasErrors('logo_path');
        $admin->post(route('companies.store'), $this->payload(['logo_path' => UploadedFile::fake()->image('big.png')->size(3000)]))->assertSessionHasErrors('logo_path');

        $this->assertDatabaseCount('companies', 0);
    }

    #[Test]
    public function empty_social_links_are_not_stored(): void
    {
        $this->admin()->post(route('companies.store'), $this->payload([
            'socials' => ['website' => 'https://example.com', 'x' => '', 'youtube' => '  '],
        ]));

        $this->assertSame(['website' => 'https://example.com'], Company::firstOrFail()->socials);
    }

    #[Test]
    public function edit_form_is_prefilled(): void
    {
        $company = Company::factory()->create([
            'name' => ['uk' => 'Студія', 'en' => 'Prefilled Studio'],
            'slug' => 'prefilled',
            'founded_year' => 1999,
            'socials' => ['website' => 'https://example.com/prefilled'],
            'logo_path' => $this->existingLogo(),
        ]);

        $this->admin()->get(route('companies.edit', $company->id))
            ->assertOk()
            ->assertSee('value="Prefilled Studio"', false)
            ->assertSee('value="prefilled"', false)
            ->assertSee('value="1999"', false)
            ->assertSee('value="https://example.com/prefilled"', false)
            ->assertSee($company->logo_url, false);
    }

    #[Test]
    public function update_without_file_keeps_logo_and_replacing_deletes_old_file(): void
    {
        $old = $this->existingLogo();
        $company = Company::factory()->create(['logo_path' => $old]);

        $this->admin()->put(route('companies.update', $company->id), $this->payload())
            ->assertRedirect(route('companies.index'));

        $this->assertSame($old, $company->fresh()->logo_path);
        $this->assertFileExists(public_path($old));

        $this->admin()->put(route('companies.update', $company->id), $this->payload([
            'logo_path' => UploadedFile::fake()->image('new.png'),
        ]));

        $new = $company->fresh()->logo_path;
        $this->assertNotSame($old, $new);
        $this->assertFileDoesNotExist(public_path($old));
        $this->assertFileExists(public_path($new));
    }

    #[Test]
    public function clearing_optional_fields_removes_their_values(): void
    {
        $company = Company::factory()->create([
            'description' => ['uk' => 'Опис', 'en' => 'Description'],
            'socials' => ['website' => 'https://example.com'],
            'founded_year' => 2000,
        ]);

        $this->admin()->put(route('companies.update', $company->id), $this->payload([
            'description' => ['uk' => '', 'en' => ''],
            'socials' => ['website' => ''],
            'founded_year' => '',
        ]))->assertSessionHasNoErrors();

        $company->refresh();
        $this->assertTrue(blank($company->description));
        $this->assertNull($company->socials);
        $this->assertNull($company->founded_year);
    }

    #[Test]
    public function deleting_removes_record_and_logo_file(): void
    {
        $logo = $this->existingLogo();
        $company = Company::factory()->create(['logo_path' => $logo]);

        $this->admin()->delete(route('companies.destroy', $company->id))->assertRedirect(route('companies.index'));

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
        $this->assertFileDoesNotExist(public_path($logo));

        $without = Company::factory()->withoutLogo()->create();
        $this->admin()->delete(route('companies.destroy', $without->id))->assertRedirect(route('companies.index'));
        $this->assertDatabaseMissing('companies', ['id' => $without->id]);
    }

    #[Test]
    public function list_shows_creator_counts(): void
    {
        $company = Company::factory()->create();
        Creator::factory()->count(3)->create(['company_id' => $company->id]);

        $this->admin()->get(route('companies.index'))
            ->assertViewHas('company', fn ($page): bool => $page->firstWhere('id', $company->id)->creators_count === 3);
    }
}
