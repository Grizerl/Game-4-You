## 1. База даних і підтримка

- [x] 1.1 Міграція `companies`: `slug` (nullable → backfill із JSON-назви → unique), `founded_year`, `socials`; перевірити migrate → rollback → migrate на `game_test` із рядками-дублями
- [x] 1.2 `App\Support\SocialLinks` і `GameStatistics`; `Creator` та `CreatorController` переведені на них; усі тести творців лишаються зеленими
- [x] 1.3 `PublicImage`: шляхи `uploads/` через `asset()`; плейсхолдер логотипа; unit-тест
- [x] 1.4 `Company`: slug-хук, `games()`, `creators()`, `logo_url`, `socialLinks()`, scope-и `search`/`inCountry`/`sortedBy`, `countryOptions()`; `CompanyFactory` з новими полями та `withoutLogo()`; модельні тести

## 2. Публічні сторінки

- [x] 2.1 `CompanyIndexRequest` і `Pages\CompanyController@index` (фільтри, пагінація, «Топ-студії»); feature-тести
- [x] 2.2 Маршрут `company.show.page`, `show()` зі статистикою, жанрами, іграми, командою, prev/next, JSON-LD; feature-тести (розрахунки, 404, порожній стан, XSS у описі, SEO)
- [x] 2.3 Вʼюхи: список, профіль, partials, `companies.css`, JS; переклади uk/en (паритет ключів); тест на шрифти й локалізацію

## 3. Адмінка

- [x] 3.1 `CompanyRequest` + Store/Update; контролер (`payload`, пагінація, пошук, логотип, slug); тести (створення, валідація, slug, заміна/видалення логотипа, доступ)
- [x] 3.2 Вʼюхи адмінки: `_form` з прев'ю логотипа, `create`/`edit`, список з пошуком і пагінацією

## 4. Завершення

- [x] 4.1 `vendor/bin/pint --dirty` і повний набір тестів творців та компаній зелені
- [x] 4.2 Перевірка живого сайту (curl; сід на dev не виконано: заблоковано, див. CompaniesSeeder) для `/company`, `/en/company`, профілю, 404
- [x] 4.3 Перевірка адаптиву: відсутність горизонтального переповнення на 320–1440 px (6 сторінок) і скріншоти 390/768/1024
- [x] 4.4 `openspec validate improve-company-pages`, оновити `CLAUDE.md`, архівація
