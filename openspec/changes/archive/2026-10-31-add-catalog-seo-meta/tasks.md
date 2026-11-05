## 1. SEO каталогів

- [x] 1.1 Ключі `meta_title` / `meta_description_*` у `lang/{uk,en}/{game,creators,companies}.php`
- [x] 1.2 `@push('head')` (description, canonical, hreflang, og:*) у `games`, `creators`, `stores`
- [x] 1.3 `@section('title')` з `meta_title`, щоб збігався з `og:title`
- [ ] 1.4 Feature-тести: description, canonical, hreflang, og:* для трьох каталогів (uk/en)

## 2. RSS

- [x] 2.1 Прибрати посилання `.nw-rss` і `<link rel="alternate">` зі списку новин; видалити `news.rss` та CSS
- [x] 2.2 Оновити `NewsListingTest` (посилання відсутнє); ендпоінт `/news/feed` без змін
- [ ] 2.3 Запустити `php artisan test` у `workspace-84`, потім `/opsx:sync` та `/opsx:archive`
