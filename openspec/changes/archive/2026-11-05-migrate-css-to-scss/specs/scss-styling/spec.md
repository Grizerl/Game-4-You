## Purpose

Єдина SCSS-система стилів для публічного сайту й адмінки `/control`, яку збирає Vite і яка візуально ідентична попереднім CSS-стилям.

## ADDED Requirements

### Requirement: Styles authored in SCSS
Усі стилі застосунку (публічні сторінки, адмінка, сторінки автентифікації на Tailwind) SHALL бути написані в SCSS у каталозі `resources/scss` і збиратися Vite. Проєкт MUST NOT містити ручних `.css`-файлів зі стилями сторінок і `<style>`-блоків у Blade-шаблонах.

#### Scenario: No hand-written CSS remains
- **WHEN** переглянути `public/assets/css`, `resources/css` і Blade-шаблони
- **THEN** там немає `.css`-файлів стилів сторінок і немає елементів `<style>`

#### Scenario: Build succeeds
- **WHEN** виконано `npm run build`
- **THEN** збірка завершується без помилок, а `public/build/manifest.json` містить усі SCSS-входи

### Requirement: Visual parity with previous CSS
Скомпільований SCSS SHALL відтворювати попередні стилі без зміни вигляду: для кожного вихідного CSS-файлу (і для кожного адмін-блоку) нормалізована послідовність правил — селектори, декларації, значення, порядок і `@media`/`@keyframes` — MUST збігатися зі знімком оригіналу. Кольори, відступи, шрифти, анімації й адаптивні брейкпоїнти MUST NOT змінитися.

#### Scenario: Public stylesheet parity
- **WHEN** скомпільовано `index`, `details`, `search`, `games`, `creators`, `companies`, `home`, `news` і порівняно з оригінальними CSS після нормалізації
- **THEN** розбіжностей немає

#### Scenario: Admin page parity
- **WHEN** для адмін-сторінки зібрано стилі каркаса й сторінки та порівняно з об'єднанням inline-блоків layout і шаблону до міграції
- **THEN** розбіжностей немає

### Requirement: Same cascade on every page
Кожна сторінка SHALL підключати ті самі набори стилів у тому самому порядку, що й до міграції (спільні `index`, `details`, `search`; далі сторінкові, наприклад `games` → `news` → `home` на головній).

#### Scenario: Home page stylesheet order
- **WHEN** відкрито головну
- **THEN** у `<head>` стилі йдуть у порядку index, details, search, games, news, home

#### Scenario: Admin page order
- **WHEN** відкрито сторінку адмінки
- **THEN** стилі каркаса адмінки підключені раніше за стилі сторінки

### Requirement: Shared styles are defined once
Повторювані блоки стилів (кнопки, таблиці, пагінація, форми, тулбар адмінки) SHALL жити в одному партіалі й підключатися через `@use`, а не копіюватися між сторінками. Повторювані значення (палітра, радіуси, брейкпоїнти) SHALL задаватися SCSS-змінними або міксинами, що компілюються в ті самі значення.

#### Scenario: Admin list pages share one table definition
- **WHEN** переглянути вихідні SCSS сторінок списків ігор, творців і компаній
- **THEN** стилі таблиці, пагінації й кнопок підключені зі спільного партіала, а не дубльовані

### Requirement: Static inline styles replaced by classes
Статичні атрибути `style="..."` у Blade SHALL бути замінені CSS-класами; динамічні значення, що залежать від даних (`--i`, `--d`, `--hue`, ширина смуги в %, стан `display` модальних вікон/дропдаунів, кероване Alpine), MAY лишатися inline.

#### Scenario: Delete form is inline via class
- **WHEN** відкрито список ігор в адмінці
- **THEN** форма видалення відображається в рядку з кнопкою «Edit» так само, як раніше, без атрибута `style`

### Requirement: Assets resolve after build
Посилання `url(...)` у стилях на зображення з `public/assets` SHALL працювати після збірки (абсолютні шляхи `/assets/...`). Шрифти Google MUST підключатися тегами `<link>` у layout (з `preconnect`), а не `@import` у CSS, щоб вантажитися паралельно зі стилями.

#### Scenario: Background images load
- **WHEN** відкрито сторінку з фоновим зображенням (hero, банер студії)
- **THEN** зображення завантажується без 404

### Requirement: Feature tests independent of built assets
Feature-тести SHALL проходити без попередньої збірки Vite (`public/build` відсутній).

#### Scenario: Tests without build
- **WHEN** `public/build` видалено й виконано `php artisan test --filter=Creators`
- **THEN** тести не падають через відсутній Vite manifest
