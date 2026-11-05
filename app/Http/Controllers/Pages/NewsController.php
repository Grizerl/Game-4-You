<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\NewsIndexRequest;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class NewsController extends Controller
{
    private const PER_PAGE = 9;

    private const RELATED_LIMIT = 3;

    private const FEED_LIMIT = 20;

    public function index(NewsIndexRequest $request): View
    {
        $filtered = $request->hasFilters();

        // Найновіший матеріал — топ-картка першої сторінки; у сітці його немає на жодній сторінці.
        $top = $filtered ? null : Article::query()->published()->newest()->with('tags')->first();

        $articles = Article::query()
            ->published()
            ->with('tags')
            ->search($request->search())
            ->withTag($request->tag())
            ->when($top, fn ($query) => $query->whereKeyNot($top->id))
            ->newest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $featured = $top !== null && Paginator::resolveCurrentPage() === 1 ? $top : null;

        $tags = Tag::query()
            ->withCount(['articles' => fn ($query) => $query->published()])
            ->having('articles_count', '>', 0)
            ->get()
            ->sortBy(fn (Tag $tag): string => mb_strtolower((string) $tag->name))
            ->values();

        $filters = ['q' => $request->search(), 'tag' => $request->tag()];

        return view('pages.news.index', compact('articles', 'featured', 'tags', 'filters', 'top'));
    }

    public function show(Article $article): View
    {
        // Чернетки й заплановані матеріали бачить лише авторизований адміністратор (попередній перегляд).
        abort_unless($article->isPublished() || auth()->check(), 404);

        $article->load(['tags', 'games.category', 'companies']);

        $related = $this->related($article);

        $structuredData = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => (string) $article->title,
            'url' => route('news.show.page', $article),
            'mainEntityOfPage' => route('news.show.page', $article),
            'image' => [$article->cover_url],
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at?->toIso8601String(),
            'description' => (string) $article->excerpt,
            'inLanguage' => app()->getLocale(),
            'keywords' => $article->tags->map(fn (Tag $tag): string => (string) $tag->name)->implode(', ') ?: null,
            'publisher' => ['@type' => 'Organization', 'name' => 'Games 4 You'],
        ]);

        return view('pages.news.show', compact('article', 'related', 'structuredData'));
    }

    public function feed(): Response
    {
        $articles = Article::query()->published()->newest()->limit(self::FEED_LIMIT)->get();

        $esc = fn (mixed $value): string => htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        $items = $articles->map(fn (Article $article): string => sprintf(
            "    <item>\n      <title>%s</title>\n      <link>%s</link>\n      <guid isPermaLink=\"true\">%s</guid>\n      <pubDate>%s</pubDate>\n      <description>%s</description>\n    </item>\n",
            $esc($article->title),
            $esc(route('news.show.page', $article)),
            $esc(route('news.show.page', $article)),
            $article->published_at->toRfc2822String(),
            $esc($article->excerpt),
        ))->implode('');

        $xml = sprintf(
            "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n  <channel>\n    <title>%s</title>\n    <link>%s</link>\n    <description>%s</description>\n    <language>%s</language>\n    <lastBuildDate>%s</lastBuildDate>\n    <atom:link href=\"%s\" rel=\"self\" type=\"application/rss+xml\"/>\n%s  </channel>\n</rss>\n",
            $esc(__('news.feed_title')),
            $esc(route('news.page')),
            $esc(__('news.meta_description')),
            $esc(app()->getLocale()),
            ($articles->first()?->published_at ?? now())->toRfc2822String(),
            $esc(route('news.feed.page')),
            $items,
        );

        return response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=UTF-8']);
    }

    /**
     * До трьох інших опублікованих матеріалів: спершу зі спільними тегами/іграми, далі найновіші.
     *
     * @return Collection<int, Article>
     */
    private function related(Article $article): Collection
    {
        $tagIds = $article->tags->pluck('id')->all() ?: [0];
        $gameIds = $article->games->pluck('id')->all() ?: [0];

        return Article::query()
            ->published()
            ->whereKeyNot($article->id)
            ->withCount([
                'tags as shared_tags' => fn ($query) => $query->whereIn('tags.id', $tagIds),
                'games as shared_games' => fn ($query) => $query->whereIn('games.id', $gameIds),
            ])
            ->with('tags')
            ->orderByRaw('(shared_tags + shared_games) DESC')
            ->newest()
            ->limit(self::RELATED_LIMIT)
            ->get();
    }
}
