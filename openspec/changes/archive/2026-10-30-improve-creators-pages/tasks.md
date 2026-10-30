## 1. Тестова інфраструктура та база даних

Усі команди — всередині `workspace-84` (див. CLAUDE.md).

- [x] 1.1 Додати `database/factories/UserFactory.php` (з `email_verified_at`) і `CompanyFactory.php`; перевірити в `php artisan tinker`, що `User::factory()->create()` і `Company::factory()->create()` працюють
- [x] 1.2 Переписати зв'язки в `CreatorFactory` і `GameFactory` на `Company::factory()`/`Category::factory()`/`Creator::factory()` замість `numberBetween(1, 19)`; перевірити, що `Game::factory()->create()` проходить на порожній БД `game_test`
- [x] 1.3 Написати міграцію для `creators`: `slug` (nullable → backfill → unique), `country` (json, nullable), `career_start` (unsignedSmallInteger, nullable), `socials` (json, nullable), `avatar` → nullable; backfill унікалізує колізії суфіксом і для порожнього результату ставить `creator-{id}`; перевірити `php artisan migrate`, `migrate:rollback` і повторний `migrate` на БД із наявними творцями
- [x] 1.4 Оновити `CreatorFactory`: `slug`, `country` (uk/en), `career_start`, `socials`, стан `withoutAvatar()`; прибрати `games_count` із визначення; перевірити сідером `CreatorsSeeder`

## 2. Модель Creator

