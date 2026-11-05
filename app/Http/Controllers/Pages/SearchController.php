<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\SearchRequest;
use App\Services\Search\SearchResult;
use App\Services\Search\SearchService;
use App\Services\Search\SearchUnavailableException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Результати для випадаючого списку в шапці. 422 — порожній/закороткий запит,
     * 503 — пошук вимкнений або недоступний (без технічних деталей), 200 — список (може бути порожнім).
     */
    public function suggest(SearchRequest $request, SearchService $search): JsonResponse
    {
        if (! $search->enabled()) {
            return response()->json(['items' => []], 503);
        }

        try {
            $items = array_map(fn (SearchResult $result): array => [
                'type' => $result->type,
                'title' => $result->title,
                'label' => $result->label,
                'url' => $result->url,
            ], $search->suggest($request->search(), app()->getLocale()));
        } catch (SearchUnavailableException $e) {
            Log::warning('Search is unavailable: '.$e->getMessage());

            return response()->json(['items' => []], 503);
        }

        return response()->json(['items' => $items]);
    }
}
