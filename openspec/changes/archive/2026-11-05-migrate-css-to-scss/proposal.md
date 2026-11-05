## Why

Стилі проєкту розкидані: вісім ручних CSS-файлів у `public/assets/css` (~106 КБ, без змінних, міксинів і партіалів), `resources/css/app.css` з Tailwind і 12 дублюваних `<style>`-блоків у Blade-шаблонах адмінки (однакові `.btn`, `.table`, `.pager`, форми копіюються сторінка в сторінку). Це ускладнює підтримку й повторне використання. Потрібна єдина SCSS-кодова база, яка збирається Vite, а зовнішній вигляд сайту й адмінки лишається пікселя в піксель таким самим.

## What Changes

- Підключити Sass до Vite (`sass` як devDependency), перенести всі стилі в `resources/scss/` (партіали, `@use`, змінні, міксини, вкладеність).
- **Публічний сайт**: `public/assets/css/{index,details,search,games,creators,companies,home,news}.css` → однойменні SCSS-входи; Blade підключає їх через `@vite(...)` замість `<link href="/assets/css/...">`. Порядок підключення на кожній сторінці зберігається.
- **Tailwind/Breeze**: `resources/css/app.css` → `resources/scss/app.scss` (директиви `@tailwind` лишаються, PostCSS-конвеєр без змін).
- **Адмінка `/control`**: inline `<style>` у `layouts/admin` і 11 шаблонах → SCSS (`admin.scss` для каркаса + спільні партіали таблиць/форм/пагінації + невеликі сторінкові входи); шаблони підключають їх через `@push('styles')`/`@vite`.
- Статичні inline-атрибути `style="..."` (наприклад, `display:inline` у формах видалення, відступ футера) замінюються класами в SCSS; динамічні значення (`--i`, `--d`, `--hue`, `width: N%`) лишаються inline, бо залежать від даних.
- Старі `.css` файли й `resources/css/app.css` видаляються після підтвердження еквівалентності.
- Додати перевірку паритету: скомпільований CSS порівнюється зі знімком оригіналу (нормалізована послідовність правил), тож дизайн не змінюється.
- Оновити `CLAUDE.md` (стек, команди, структура стилів) і `tests/TestCase` (заглушка Vite, щоб feature-тести не залежали від зібраного `public/build`).
- **BREAKING (деплой)**: стилі сайту тепер лежать у `public/build` (у `.gitignore`), тому на проді перед релізом обовʼязковий `npm ci && npm run build`.

## Capabilities

### New Capabilities
- `scss-styling`: єдина SCSS-система стилів, зібрана Vite, для публічного сайту й адмінки; візуальна еквівалентність попереднім CSS; відсутність ручних CSS-файлів і статичних inline-стилів.

### Modified Capabilities
<!-- Поведінка наявних capabilities не змінюється: UI, розмітка й тексти лишаються такими самими. -->

## Impact

- **Frontend**: `package.json` (+`sass`), `vite.config.js` (нові входи), `resources/scss/**` (нове), `resources/css/` і `public/assets/css/` (видаляються).
- **Blade**: `layouts/{main,app,guest,admin}`, `pages/*/partials/assets`, `dashboard/**`, `partials/footer` — заміна `<link>`/`<style>` на `@vite`/`@push('styles')`.
- **Тести**: `tests/TestCase.php` (заглушка Vite) і тести, що перевіряли `assets/css/*.css`.
- **Деплой**: обовʼязковий `npm run build` на проді; Node 22 уже є в проєкті.
- **Не змінюється**: JS у `public/assets/js`, розмітка, класи, маршрути, переклади, зображення й відео в `public/assets`.
