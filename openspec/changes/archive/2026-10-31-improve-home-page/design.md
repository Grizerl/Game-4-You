## Context

- `HomeController@index` бере `Game::latest()->paginate(6)`, фільтр `category_id`, `Game::where('isNew', 1)->get()` без eager loading. `pages/home/index.blade.php` — старі картки (`asset('storage/'.cover)`, `created_at` як реліз), Swiper-слайдер, бургер жанрів, `<button><a>`.
- `layouts/main.blade.php` підключає Swiper (CSS/JS CDN) і `assets/js/swiper/swiper.js` на всіх сторінках; Swiper потрібен лише головній. `menu.js` обробляє бургер мобільного меню (і `btn-category`, null-safe).
- Готові компоненти: `gm-poster`, `gm-strip`, `gm-chips` (games.css, Oswald+Manrope), `cr-mini` (творці), `Game::cover_url`, `Company::logo_url`, `Game::released_at`, `trailerId()`.
- `pages/home/main.blade.php` (812 рядків) і `partials/games-list.blade.php` — мертвий/застарілий код.
- ffmpeg відсутній у середовищі: відео згенеровано контейнером `jrottenberg/ffmpeg` (процедурний неоновий луп 1280×720, пінг-понг для безшовності).

## Goals / Non-Goals

**Goals:** відео-hero без шкоди для продуктивності й доступності, сучасна вітрина на готових компонентах, без N+1, анімації, що деградують до статичного вигляду.

**Non-Goals:** керування hero з адмінки, глобальний пошук, переписування шапки/футера, нові шрифти для решти сайту.

## Decisions

1. **Відео** — `<video muted loop autoplay playsinline preload="metadata" poster>` з `<source>` WebM (першим) та MP4. `home.js`: якщо `matchMedia('(prefers-reduced-motion: reduce)')` або `navigator.connection.saveData` — `video.removeAttribute('autoplay')`, `pause()`, лишається постер; інакше `play()` (помилку автоплею ігноруємо). Кнопки паузи/звуку з `aria-pressed` і підписами з перекладів. Файли — `public/assets/video/hero.{mp4,webm}` + `hero-poster.jpg`; відео-елемент не рендерить `src`, поки не потрібне (`preload=metadata`).
2. **Анімації без шкоди для SEO/no-JS** — початковий прихований стан (`.hm-reveal`) застосовується лише коли `html.hm-js` (клас ставить інлайн-скрипт у `<head>`/на початку вмісту); `IntersectionObserver` додає `.is-visible`. `prefers-reduced-motion` у CSS обнуляє переходи, JS одразу показує все. Лічильники: початкове значення — реальне число в HTML, JS лише анімує від 0 при появі.
3. **Дані** (`HomeController`): `stats` (три `count()`), `newGames` (`COALESCE(released_at, DATE(created_at)) DESC`, 6, `with('category')`), `topGames` (`rating DESC`, 6), `spotlight` (пріоритет: `isNew` з `trailer_url` → `isNew` за рейтингом → найвищий рейтинг; з `with(['category'])`; trailer перевіряється `trailerId()`), `genres` (`Category::withCount('games')->having('games_count','>',0)`), `companies` (`Company::latest()->limit(16)`; стрічка дублюється в розмітці для безшовного циклу), `creators` (`withCount('games')`, `whereHas('games')`, топ-4), `comments` (`with('game')->latest()->limit(6)`; коментарі до видалених ігор не показуються). Запитів — фіксована кількість.
4. **Вкладки «Нові/Топ»** — обидві стрічки в HTML (SEO, no-JS), JS перемикає `hidden`/`is-active`; ARIA `role=tablist/tab/tabpanel`.
5. **Стилі/шрифти** — `home.css` (префікс `hm-`) + `games.css` (для `gm-poster`, `gm-strip`, Oswald/Manrope); головна вживає ту саму візуальну мову, що й каталог ігор. Підключення — партіал `pages/home/partials/assets.blade.php`.
6. **Конфіг** — `config/services.php`: `social.steam`, `social.discord` з `env('SOCIAL_STEAM_URL')`/`env('SOCIAL_DISCORD_URL')` із розумними значеннями за замовчуванням.
7. **Редірект** — `?category_id=N` → `redirect()->route('games.page', ['category' => N], 301)` на початку `index`.
8. **Прибирання** — видалити `main.blade.php`, `partials/games-list.blade.php`, `assets/js/swiper/swiper.js`; з `layouts/main.blade.php` прибрати Swiper CSS/JS; `@stack('scripts')` лишається.
9. **SEO** — `title`, `description`, canonical, hreflang, `og:*`, JSON-LD `WebSite` (`potentialAction: SearchAction`, `urlTemplate = route('games.page').'?q={search_term_string}'`) через `json_encode` з `JSON_HEX_*`.
10. **Тести** — `tests/Feature/Home/*`; перевіряється наявність відео-файлів, розмітка hero, порядок стрічок, spotlight, плитки, редірект, SEO, порожній сайт, запити.

## Risks / Trade-offs

- [Вага відео] → ≈1 МБ MP4 / ≈0,35 МБ WebM, `preload=metadata`, відсутнє при reduced-motion/Save-Data.
- [Автоплей блокується браузером] → постер лишається, кнопка «відтворити» запускає вручну.
- [Процедурне відео не «реальний геймплей»] → файли замінні без змін коду.
- [Видалення Swiper] → зображення слайдера лишаються на диску; за потреби його легко повернути.

## Migration Plan

Деплой коду разом із відео-файлами; нових міграцій немає; відкат — повернення попереднього коміту.
