## Context

- Сторінки творців, студій, ігор і головна вже мають усталений набір практик: slug у моделі, scope-и пошуку, `IndexRequest` з мʼяким очищенням параметрів, `CreatorRequest`-подібні базові FormRequest-и, `_form` у адмінці, `PublicImage`, JSON-LD з `JSON_HEX_*`, harness для перевірки адаптиву.
- Візуальна мова нових сторінок: `gm-page` (змінні, Oswald + Manrope, `games.css`), чіпи жанрів із стрілками (`data-gm-chips`, `games.js`).
- Markdown: у Laravel є `Str::markdown()` (`league/commonmark`, GFM), розширення `ExternalLinkExtension` вже в залежності.
- Назви/описи — переклади (`spatie/laravel-translatable`) у колонках JSON (`text`, не `string`, бо двомовний JSON довший за 255 символів).
- Адмінський `Route::resource('news')` за замовчуванням дає параметр `{news}`, тож потрібен `->parameters(['news' => 'article'])` для неявної привʼязки `Article $article`.

## Goals / Non-Goals

**Goals:** повноцінний редакційний розділ (список, стаття, теги, звʼязок з іграми/студіями, RSS, чернетки/планування) з безпечним Markdown, власним журнальним виглядом і без горизонтального скролу 320–1440 px.

**Non-Goals:** коментарі до новин, WYSIWYG, лічильники переглядів, автори, розсилка, окремий CRUD тегів.

## Decisions

1. **Схема БД** — `articles` (`slug` unique, `title`/`excerpt`/`body` text-JSON, `cover_image` nullable, `published_at` nullable datetime, timestamps), `tags` (`slug` unique, `name` text-JSON), звʼязки `article_tag`, `article_game`, `article_company` (composite PK, FK з `cascadeOnDelete`).
2. **Публікація** — немає окремого статусу: `published_at IS NULL` → чернетка, `> now()` → заплановано, інакше опубліковано. Scope `published()`; метод `isPublished()`/`status()`. Планування працює без планувальника: фільтр за поточним часом.
3. **Slug** — `Article::booted()` (`creating`): з англійського заголовка (fallback будь-який), `Str::slug(..., 'uk')`; суфікс `-2…`; зарезервовані `feed` (отримує базу `feed-news`) і суто числові (префікс `news-`). Маршрут `GET /news/{article:slug}`; `GET /news/feed` оголошується **раніше**.
4. **Markdown** — `Article::bodyHtml()`: `Str::markdown($body, ['html_input' => 'strip', 'allow_unsafe_links' => false, 'external_link' => [...internal_hosts, open_in_new_window, nofollow/noopener/noreferrer 'external']], [new ExternalLinkExtension])`. Текст беруть у поточній мові з fallback. Результат виводиться `{!! !!}` (CommonMark з вимкненим HTML безпечний). Час читання — слова з очищеного тексту / 200, мінімум 1.
5. **Теги в адмінці** — один рядок `Назва|Name, ...`: парсер у `ArticleRequest` (`prepareForValidation` формує `tag_names`) і в контролері `syncTags()` (`firstOrCreate` за slug з англійської назви; `sync` повністю замінює набір). Валідація довжини назв.
6. **Список** — `NewsIndexRequest` (`q`, `tag`), scope-и `published`, `search` (JSON title, `COLLATE utf8mb4_unicode_ci`, поточна мова + `en`), `withTag`. Топ-картка: перший опублікований, якщо немає фільтрів і це перша сторінка (його виключено з сітки через offset-запит: топ береться окремо, сітка — `where id != top`). Пагінація 9, `withQueryString()`. Чіпи тегів — `Tag::withCount(published articles)->having > 0`.
7. **Сторінка статті** — привʼязка за slug; якщо не опубліковано й гість → 404, адмін (авторизований) бачить із банером. «Читайте також»: статті зі спільними тегами/іграми (по кількості збігів), добираються найновішими до трьох. `with(['tags','games.category','companies'])`, фіксована кількість запитів.
8. **RSS** — `NewsController@feed` повертає `response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=UTF-8'])`; XML будується з екрануванням `htmlspecialchars` (ENT_XML1), `<lastBuildDate>`, 20 елементів, `<guid isPermaLink="true">`; автопошук `<link rel="alternate" type="application/rss+xml">` у списку.
9. **Візуальний стиль** — `news.css` (`nw-`): журнальна сітка (топ-картка на всю ширину з обкладинкою-фоном та градієнтом, 3 колонки карток, чіпи тегів з `data-gm-chips`), сторінка статті — hero з обкладинкою 21:9, вузька колонка тексту (`max-width: 68ch`), типографіка `.nw-prose` (h2/h3, цитати з акцентною лінією, списки, таблиці з прокруткою, код, зображення `max-width:100%`), прогрес-смуга. `news.js`: прогрес читання, копіювання посилання; чіпи тегів — наявний `games.js`.
10. **Інтеграція** — пункт «Новини» в `header` (десктоп і мобільне меню, ключ `header.news`), блок на головній (3 найновіші; `HomeController` додає `latestNews`), delta-специфікація `home-public`.
11. **Адмінка** — `ArticleRequest` (+ Store/Update), `Dashboard\Pages\ArticleController` (payload, slug, обкладинка на диск `public` у `news/`, видалення файлу, `sync` звʼязків), `_form` із `select multiple` для ігор/студій, список зі статусами. Дата публікації — `datetime-local`.
12. **Тести** — `tests/Feature/News/*` (модель/Markdown, список, стаття, RSS, адмінка, головна, локалізація, запити).

## Risks / Trade-offs

- [Markdown XSS] → `html_input: strip`, `allow_unsafe_links: false`, тести на `<script>` і `javascript:`; зображення — лише `http(s)`.
- [Теги текстом без довідника] → підказка у формі; нормалізація slug; дублікати зливаються.
- [Slug `feed` і числові slug] → зарезервовано/префіксовано.
- [Планування без cron] → фільтр за часом у запитах; кеш не використовується.
- [Великі `select multiple` у адмінці] → допустимо для поточних обсягів.

## Migration Plan

1. Міграція (нові таблиці). 2. Деплой коду. 3. Відкат — `migrate:rollback` видаляє таблиці.
