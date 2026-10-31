## Why

Сторінка компаній — найпримітивніша на сайті: `Company::all()` у сітці карток без пагінації, пошуку й фільтрів, картка нікуди не веде, окремої сторінки студії немає, логотип без запасного варіанта ламає картку. Після зміни `improve-creators-pages` є готовий візуальний і технічний зразок (профіль, статистика, SEO, адмін-форма), який можна повторити для студій.

## What Changes

- **Список `/company`**: нова картка (логотип або плейсхолдер, назва, країна, рік заснування, кількість ігор і творців, до 3 обкладинок ігор), уся картка — посилання на профіль; пошук за назвою, фільтр за країною, сортування (кількість ігор, алфавіт, новизна), стан в URL, пагінація; блок «Топ-студії» без фільтрів на першій сторінці.
- **Профіль `/company/{slug}`** (`company.show.page`): hero (логотип, назва, країна, рік заснування й кількість років, соцмережі, «поділитися»), повний опис, статистика з реальних даних (ігри, творці, середній і найвищий рейтинг, головний жанр), розподіл жанрів, ігри студії, команда (творці), навігація попередня/наступна, SEO (`og:*`, canonical, hreflang, JSON-LD `Organization`).
- **БД**: у `companies` додаються `slug` (unique, backfill), `founded_year`, `socials` (JSON); логотип стає необов'язковим на сайті (плейсхолдер).
- **Адмінка `/control/companies`**: спільна форма create/edit з новими полями (slug, рік заснування, соцмережі), прев'ю логотипа, пошук і пагінація списку, FormRequest зі спільними правилами.
- **Рефакторинг для повторного використання**: статистика ігор і соцпосилання виносяться зі `CreatorController`/`Creator` у `App\Support` (поведінка сторінок творців не змінюється); `PublicImage` розпізнає логотипи з `uploads/`.
- Переклади uk/en, адаптивна верстка, PHPUnit-тести.

Не входить: сторінка ігор, Elasticsearch, перенесення логотипів у `storage`, редіректи зі старих адрес.

## Capabilities

### New Capabilities
- `companies-public`: публічний каталог студій і профіль студії.
- `companies-admin`: керування студіями в адмінці.

### Modified Capabilities
<!-- Вимоги creators-* не змінюються: рефакторинг лише внутрішній. -->

## Impact

- **Код**: `app/Models/Company.php`, `Pages\CompanyController`, `Dashboard\Pages\CompanyController`, `Requests/Admin/Company/*`, новий `Requests/Pages/CompanyIndexRequest`, `app/Support/{GameStatistics,SocialLinks,PublicImage}.php`, `Pages\CreatorController` та `Creator` (рефакторинг), `routes/web.php`.
- **Вʼюхи/стилі**: `resources/views/pages/store/*` (список, `show`, partials), `resources/views/dashboard/company/*`, `public/assets/css/companies.css` (спільне береться з `creators.css`).
- **БД**: одна міграція; `CompanyFactory` розширюється.
- **Ризики**: логотипи лежать у `public/uploads/company` (інша схема шляху, ніж у творців), це враховано в `PublicImage`; `Game.company_id` (видавець гри) і `Creator.company_id` (команда) — різні зв'язки, статистика рахується окремо.
