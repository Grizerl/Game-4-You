## 1. Tooling

- [x] 1.1 Додати `sass` у devDependencies (`npm install -D sass`; Node/npm запускаються локально на Windows, бо в `workspace-84` Node 16, а Vite 6 вимагає ≥ 18) і перевірити, що `npm ls sass` показує встановлену версію
- [x] 1.2 Зняти знімок оригінальних стилів (8 CSS + `resources/css/app.css` + усі inline-блоки адмінки) у каталог перевірки поза `resources/`/`public/` і перевірити, що файли на місці
- [x] 1.3 Написати одноразовий скрипт паритету (Sass-вихід ↔ знімок, нормалізований плоский список правил) і перевірити, що на прикладі «оригінальний CSS ↔ він же як .scss» він видає 0 розбіжностей, а на навмисно зміненій декларації — розбіжність

## 2. Публічні стилі → SCSS

- [x] 2.1 Створити `resources/scss/abstracts/{_variables,_mixins}.scss` (брейкпоїнти, `respond-max`, `reduced-motion`) і перевірити, що вони компілюються
- [x] 2.2 Сконвертувати `index.css`, `details.css`, `search.css` у `resources/scss/public/*.scss` (вкладеність сусідніх правил, міксини для media, `@import` шрифтів першим) і перевірити паритет скриптом
- [x] 2.3 Сконвертувати `games.css`, `creators.css`, `companies.css` (абсолютні `url(/assets/images/...)` замість `../images`) і перевірити паритет скриптом
- [x] 2.4 Сконвертувати `home.css`, `news.css` і перевірити паритет скриптом
- [x] 2.5 Оновити `vite.config.js` (усі входи), `layouts/main.blade.php` і `pages/*/partials/assets.blade.php` на `@vite` у тому самому порядку й перевірити `npm run build` та порядок `<link>` у HTML головної
- [x] 2.6 Видалити `public/assets/css/*.css` і перевірити, що `grep -r "assets/css" resources routes public --include=*.php --include=*.js` порожній

## 3. Tailwind app.css → SCSS

- [x] 3.1 Перенести `resources/css/app.css` в `resources/scss/app.scss`, оновити `@vite` у `layouts/app` і `layouts/guest`, видалити старий файл і перевірити, що сторінка логіну збирається з Tailwind-утилітами в CSS

## 4. Адмінка → SCSS

- [x] 4.1 Винести каркас `layouts/admin` у `resources/scss/admin/admin.scss`, додати `@vite` + `@stack('styles')` у layout і перевірити паритет із inline-блоком layout
- [x] 4.2 Виділити спільні партіали (`_list` — toolbar/search/btn/table/edit/delete/thumb, `_pager`, `_form`, `_status`) і сторінкові входи (list-сторінки, форми, категорії, новини) і перевірити паритет для кожної з 11 сторінок (layout + сторінка ↔ оригінальні inline-блоки)
- [x] 4.3 Замінити `<style>` у 11 шаблонах на `@push('styles')`/`@vite` (для `_form` — у create/edit через спільний партіал) і перевірити `grep -rn "<style" resources/views` порожній

## 5. Inline-атрибути, тести, документація

- [x] 5.1 Замінити статичні `style="..."` (форми видалення, роздільник `/` у категоріях, відступ футера) класами і перевірити, що лишилися тільки динамічні (`--i`, `--d`, `--hue`, `width`, Alpine `display`)
- [x] 5.2 Підмінити Vite заглушкою в `tests/TestCase.php` (виводить теги з іменами входів `resources/scss/...`), оновити тести, що перевіряли `assets/css/*.css`, і перевірити `php artisan test` без `public/build` (зелені тести лишаються зеленими, відомі червоні не множаться)
- [x] 5.3 Оновити `CLAUDE.md` (стек, структура стилів, команди збірки, крок деплою `npm ci && npm run build`)

## 6. Підтвердження

- [x] 6.1 `npm run build` без помилок; прогнати скрипт паритету по всіх вхідних файлах — 0 розбіжностей
- [x] 6.2 Відкрити в браузері головну, ігри, гру, творців, студію, новини, логін і сторінки `/control` та порівняти зі станом до змін (у контейнері `chmod -R a+rwX storage/framework` після тестів)

## Результат перевірки

- Паритет скомпільованого SCSS і оригіналів: 8/8 публічних файлів і 12/12 адмін-блоків — 0 розбіжностей (єдині відхилення — еквівалентні форми запису: `rgba(...,1)`→`rgb(...)`, `#rrggbbaa`→`rgba()`, лапки в `[attr="x"]`, `.10em`→`.1em`).
- Візуальна перевірка (Edge headless, до/після, 1440/768/390px, 10 публічних сторінок + 12 сторінок адмінки): піксельно ідентично, окремі пікселі на краях гліфів — антиаліасинг шрифтів.
- `php artisan test`: 309 пройшло, 24 падіння — усі вже були червоними до змін (`PageControllerTest`, `Auth/*`, `NewsListingTest::listing_advertises_the_rss_feed...`, `CreatorProfileTest::only_configured_safe_social_links...` — у шапці є посилання Twitch).