- [x] 2.1 У `app/Models/Creator.php`: `country` у `$translatable`, `socials` cast `array`, оновити `$fillable` (додати `slug`, `country`, `career_start`, `socials`; прибрати `games_count`), константа з ключами соцмереж; unit-тест на константу не потрібен, вона перевіряється у 5.x
- [x] 2.2 Додати генерацію `slug` у `booted()` (`creating`: транслітерація, порожній результат, унікальний суфікс `-2`, `-3`…) і feature/unit-тести: «Ivan Petrenko» → `ivan-petrenko`, дубль → `ivan-petrenko-2`, кирилиця → непорожній латинський slug, перейменування slug не змінює
- [x] 2.3 Додати accessor `avatar_url` (null → плейсхолдер, шлях зі `/`/`assets/`/`http` → як є, інакше `storage/…`) і файл `public/assets/images/creators/placeholder.svg`; unit-тести на три випадки
- [x] 2.4 Додати scope-и `search` (екранування `%`, `_`, `\`), `forCompany`, `withRole`, `sortedBy` (білий список `games|name|new`, невідоме → `new`) і accessor/метод `socialLinks()`, що повертає лише `http/https`; unit-тести: часткове співпадіння, `%` як літерал, «director» ≠ «art director», невідоме сортування, `javascript:` відкидається
- [x] 2.5 Додати коментар про перекриття `games_count` аліасом `withCount('games')` і тест: творець із збереженим `games_count = 40` та трьома іграми повертається з `withCount('games')` зі значенням 3

## 3. Публічний список `/creators`

- [x] 3.1 Додати `IndexRequest` (`q`, `company`, `role`, `sort`; відкидає некоректні значення) і переписати `Pages\CreatorController@index`: scope-и, `paginate(12)->withQueryString()`, `with('company')`, `withCount('games')`, 3 останні ігри для міні-обкладинок без N+1; feature-тест: статус 200, пошук, фільтри комбінуються, сортування, `sort=drop_table` не ламає сторінку, пагінація зберігає фільтр
- [x] 3.2 Додати блок «Зірки» (топ-3 за кількістю ігор; лише без параметрів і на першій сторінці); feature-тест на показ і на приховування під час пошуку/другої сторінки
- [x] 3.3 Оновити `layouts/main.blade.php`: `@yield('title')` із дефолтом, `@stack('head')`, `@stack('styles')`, `lang` із `app()->getLocale()`; перевірити вручну, що головна, ігри й компанії відкриваються без змін
- [x] 3.4 Переписати `resources/views/pages/creator/creators.blade.php`: форма пошуку/фільтрів/сортування (GET), компактні картки з посиланнями на `creator.show.page`, порожній стан із посиланням «скинути», `loading="lazy"`; підключити `public/assets/css/creators.css` і `public/assets/js/creators/creators.js` (авто-сабміт `select`); перевірити в браузері на `http://game4you.local` на 360px, 768px, 1280px
- [x] 3.5 Додати ключі в `lang/uk/creators.php` і `lang/en/creators.php` (пошук, фільтри, сортування, «Зірки», порожній стан, підписи профілю, «поділитися»); перевірити, що обидві мови мають однаковий набір ключів (тест порівнює `array_keys`)

## 4. Профіль `/creators/{slug}`

- [x] 4.1 Додати маршрут `creator.show.page` (`creators/{creator:slug}`) у локалізовану групу в `routes/web.php` і метод `show()` у `Pages\CreatorController`; feature-тест: 200 для наявного slug, 404 для невідомого, посилання будуються через `route()` для `uk` і `en`
- [x] 4.2 У `show()` підготувати дані: `company`, `games.category`, статистика (кількість, середній і максимальний рейтинг, розподіл у відсотках, головний жанр із tie-break за меншим `id`), співавтори (до 4, без самого творця, за кількістю ігор), попередній/наступний за `id`; feature-тест на розрахунки (рейтинги 100/300 → середній 200, максимум 300; 3 гри 2+1 → 67%/33%), на порожній стан без ігор і на межові prev/next; перевірити кількість SQL-запитів `DB::getQueryLog()` (не більше ~6)
- [x] 4.3 Створити `resources/views/pages/creator/show.blade.php`: hero (фото, ім'я, роль-бейджі, компанія, країна, роки діяльності), біо, статистика, таймлайн ігор, смужки жанрів, співавтори, prev/next, іконки соцмереж (`rel="noopener noreferrer"`, лише `http/https`), кнопка «поділитися»; пропуск порожніх полів; перевірити вручну в браузері обома мовами на 360px і 1280px
- [x] 4.4 Додати `@push('head')`: `title`, `description`, canonical, `hreflang` для кожної локалі, `og:title/description/image/url`, JSON-LD `Person` (екранування `JSON_HEX_TAG|AMP|APOS|QUOT`); feature-тест: теги присутні, а біо з `</script><script>alert(1)</script>` дає валідний JSON усередині одного тега `script`
- [x] 4.5 Створити `public/assets/css/creators.css` (картка, фільтр-бар, hero, статистика, таймлайн, смужки жанрів, адаптив) і `public/assets/js/creators/creators.js` (`navigator.share` з фолбеком на `clipboard`); перевірити, що без JS сторінка працює, окрім кнопки «поділитися»

## 5. Адмінка `/control/creator`

- [x] 5.1 Винести спільні правила в базовий клас/трейт для `StoreRequest` і `UpdateRequest`: `slug` (nullable, regex, `unique` з ігноруванням поточного), `country.uk/en`, `career_start` (1950..поточний рік), `socials.*` (`url:http,https`, max 255, лише дозволені ключі), `bio` до 5000, `avatar` (store: nullable; обидва: image, jpg/jpeg/png/webp, до 2 МБ), прибрати `games_count`; `prepareForValidation` відкидає порожні `socials.*` і порожній slug; feature-тести: майбутній рік, `javascript:` у соцмережі, зайнятий slug відхиляються
- [x] 5.2 Оновити `Dashboard\Pages\CreatorController`: `index` з пошуком `q`, `withCount('games')`, `with('company')`, `paginate(15)->withQueryString()`; `store`/`update` зберігають нові поля й переклади `bio`/`role`/`country`, порожній slug при оновленні лишає чинний, аватар опціональний, старий файл видаляється при заміні; feature-тести (з `UserFactory` verified): створення без аватара, створення з усіма полями, редагування зберігає аватар без нового файлу, заміна аватара видаляє старий файл (`Storage::fake('public')`), перейменування не змінює slug, видалення прибирає файл
- [x] 5.3 Перевірити доступ: гість на `creator.index`/`create`/`store` перенаправляється на `login`; feature-тест (перевірка підтвердження пошти поза обсягом: `User` не реалізує `MustVerifyEmail`, тож `verified` у `/control` зараз нічого не обмежує)
- [x] 5.4 Винести форму в `resources/views/dashboard/creators/_form.blade.php` і підключити в `create`/`edit`: нові поля (slug, країна uk/en, рік початку кар'єри, соцмережі, біо та роль uk/en, компанія), прибрати «Games Count», показ поточного аватара та прев'ю вибраного файлу (`FileReader`), збереження `old()` значень і помилки біля полів; перевірити вручну створення і редагування в браузері та що форма не містить `games_count` (тест `assertDontSee('name="games_count"', false)`)
- [x] 5.5 Оновити `dashboard/creators/index.blade.php`: мініатюра (`avatar_url`), slug, компанія, фактична кількість ігор, посилання на публічний профіль, пошук і навігація сторінками; перевірити вручну пошук і пагінацію

## 6. API, сіди, фінальна перевірка

- [x] 6.1 Перевести `ApiController@creators` на `Creator::withCount('games')->paginate(14)`; feature-тест: відповідь `/api/creators` містить `slug` і правильний `games_count`
- [x] 6.2 Оновити `CreatorsSeeder` під нову фабрику (`Company::factory()` / наявні компанії) і виконати `php artisan db:seed --class=CreatorsSeeder`; перевірити, що публічний список і профіль відкриваються для сід-даних, а аватари з `/assets/images/creators/…` відображаються
- [x] 6.3 Виконати `vendor/bin/pint` і `php artisan test --filter=Creator`; усі нові тести зелені, зміни Pint закомічені окремо від логічних правок
- [x] 6.4 Наскрізна ручна перевірка в браузері: створити творця в адмінці → знайти в списку → відкрити профіль uk та en → змінити фото → видалити; зафіксувати результат у описі PR
- [x] 6.5 Виконати `openspec validate improve-creators-pages` без помилок і оновити розділ «Відомі проблеми» в `CLAUDE.md` (додати: наявність `UserFactory`/`CompanyFactory`, нові тести творців)
