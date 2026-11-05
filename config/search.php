<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;

return [

    /*
    | Головний перемикач пошуку. Коли false, застосунок не звертається до Elasticsearch,
    | а сторінка пошуку показує повідомлення про недоступність.
    */
    'enabled' => (bool) env('SEARCH_ENABLED', false),

    'hosts' => array_values(array_filter(array_map('trim', explode(',', (string) env('ELASTICSEARCH_HOST', 'http://elasticsearch-9:9200'))))),

    'username' => env('ELASTICSEARCH_USERNAME'),
    'password' => env('ELASTICSEARCH_PASSWORD'),
    'api_key' => env('ELASTICSEARCH_API_KEY'),

    // Псевдонім індексу; реальні індекси називаються "<alias>_v<timestamp>".
    'index' => env('SEARCH_INDEX', 'games4you_content'),

    // Короткі таймаути (секунди) для запитів відвідувачів; для індексації вони більші.
    'timeout' => 3,
    'connect_timeout' => 1,
    'index_timeout' => 30,

    'locales' => ['uk', 'en'],

    // Тип документа => модель.
    'models' => [
        'game' => Game::class,
        'category' => Category::class,
        'creator' => Creator::class,
        'company' => Company::class,
        'news' => Article::class,
    ],

    'per_page' => 12,
    'group_limit' => 6,
    'suggest_limit' => 8,
    'max_query_length' => 100,
    'reindex_chunk' => 200,
];
