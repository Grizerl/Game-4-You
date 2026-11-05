## Context

- `Pages\CompanyController@index` — `Company::all()`; вʼюха `pages/store/stores.blade.php`. `Company` має лише `creator()`; `name`, `description`, `country` — переклади (також `array` cast).
- Логотипи адмінка кладе в `public/uploads/company/<ts>_<name>` і зберігає `uploads/company/...`; сайт використовує `asset($logo_path)`. `PublicImage` зараз вважає такі шляхи шляхами `storage/`.
- `Game.company_id` — студія гри, `Creator.company_id` — команда: різні звʼязки.
- Зразок — `improve-creators-pages` (архів): профіль, scope-и, `IndexRequest`, `CreatorRequest`, `_form`, `creators.css`, шрифти, JSON-LD.
- Адмін-контролер без FormRequest-логіки для slug/файлів; `index` — `get()` без пагінації.

## Goals / Non-Goals

**Goals:** дзеркальна функціональність і вигляд зі сторінками творців; мінімум дублювання (спільна статистика ігор і соцпосилання); адаптивність без горизонтального скролу 320–1440 px.

**Non-Goals:** перенесення логотипів у `storage`, редіректи зі старих URL, Elasticsearch, зміна сторінки ігор.

## Decisions

1. **Slug** — колонка `slug` unique; генерується в `Company::booted()` з англійської назви (fallback — будь-яка наявна, далі `company`), `Str::slug(..., 'uk')`, суфікс `-2…`. Backfill у міграції декодує JSON назви. Маршрут `GET /company/{company:slug}`, імʼя `company.show.page`. *Альтернатива:* id в URL — відхилено (узгодженість із творцями).
2. **Нові поля:** `founded_year` (`unsignedSmallInteger`), `socials` (json, `array` cast, ті самі ключі, що у творців). Ключі й фільтр безпечних URL виносимо в `App\Support\SocialLinks` (`KEYS`, `safe(?array)`); `Creator::SOCIAL_KEYS` лишається аліасом, `Creator::socialLinks()` делегує.
3. **Статистика** — `App\Support\GameStatistics::for(Collection $games)` повертає `count`, `average`, `max`, `genres` (з відсотками, tie-break за меншим id), `main_genre`; її використовують `CreatorController` (рефакторинг без зміни поведінки, покритий наявними тестами) і `CompanyController`.
4. **Список** — scope-и `search` (екранування; `JSON_UNQUOTE(JSON_EXTRACT(name,'$.<locale>'))` з fallback на `en`), `inCountry`, `sortedBy` (`games|name|new`, невідоме → `new`; `name` — за JSON-значенням поточної локалі), `CompanyIndexRequest` (м'яке очищення параметрів), `withCount(['games','creators'])`, `paginate(12)->withQueryString()`. Країни для фільтра — унікальні значення поточної мови. «Топ-студії» — окремий запит (`whereHas('games')`, топ-3).
5. **Звʼязки** — `Company::games()`, `Company::creators()`; наявний `creator()` лишається (використовується в `whereHas`).
6. **Логотип** — accessor `logo_url`: `PublicImage::url($logo_path, placeholder)`; `PublicImage` отримує правило `uploads/` → `asset()` без `storage/`. Плейсхолдер `assets/images/companies/placeholder.svg`. Схема зберігання файлів не змінюється.
7. **Вʼюхи** — `pages/store/stores.blade.php` переписується (список), додаються `show.blade.php` і partials `card`/`game-card`; мініатюри творців — наявний `pages.creator.partials.mini`. Стилі: `creators.css` (загальні `cr-*`, шрифти) підключається й тут через `partials.assets`; специфічне (картка студії, hero-банер, сітка ігор) — `companies.css`. Шрифти — Unbounded + Manrope, як у творців.
8. **SEO** — як у творців, JSON-LD `Organization` (`@json` з `JSON_HEX_*`).
9. **Адмінка** — `CompanyRequest` (базовий) + тонкі Store/Update; `payload()` у контролері як у творців; `_form.blade.php`; `index` з `q` і `paginate(15)`; логотип зберігається як зараз (public/uploads/company), старий файл видаляється. Валідація: `founded_year` 1970..поточний, `socials` як у творців, `logo_path` ≤ 2 МБ, `slug` regex+unique.
10. **Тести** — `tests/Feature/Companies/*` (модель, список, профіль, адмінка, локалізація) за зразком творців; `CompanyFactory` розширюється (`founded_year`, `socials`, `withoutLogo()`).

## Risks / Trade-offs

- [Сортування/пошук за JSON-полем повільні] → малі обсяги, інкапсульовано в scope.
- [Логотипи в `public/uploads`: файл у git-ignored/деплой] → без змін, поза обсягом.
- [Рефакторинг творців] → наявні 68 тестів мають лишитися зеленими.
- [`Game.company_id` ≠ `Creator.company_id`] → дві окремі кількості в UI й тестах.

## Migration Plan

1. Міграція: `slug` nullable → backfill → unique; `founded_year`, `socials`. 2. Деплой коду. 3. Відкат — `migrate:rollback` прибирає нові колонки.
