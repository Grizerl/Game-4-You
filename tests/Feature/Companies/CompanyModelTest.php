<?php

namespace Tests\Feature\Companies;

use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Support\PublicImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CompanyModelTest extends TestCase
{
    use RefreshDatabase;

    private function company(string $en, array $attributes = []): Company
    {
        return Company::factory()->create(['name' => ['uk' => $en.' UA', 'en' => $en], ...$attributes]);
    }

    #[Test]
    public function slug_is_generated_from_english_name_and_made_unique(): void
    {
        $first = $this->company('Big Studio', ['slug' => null]);
        $second = $this->company('Big Studio', ['slug' => null]);

        $this->assertSame('big-studio', $first->slug);
        $this->assertSame('big-studio-2', $second->slug);
    }

    #[Test]
    public function slug_falls_back_to_other_language_and_transliterates_cyrillic(): void
    {
        $company = Company::factory()->create(['name' => ['uk' => 'Студія Гра'], 'slug' => null]);

        $this->assertMatchesRegularExpression('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $company->slug);
        $this->assertNotSame('company', $company->slug);
    }

    #[Test]
    public function renaming_does_not_change_slug(): void
    {
        $company = $this->company('Big Studio', ['slug' => null]);

        $company->update(['name' => ['uk' => 'Нова', 'en' => 'New Name']]);

        $this->assertSame('big-studio', $company->fresh()->slug);
    }

    #[Test]
    public function logo_url_resolves_placeholder_uploads_and_storage_paths(): void
    {
        $this->assertSame(asset('assets/images/companies/placeholder.svg'), Company::factory()->make(['logo_path' => null])->logo_url);
        $this->assertSame(asset('uploads/company/a.png'), Company::factory()->make(['logo_path' => 'uploads/company/a.png'])->logo_url);
        $this->assertSame(asset('storage/companies/a.png'), Company::factory()->make(['logo_path' => 'companies/a.png'])->logo_url);
        $this->assertSame(asset('uploads/x.png'), PublicImage::url('uploads/x.png'));
    }

    #[Test]
    public function search_is_partial_case_insensitive_and_literal_for_wildcards(): void
    {
        $this->company('Alpha Games');
        $this->company('100% Real');
        $this->company('Beta');

        $this->assertSame(['Alpha Games'], Company::search('ALPHA')->get()->map(fn ($c) => $c->getTranslation('name', 'en'))->all());
        $this->assertSame(['100% Real'], Company::search('%')->get()->map(fn ($c) => $c->getTranslation('name', 'en'))->all());
        $this->assertCount(3, Company::search('')->get());
        $this->assertCount(0, Company::search('zzz')->get());
    }

    #[Test]
    public function country_filter_and_options_use_current_locale(): void
    {
        $this->company('A', ['country' => ['uk' => 'Польща', 'en' => 'Poland']]);
        $this->company('B', ['country' => ['uk' => 'Україна', 'en' => 'Ukraine']]);
        $this->company('C', ['country' => ['uk' => 'Україна', 'en' => 'Ukraine']]);

        app()->setLocale('en');

        $this->assertSame(['Poland', 'Ukraine'], Company::countryOptions()->all());
        $this->assertCount(2, Company::inCountry('Ukraine')->get());
        $this->assertCount(3, Company::inCountry('')->get());
    }

    #[Test]
    public function sorting_supports_games_name_and_defaults_to_newest(): void
    {
        $few = $this->company('Bravo');
        $many = $this->company('Zulu');
        $none = $this->company('Alpha');
        Game::factory()->count(2)->create(['company_id' => $many->id]);
        Game::factory()->create(['company_id' => $few->id]);

        app()->setLocale('en');

        $ids = [$few->id, $many->id, $none->id];
        $names = fn (?string $sort): array => Company::sortedBy($sort)->whereIn('id', $ids)->get()->map(fn ($c) => $c->getTranslation('name', 'en'))->all();

        $this->assertSame(['Zulu', 'Bravo', 'Alpha'], $names('games'));
        $this->assertSame(['Alpha', 'Bravo', 'Zulu'], $names('name'));
        $this->assertSame(['Alpha', 'Zulu', 'Bravo'], $names('new'));
        $this->assertSame(['Alpha', 'Zulu', 'Bravo'], $names('drop_table'));
        $this->assertSame($none->id, Company::sortedBy(null)->whereIn('id', $ids)->first()->id);
    }

    #[Test]
    public function social_links_keep_only_known_keys_with_http_schemes(): void
    {
        $company = Company::factory()->make(['socials' => [
            'website' => 'https://example.com',
            'x' => 'javascript:alert(1)',
            'unknown' => 'https://evil.example',
        ]]);

        $this->assertSame(['website' => 'https://example.com'], $company->socialLinks());
    }

    #[Test]
    public function relations_count_games_and_creators(): void
    {
        $company = Company::factory()->create();
        Game::factory()->count(3)->create(['company_id' => $company->id]);
        Creator::factory()->count(2)->create(['company_id' => $company->id]);

        $loaded = Company::withCount(['games', 'creators'])->find($company->id);

        $this->assertSame(3, $loaded->games_count);
        $this->assertSame(2, $loaded->creators_count);
    }
}
