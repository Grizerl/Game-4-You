<?php

namespace Tests\Feature\Search;

use App\Services\Search\SearchResult;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SearchResultTest extends TestCase
{
    #[Test]
    public function title_falls_back_to_other_language_and_urls_are_localized(): void
    {
        $result = SearchResult::fromHit(['_source' => [
            'type' => 'creator', 'model_id' => '1', 'slug' => 'jane-doe',
            'title' => ['en' => 'Jane Doe'], 'card' => [],
        ]], 'uk');

        $this->assertSame('Jane Doe', $result->title);
        $this->assertNull($result->label);
        $this->assertSame(route('creator.show.page', 'jane-doe'), $result->url);

        $category = SearchResult::fromHit(['_source' => ['type' => 'category', 'model_id' => '5', 'slug' => '', 'title' => ['uk' => 'Екшн'], 'card' => []]], 'uk');
        $this->assertSame(route('games.page', ['category' => 5]), $category->url);
    }

    #[Test]
    public function every_type_links_to_its_public_page(): void
    {
        $url = fn (string $type): string => SearchResult::fromHit(['_source' => ['type' => $type, 'model_id' => '1', 'slug' => 's', 'title' => ['uk' => 'X']]], 'uk')->url;

        $this->assertSame(route('games.show.page', 's'), $url('game'));
        $this->assertSame(route('company.show.page', 's'), $url('company'));
        $this->assertSame(route('news.show.page', 's'), $url('news'));
    }
}
