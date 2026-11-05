<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\CompanyIndexRequest;
use App\Models\Company;
use App\Models\Creator;
use App\Support\GameStatistics;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class CompanyController extends Controller
{
    private const PER_PAGE = 12;

    private const TOP_COUNT = 3;

    private const TEAM_LIMIT = 24;

    public function index(CompanyIndexRequest $request): View
    {
        $companies = Company::query()
            ->with([
                'games' => fn ($query) => $query
                    ->select('id', 'company_id', 'name', 'cover_image', 'created_at')
                    ->latest()
                    ->orderByDesc('id'),
            ])
            ->withCount(['games', 'creators'])
            ->search($request->search())
            ->inCountry($request->country())
            ->sortedBy($request->sort())
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $top = ! $request->hasFilters() && $companies->currentPage() === 1
            ? $this->top()
            : collect();

        $countries = Company::countryOptions();

        $filters = [
            'q' => $request->search(),
            'country' => $request->country(),
            'sort' => $request->sort(),
        ];

        return view('pages.store.stores', compact('companies', 'top', 'countries', 'filters'));
    }

    public function show(Company $company): View
    {
        $company->load([
            'games' => fn ($query) => $query->with('category')->latest()->orderByDesc('id'),
        ]);

        $games = $company->games;
        ['stats' => $stats, 'genres' => $genres] = GameStatistics::for($games);

        $team = Creator::query()
            ->withCount('games')
            ->where('company_id', $company->id)
            ->orderByDesc('games_count')
            ->orderBy('first_name')
            ->limit(self::TEAM_LIMIT)
            ->get();

        $stats['creators'] = Creator::where('company_id', $company->id)->count();

        $socials = $company->socialLinks();

        $previous = Company::query()->where('id', '<', $company->id)->orderByDesc('id')->first();
        $next = Company::query()->where('id', '>', $company->id)->orderBy('id')->first();

        $structuredData = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => (string) $company->name,
            'url' => route('company.show.page', $company),
            'logo' => $company->logo_path ? $company->logo_url : null,
            'description' => $company->description ?: null,
            'foundingDate' => $company->founded_year ? (string) $company->founded_year : null,
            'address' => filled($company->country)
                ? ['@type' => 'PostalAddress', 'addressCountry' => (string) $company->country]
                : null,
            'sameAs' => $socials ? array_values($socials) : null,
        ]);

        return view('pages.store.show', compact(
            'company', 'games', 'stats', 'genres', 'team', 'socials', 'previous', 'next', 'structuredData'
        ));
    }

    /**
     * @return Collection<int, Company>
     */
    private function top(): Collection
    {
        return Company::query()
            ->withCount(['games', 'creators'])
            ->whereHas('games')
            ->orderByDesc('games_count')
            ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(name, ?)) COLLATE utf8mb4_unicode_ci', ['$."'.preg_replace('/[^A-Za-z_-]/', '', app()->getLocale()).'"'])
            ->limit(self::TOP_COUNT)
            ->get();
    }
}
