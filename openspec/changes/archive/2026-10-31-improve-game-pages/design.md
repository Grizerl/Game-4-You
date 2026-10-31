## Context

- `GamesController@index` фільтрує лише за `category`; `show(int $id)` бере `Game::with(['creator','company'])`. Вʼюхи: `pages/game/games.blade.php` (стара сітка, `asset('storage/'.cover)`), `pages/details/detail.blade.php` (модалка коментарів, JS-вкладки з `assets/js/details/btn.js`).
- `Game`: `name`, `description` — переклади; `platforms` — рядок «A, B»; `rating` — ціле без шкали; `isNew`; `created_at` показується як «дата виходу».
- Посилання `route('games.show.page', $game->id)` у `pages/home/index`, `partials/games-list`, `pages/game/games`, `pages/creator/show`, `pages/store/show` та тестах.
- Адмін `GameController`: `Game::all()`, Telegram викликається **до** `save()`, видалення обкладинки через `public_path`/`unlink` (обкладинки лежать на диску `public`), без FormRequest-логіки для slug/файлів.
- Зразки з попередніх змін: scope-и пошуку, `IndexRequest` з мʼяким очищенням, `_form`, `PublicImage`, `SocialLinks`, JSON-LD з `JSON_HEX_*`, harness перевірки адаптиву.
- Візуальна мова: творці/студії — картки-профілі (Unbounded + Manrope, рожевий акцент); ігри мають виглядати інакше: кінематографічно.

## Goals / Non-Goals

**Goals:** окремий візуальний стиль ігор (full-bleed hero, постери, липка навігація, стрічки), повна функціональність із специфікацій, без горизонтального скролу 320–1440 px, мінімум зламаних посилань.

**Non-Goals:** модерація коментарів, оцінки користувачів, зміна шкали рейтингу, перенесення обкладинок, нові шрифти на решті сайту.

## Decisions

1. **Slug** — колонка `slug` unique; генерується в `Game::booted()` з англійської назви (fallback інша, далі `game`), `Str::slug(..., 'uk')`, суфікс `-2…`. `getRouteKeyName() = 'slug'`; `resolveRouteBinding($value, $field = null)` шукає за slug, а для числового значення — за id. Контролер редіректить (301) на канонічний slug, якщо значення в URL не збігається зі slug. Усі посилання переходять на `route('games.show.page', $game)`.
2. **Нові поля:** `released_at` (date, backfill із `created_at`), `trailer_url` (string), `screenshots` (json, `array` cast, шляхи на диску `public`, до 6). Сортування «новизна» — `COALESCE(released_at, DATE(created_at)) DESC, id DESC`.
3. **YouTube** — `App\Support\YouTube::id(?string $url): ?string` (хости `youtube.com`, `www.`, `m.`, `youtu.be`, шляхи `watch?v=`, `embed/`, `shorts/`, `youtu.be/ID`; ID `[A-Za-z0-9_-]{11}`). Валідація адмінки й вʼюха користуються тим самим; плеєр — `https://www.youtube-nocookie.com/embed/{id}` вставляється JS після кліку (до цього лише превʼю `i.ytimg.com`).
4. **Каталог** — scope-и `Game::search` (JSON name, `COLLATE utf8mb4_unicode_ci`, locale + `en`), `inCategory`, `onPlatform` (токен, `CONCAT(',', REPLACE(platforms, ', ', ','), ',') LIKE '%,token,%'` з екрануванням), `sortedBy` (`new|rating|name`). `GamesIndexRequest` (мʼяке очищення). Чіпи жанрів: `Category::withCount('games')`; платформи: `Game::platformOptions()` (унікальні токени). Пагінація 12, `withQueryString()`.
5. **Сторінка гри** — контролер збирає: `game` (+`category`, `creator`, `company`), коментарі (`latest()`), `similar` (той самий жанр, `orderByDesc('rating')`, `limit(6)`), `more` (ігри студії, інакше творця, без поточної, ≤6; обидва джерела обʼєднуються без дублів), `trailerId`, `screenshots` (URL через `PublicImage`), `platforms` (токени). Запитів — фіксована кількість, без N+1.
6. **Коментарі** — `CommentController@store`: `validated()` замість `all()` (mass-assignment), `throttle:5,1` на маршруті, honeypot-поле `website` (заповнене → тихий редірект без створення), редірект на `route('games.show.page', $game).'#comments'` з flash-повідомленням і `withInput`. Вивід — `{{ }}`.
7. **Візуальний стиль** (окремо від `cr-*`): новий `public/assets/css/games.css` з префіксом `gm-`; шрифти Oswald (заголовки, Cyrillic) + Manrope (текст); акцент — бірюзовий `--clr-green-normal` з амбер-рейтингом; hero — `<img>` обкладинки як розмитий фон (`filter: blur`, `scale`) + градієнт-перехід у фон сторінки, постер поверх; липка нав-панель (`position: sticky`) з якорями; горизонтальні стрічки (`scroll-snap`) для «Схожих»/«Ще від…»; каталог — постерні картки 2:3 з оверлеєм і чіпи жанрів у скролюваному ряду. JS (`games.js`): click-to-load трейлер, лайтбокс (Esc, стрілки), підсвічування активного якоря.
8. **Адмінка** — `GameRequest` (базовий) + Store/Update; `payload()` у контролері; обкладинка/скріншоти на диску `public` (`games/`, `games/screenshots/`), старі видаляються через `Storage`; `_form`; `index` із `q` і `paginate(15)`; видалення чистить файли та `comments()->delete()`; Telegram — після `save()` у `try/catch` з `report($e)`.
9. **Тести** — `tests/Feature/Games/*` (модель/scope-и, каталог, сторінка, коментарі, адмінка, локалізація, YouTube); наявні тести творців/студій оновлюються під slug-посилання; в адмін-тестах `Http::fake()`.

## Risks / Trade-offs

- [Backfill `released_at` = `created_at` не обовʼязково справжня дата] → видно в адмінці й редагується; без backfill на сайті зникла б уся «дата виходу».
- [Старі посилання `/games/{id}`] → 301-редірект.
- [Платформи — вільний текст] → токени по комі; змішані регістри не нормалізуються.
- [`rating` без шкали] → показується як число зі ⭐.
- [Обкладинки без файлу на диску] → `PublicImage` + плейсхолдер.

## Migration Plan

1. Міграція: `slug` (nullable → backfill → unique), `released_at` (backfill), `trailer_url`, `screenshots`. 2. Деплой коду. 3. Відкат — `migrate:rollback` прибирає колонки.
