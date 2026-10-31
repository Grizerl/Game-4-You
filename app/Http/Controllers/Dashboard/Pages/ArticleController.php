<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\StoreRequest;
use App\Http\Requests\Admin\Article\UpdateRequest;
use App\Models\Article;
use App\Models\Company;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    private const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $articles = Article::query()
            ->withCount('tags')
            ->search(is_string($search) ? $search : null)
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('dashboard.news.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.news.create', $this->formData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $article = new Article($this->payload($request->validated()));

        if ($request->hasFile('cover_image')) {
            $article->cover_image = $request->file('cover_image')->store('news', 'public');
        }

        $article->save();
        $this->syncRelations($article, $request->validated());

        return redirect()->route('news.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        $article->load(['tags', 'games:id', 'companies:id']);

        return view('dashboard.news.edit', ['article' => $article] + $this->formData());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Article $article): RedirectResponse
    {
        $article->fill($this->payload($request->validated()));

        if ($request->hasFile('cover_image')) {
            $this->deleteFile($article->cover_image);
            $article->cover_image = $request->file('cover_image')->store('news', 'public');
        }

        $article->save();
        $this->syncRelations($article, $request->validated());

        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $this->deleteFile($article->cover_image);

        // Звʼязки з тегами, іграми й студіями видаляються каскадом; сутності лишаються.
        $article->delete();

        return redirect()->route('news.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'games' => Game::select('id', 'name')->orderBy('id')->get(),
            'companies' => Company::select('id', 'name')->orderBy('id')->get(),
            'knownTags' => Tag::query()->get(),
        ];
    }

    /**
     * Порожні переклади не зберігаються; порожній slug означає «згенерувати» (створення)
     * або «лишити чинний» (редагування). Файли й звʼязки обробляються окремо.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        unset($data['cover_image'], $data['tags'], $data['games'], $data['companies']);

        foreach (['title', 'excerpt', 'body'] as $key) {
            $data[$key] = array_filter($data[$key] ?? [], 'filled');
        }

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        return $data;
    }

    /**
     * Теги, ігри й студії статті повністю замінюються введеним набором.
     *
     * @param  array<string, mixed>  $data
     */
    private function syncRelations(Article $article, array $data): void
    {
        $tagIds = collect(Tag::parseInput($data['tags'] ?? null))
            ->map(fn (array $names): int => Tag::resolve($names)->id)
            ->all();

        $article->tags()->sync($tagIds);
        $article->games()->sync($data['games'] ?? []);
        $article->companies()->sync($data['companies'] ?? []);
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
