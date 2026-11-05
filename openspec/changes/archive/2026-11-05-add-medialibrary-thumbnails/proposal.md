## Why

Обкладинки ігор і новин, аватари творців і логотипи компаній зберігаються як оригінали по 1–15 МБ (усього ~120 МБ у `public/assets/images`) і віддаються у картках як мініатюри 300×450. Сторінки каталогу важать 3–14 МБ, і сайт відчутно гальмує. Попередня самописна генерація WebP-варіантів (`ImageVariants` + `images:optimize`, файли в `.gitignore`) не прижилась: на проді варіантів немає, тож віддається оригінал, а підтримувати власний код обробки зображень не потрібно — для цього є стандартне рішення `spatie/laravel-medialibrary` з conversions.

## What Changes

- Підключити `spatie/laravel-medialibrary` (^11): міграція таблиці `media`, конфіг, синхронна генерація conversions.
- Моделі `Game`, `Article` (колекція `cover`), `Creator` (`avatar`), `Company` (`logo`) стають `HasMedia`; одне зображення на колекцію (нове замінює старе); conversions у WebP без збільшення: `thumb` (картки, 640 px; для аватарів і логотипів 480 px) і `large` (1280 px, лише для обкладинок).
- Публічні сторінки й адмінські списки показують `thumb`/`large`, а не оригінал; `cover_url`/`avatar_url`/`logo_url` лишаються оригіналом (для `og:image` і JSON-LD).
- Адмінка завантажує зображення через Media Library; заміна й видалення запису прибирають файли та conversions.
- Наявні зображення (сід-дані та старі завантаження, що зберігаються рядком-шляхом у `cover_image`/`avatar`/`logo_path`) імпортуються командою `media:import-legacy`; доки запис не імпортовано, працює запасний варіант — оригінал за старим шляхом (стара колонка не видаляється, `games.cover_image` стає nullable).
- Адмінка: сторінка «Розміри зображень» (глобальні налаштування) — ширини `thumb`/`large` для десктопа й мобільного (обкладинки), `thumb` для аватарів і логотипів; нові завантаження беруть їх одразу, наявні перегенеровуються в черзі. Публічні сторінки віддають мобільний WebP до 720 px через `srcset`/`sizes`.
- Пошуковий індекс отримує шлях до thumb замість оригіналу.
- Прибрати самописне: `App\Support\ImageVariants`, `PublicImage::variant`, команду `images:optimize`, відповідні тести та запис у `.gitignore`.
- Eager loading `media` на моделях, щоб картки не робили N+1 запитів.

## Capabilities

### New Capabilities
- `image-thumbnails`: легкі WebP-мініатюри зображень контенту (ігри, новини, творці, компанії) через Spatie Media Library: генерація при завантаженні, імпорт наявних зображень, запасний варіант і прибирання файлів.

### Modified Capabilities
<!-- Зовнішня поведінка наявних capabilities (розмітка, тексти, маршрути) не змінюється: змінюються лише адреси файлів зображень. -->

## Impact

- **Залежності**: `composer.json` (+`spatie/laravel-medialibrary`), `config/media-library.php`, міграція `media` і міграція `games.cover_image` → nullable.
- **Код**: моделі `Game`, `Article`, `Creator`, `Company` (+ спільний трейт), контролери адмінки (4), `App\Services\Search\DocumentMapper`, `App\Support\PublicImage`, нова команда `media:import-legacy`, Blade (форми прев'ю й 3 місця з `$company->logo_path`).
- **Прод**: `composer install`, `php artisan migrate`, `php artisan storage:link` (якщо немає), `php artisan media:import-legacy`, `php artisan search:reindex`. Диск `public` (`storage/app/public`) має віддаватися веб-сервером.
- **Тести**: нові тести conversions/імпорту/запасного варіанта; наявні лишаються сумісними (фабрики й сідери й далі пишуть шляхи в колонки).
- **Не змінюється**: JS, маршрути, переклади, скриншоти ігор (`screenshots` лишаються шляхами), URL оригіналів.
