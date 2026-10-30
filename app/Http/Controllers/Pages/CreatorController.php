<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\CreatorIndexRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class CreatorController extends Controller
{
    private const PER_PAGE = 12;

    private const STARS_COUNT = 3;

    private const CO_CREATORS_COUNT = 4;

    public function index(CreatorIndexRequest $request): View
    {
        $creators = Creator::query()
            ->with([
                'company',
                'games' => fn ($query) => $query
                    ->select('id', 'creator_id', 'name', 'cover_image', 'created_at')
                    ->latest(),
            ])
            ->withCount('games')
            ->search($request->search())
            ->forCompany($request->companyId())
            ->withRole($request->role())
            ->sortedBy($request->sort())
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $stars = ! $request->hasFilters() && $creators->currentPage() === 1
            ? $this->stars()
            : collect();

        $companies = Company::query()
            ->whereHas('creator')
            ->get()
            ->sortBy(fn (Company $company): string => mb_strtolower((string) $company->name))
            ->values();

        $roles = Creator::roleOptions();

        $filters = [
            'q' => $request->search(),
            'company' => $request->companyId(),
            'role' => $request->role(),
            'sort' => $request->sort(),
        ];

        return view('pages.creator.creators', compact('creators', 'stars', 'companies', 'roles', 'filters'));
    }

    public function show(Creator $creator): View
    {
        $creator->load([
            'company',
            'games' => fn ($query) => $query->with('category')->latest()->orderByDesc('id'),
        ]);

        $games = $creator->games;
        $genres = $this->genres($games);
        $socials = $creator->socialLinks();

        $stats = [
            'count' => $games->count(),
            'average' => $games->isEmpty() ? null : (int) round($games->avg('rating')),
            'max' => $games->max('rating'),
            'main_genre' => $genres->first()['category'] ?? null,
        ];

        $coCreators = Creator::query()
            ->withCount('games')
            ->where('company_id', $creator->company_id)
            ->whereKeyNot($creator->getKey())
            ->orderByDesc('games_count')
            ->orderBy('first_name')
            ->limit(self::CO_CREATORS_COUNT)
            ->get();

        $previous = Creator::query()->where('id', '<', $creator->id)->orderByDesc('id')->first();
        $next = Creator::query()->where('id', '>', $creator->id)->orderBy('id')->first();

        $structuredData = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $creator->full_name,
            'url' => route('creator.show.page', $creator),
            'image' => $creator->avatar_url,
            'description' => $creator->bio ?: null,
            'jobTitle' => $creator->role ?: null,
            'worksFor' => $creator->company
                ? ['@type' => 'Organization', 'name' => (string) $creator->company->name]
                : null,
            'sameAs' => $socials ? array_values($socials) : null,
        ]);

        return view('pages.creator.show', compact(
            'creator', 'games', 'stats', 'genres', 'socials', 'coCreators', 'previous', 'next', 'structuredData'
        ));
    }

    /**
     * Розподіл ігор за жанрами: від найпоширенішого; за рівності — менший id категорії.
     *
     * @param  Collection<int, Game>  $games
     * @return Collection<int, array{category: Category, count: int, percent: int}>
     */
    private function genres(Collection $games): Collection
    {
        $categorized = $games->filter(fn ($game): bool => $game->category !== null);

        return $categorized
            ->groupBy('category_id')
            ->map(fn (Collection $group): array => [
                'category' => $group->first()->category,
                'count' => $group->count(),
                'percent' => (int) round($group->count() / $categorized->count() * 100),
            ])
            ->sort(fn (array $a, array $b): int => [$b['count'], $a['category']->id] <=> [$a['count'], $b['category']->id])
            ->values();
    }

    /**
     * @return Collection<int, Creator>
     */
    private function stars(): Collection
    {
        return Creator::query()
            ->with('company')
            ->withCount('games')
            ->whereHas('games')
            ->orderByDesc('games_count')
            ->orderBy('first_name')
            ->limit(self::STARS_COUNT)
            ->get();
    }
}
