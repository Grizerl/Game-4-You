<?php

namespace Tests\Feature\News;

use App\Models\Article;
use App\Models\Company;
use App\Models\Game;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminNewsTest extends TestCase
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
            'title' => ['uk' => 'Велика новина', 'en' => 'Big News'],
            'excerpt' => ['uk' => 'Короткий анонс', 'en' => 'Short excerpt'],
            'body' => ['uk' => "## Заголовок\n\nТекст.", 'en' => "## Heading\n\nText."],
        ], $overrides);
    }

    private function storedArticle(array $attributes = []): Article
    {
        $cover = UploadedFile::fake()->image('c.jpg')->store('news', 'public');

        return Article::factory()->create(['cover_image' => $cover, ...$attributes]);
    }

    // ---------- доступ і список ----------

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get(route('news.index'))->assertRedirect(route('login'));
        $this->post(route('news.store'), $this->payload())->assertRedirect(route('login'));

        $this->assertDatabaseCount('articles', 0);
    }

    #[Test]
    public function list_shows_statuses_is_paginated_and_searchable(): void
    {
        Article::factory()->count(14)->create();
        $draft = Article::factory()->draft()->create(['title' => ['uk' => 'Чернетка', 'en' => 'Zyxwv Draft']]);
        $scheduled = Article::factory()->scheduled()->create();

        $response = $this->admin()->get(route('news.index'))
            ->assertOk()
            ->assertViewHas('articles', fn ($page): bool => $page->count() === 15 && $page->total() === 16)
            ->assertSee('status-scheduled', false)
            ->assertSee(route('news.show.page', $scheduled), false);

        $this->admin()->get(route('news.index', ['q' => 'zyxwv']))
            ->assertSee('Zyxwv Draft')
            ->assertSee('status-draft', false)
            ->assertDontSee($scheduled->slug);

        $this->assertSame('draft', $draft->status());
    }

    #[Test]
    public function search_survives_pagination_and_sidebar_links_to_news(): void
    {
        Article::factory()->count(16)->create(['title' => ['uk' => 'Пошук', 'en' => 'Searchable']]);

        $this->admin()->get(route('news.index', ['q' => 'searchable']))
            ->assertSee('q=searchable&amp;page=2', false)
            ->assertSee('href="'.route('news.index').'"', false);
    }

    #[Test]
    public function create_form_has_all_fields(): void
    {
        $this->admin()->get(route('news.create'))
            ->assertOk()
            ->assertSee('name="title[uk]"', false)
            ->assertSee('name="excerpt[en]"', false)
            ->assertSee('name="body[uk]"', false)
            ->assertSee('name="slug"', false)
            ->assertSee('name="published_at"', false)
            ->assertSee('name="tags"', false)
            ->assertSee('name="games[]"', false)
            ->assertSee('name="companies[]"', false)
            ->assertSee('data-avatar-preview', false);
    }

    // ---------- створення ----------

    #[Test]
    public function article_can_be_created_with_all_fields(): void
    {
        $games = Game::factory()->count(2)->create();
        $company = Company::factory()->create();

        $this->admin()->post(route('news.store'), $this->payload([
            'slug' => 'custom-slug',
            'published_at' => '2026-03-05T10:30',
            'tags' => 'Огляди|Reviews, Новини',
            'games' => $games->pluck('id')->all(),
            'companies' => [$company->id],
            'cover_image' => UploadedFile::fake()->image('cover.jpg', 1280, 720),
        ]))->assertRedirect(route('news.index'));

        $article = Article::firstOrFail();

        $this->assertSame('custom-slug', $article->slug);
        $this->assertSame('2026-03-05 10:30', $article->published_at->format('Y-m-d H:i'));
        $this->assertSame('Велика новина', $article->getTranslation('title', 'uk'));
        $this->assertSame("## Heading\n\nText.", $article->getTranslation('body', 'en'));
        $this->assertEqualsCanonicalizing($games->pluck('id')->all(), $article->games->pluck('id')->all());
        $this->assertSame([$company->id], $article->companies->pluck('id')->all());
        $this->assertCount(2, $article->tags);
        $this->assertContains('reviews', $article->tags->pluck('slug')->all());
        Storage::disk('public')->assertExists($article->cover_image);
    }

    #[Test]
    public function article_without_date_is_a_draft_without_cover(): void
    {
        $this->admin()->post(route('news.store'), $this->payload())->assertRedirect(route('news.index'));

        $article = Article::firstOrFail();

        $this->assertNull($article->published_at);
        $this->assertNull($article->cover_image);
        $this->assertSame('draft', $article->status());
        $this->assertSame('big-news', $article->slug);

        $this->get(route('news.page'))->assertDontSee('Велика новина');
    }

    #[Test]
    public function future_date_schedules_publication(): void
    {
        $this->admin()->post(route('news.store'), $this->payload(['published_at' => now()->addDays(2)->format('Y-m-d\TH:i')]));

        $article = Article::firstOrFail();

        $this->assertSame('scheduled', $article->status());
        auth()->logout();

        $this->get(route('news.show.page', $article))->assertNotFound();
    }

    #[Test]
    public function missing_required_fields_are_rejected_and_input_preserved(): void
    {
        $this->admin()->from(route('news.create'))->post(route('news.store'), [
            'title' => ['uk' => '', 'en' => 'Only English'],
            'excerpt' => ['uk' => 'Анонс', 'en' => 'Excerpt'],
        ])
            ->assertRedirect(route('news.create'))
            ->assertSessionHasErrors(['title.uk', 'body.uk', 'body.en'])
            ->assertSessionHasInput('title.en', 'Only English');

        $this->assertDatabaseCount('articles', 0);
    }

    // ---------- теги ----------

    #[Test]
    public function tags_are_created_once_and_reused_across_articles(): void
    {
        $this->admin()->post(route('news.store'), $this->payload(['tags' => 'Огляди|Reviews, Новини']));
        $this->admin()->post(route('news.store'), $this->payload(['title' => ['en' => 'Second'], 'tags' => ' reviews|Reviews ,Новини,, ']));

        $this->assertDatabaseCount('tags', 2);
        $this->assertDatabaseCount('article_tag', 4);
        $this->assertSame(['reviews'], Tag::where('slug', 'reviews')->pluck('slug')->all());
    }

    #[Test]
    public function tags_are_fully_replaced_on_update_and_can_be_cleared(): void
    {
        $article = $this->storedArticle();
        $article->tags()->attach(Tag::factory()->count(2)->create());

        $this->admin()->put(route('news.update', $article), $this->payload(['tags' => 'Нова тема|New topic']))
            ->assertSessionHasNoErrors();

        $this->assertSame(['new-topic'], $article->fresh()->tags->pluck('slug')->all());

        $this->admin()->put(route('news.update', $article), $this->payload(['tags' => '']))->assertSessionHasNoErrors();

        $this->assertCount(0, $article->fresh()->tags);
        $this->assertDatabaseCount('tags', 3);
    }

    #[Test]
    public function overlong_tag_names_are_rejected(): void
    {
        $this->admin()->post(route('news.store'), $this->payload(['tags' => str_repeat('a', 61)]))->assertSessionHasErrors('tags');

        $this->assertDatabaseCount('articles', 0);
    }

    // ---------- slug ----------

    #[Test]
    public function generated_slug_is_unique_and_reserved_words_are_avoided(): void
    {
        $this->admin()->post(route('news.store'), $this->payload());
        $this->admin()->post(route('news.store'), $this->payload());
        $this->admin()->post(route('news.store'), $this->payload(['title' => ['en' => 'Feed']]));

        $this->assertSame(['big-news', 'big-news-2', 'feed-news'], Article::orderBy('id')->pluck('slug')->all());
    }

    #[Test]
    public function manual_slug_must_be_unique_well_formed_and_not_reserved(): void
    {
        Article::factory()->create(['slug' => 'taken']);

        $admin = $this->admin();

        $admin->post(route('news.store'), $this->payload(['slug' => 'taken']))->assertSessionHasErrors('slug');
        $admin->post(route('news.store'), $this->payload(['slug' => 'Bad Slug!']))->assertSessionHasErrors('slug');
        $admin->post(route('news.store'), $this->payload(['slug' => 'feed']))->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('articles', 1);
    }

    #[Test]
    public function renaming_keeps_slug_and_slug_may_equal_its_own_value(): void
    {
        $article = $this->storedArticle(['slug' => 'old-slug']);

        $this->admin()->put(route('news.update', $article), $this->payload(['slug' => '']))->assertSessionHasNoErrors();
        $this->assertSame('old-slug', $article->fresh()->slug);

        $this->admin()->put(route('news.update', $article), $this->payload(['slug' => 'old-slug']))->assertSessionHasNoErrors();
        $this->admin()->put(route('news.update', $article), $this->payload(['slug' => 'new-slug']))->assertSessionHasNoErrors();

        $this->assertSame('new-slug', $article->fresh()->slug);
    }

    // ---------- валідація ----------

    #[Test]
    public function invalid_values_are_rejected(): void
    {
        $admin = $this->admin();

        $admin->post(route('news.store'), $this->payload(['excerpt' => ['uk' => str_repeat('а', 301)]]))->assertSessionHasErrors('excerpt.uk');
        $admin->post(route('news.store'), $this->payload(['published_at' => 'not a date']))->assertSessionHasErrors('published_at');
        $admin->post(route('news.store'), $this->payload(['games' => [99999]]))->assertSessionHasErrors('games.0');
        $admin->post(route('news.store'), $this->payload(['companies' => [99999]]))->assertSessionHasErrors('companies.0');
        $admin->post(route('news.store'), $this->payload(['cover_image' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')]))->assertSessionHasErrors('cover_image');
        $admin->post(route('news.store'), $this->payload(['cover_image' => UploadedFile::fake()->image('big.png')->size(5000)]))->assertSessionHasErrors('cover_image');

        $this->assertDatabaseCount('articles', 0);
    }

    // ---------- редагування ----------

    #[Test]
    public function edit_form_is_prefilled(): void
    {
        $game = Game::factory()->create();
        $company = Company::factory()->create();
        $article = $this->storedArticle([
            'title' => ['uk' => 'Назва', 'en' => 'Prefilled Title'],
            'slug' => 'prefilled',
            'published_at' => '2026-03-05 10:30:00',
        ]);
        $article->tags()->attach(Tag::factory()->create(['name' => ['uk' => 'Огляди', 'en' => 'Reviews']]));
        $article->games()->attach($game);
        $article->companies()->attach($company);

        $this->admin()->get(route('news.edit', $article))
            ->assertOk()
            ->assertSee('value="Prefilled Title"', false)
            ->assertSee('value="prefilled"', false)
            ->assertSee('value="2026-03-05T10:30"', false)
            ->assertSee('value="Огляди|Reviews"', false)
            ->assertSee('<option value="'.$game->id.'" selected>', false)
            ->assertSee('<option value="'.$company->id.'" selected>', false)
            ->assertSee($article->cover_url, false);
    }

    #[Test]
    public function update_without_file_keeps_cover_and_replacing_deletes_old_file(): void
    {
        $article = $this->storedArticle();
        $old = $article->cover_image;

        $this->admin()->put(route('news.update', $article), $this->payload())->assertRedirect(route('news.index'));

        $this->assertSame($old, $article->fresh()->cover_image);
        Storage::disk('public')->assertExists($old);

        $this->admin()->put(route('news.update', $article), $this->payload(['cover_image' => UploadedFile::fake()->image('new.png')]));

        $new = $article->fresh()->cover_image;
        $this->assertNotSame($old, $new);
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($new);
    }

    #[Test]
    public function related_games_and_studios_are_fully_replaced_on_update(): void
    {
        $article = $this->storedArticle();
        [$oldGame, $newGame] = Game::factory()->count(2)->create()->all();
        $article->games()->attach($oldGame);
        $article->companies()->attach(Company::factory()->create());

        $this->admin()->put(route('news.update', $article), $this->payload(['games' => [$newGame->id]]))->assertSessionHasNoErrors();

        $this->assertSame([$newGame->id], $article->fresh()->games->pluck('id')->all());
        $this->assertCount(0, $article->fresh()->companies);
    }

    // ---------- видалення ----------

    #[Test]
    public function deleting_removes_record_cover_and_links_but_keeps_related_entities(): void
    {
        $game = Game::factory()->create();
        $tag = Tag::factory()->create();
        $article = $this->storedArticle();
        $article->games()->attach($game);
        $article->tags()->attach($tag);

        $this->admin()->delete(route('news.destroy', $article))->assertRedirect(route('news.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
        Storage::disk('public')->assertMissing($article->cover_image);
        $this->assertDatabaseMissing('article_game', ['article_id' => $article->id]);
        $this->assertDatabaseMissing('article_tag', ['article_id' => $article->id]);
        $this->assertDatabaseHas('games', ['id' => $game->id]);
        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }

    #[Test]
    public function deleting_article_without_cover_works(): void
    {
        $article = Article::factory()->draft()->create();

        $this->admin()->delete(route('news.destroy', $article))->assertRedirect(route('news.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
