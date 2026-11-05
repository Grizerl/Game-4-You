## 1. Прибрати самописну генерацію

- [x] 1.1 Видалити `ImageVariants`, `PublicImage::variant`, команду `images:optimize`, тест `ImageVariantsTest`, запис `/public/assets/_v` у `.gitignore` та згадки в `CLAUDE.md`, і перевірити `grep -rn "ImageVariants\|images:optimize\|_v/" app tests .gitignore` порожній

## 2. Spatie Media Library

- [x] 2.1 Встановити `spatie/laravel-medialibrary` ^11 у `workspace-84`, опублікувати міграцію й конфіг, `queue_conversions_by_default=false`, і перевірити `composer show spatie/laravel-medialibrary`
- [x] 2.2 Міграція `media` + міграція `games.cover_image` → nullable, і перевірити `php artisan migrate` проходить на `game` і `game_test`

## 3. Моделі

- [x] 3.1 Трейт `HasImageMedia` (колекція, колонка-шлях, плейсхолдер, `imageUrl`, `hasImage`, `imageSearchPath`) і перевірити юніт-тестами запасний варіант (медіа → старий шлях → плейсхолдер)
- [x] 3.2 `Game`, `Article` (`cover`: thumb 640/large 1280), `Creator` (`avatar`: thumb 480), `Company` (`logo`: thumb 480): `HasMedia`, `singleFile`, conversions у WebP без збільшення, `$with = ['media']`, акцесори `*_url`/`*_thumb_url`/`*_large_url`, і перевірити тестом: завантаження 2000×1000 дає thumb 640 і large 1280, 400 px не збільшується

## 4. Адмінка і Blade

- [x] 4.1 Контролери `Game`, `Article`, `Creator`, `Company`: завантаження через `addMediaFromRequest`, обнулення старої колонки й видалення старого файлу, заміна/видалення — і перевірити feature-тестом (створення, заміна, видалення запису лишає 0 файлів)
- [x] 4.2 Blade: форми прев'ю (`hasImage()` + thumb), три місця з `$company->logo_path` (`creator/partials/card`, `creator/show`, `home/index`) і `Pages\CompanyController` — на `hasImage()`/`logo_thumb_url`, і перевірити `grep -rn "logo_path\|->cover_image\|->avatar\b" resources/views` без прямих звернень до сирих шляхів
- [x] 4.3 `DocumentMapper`: поле `image` з `imageSearchPath()`, і перевірити тестом мапера

## 5. Імпорт існуючих зображень

- [x] 5.1 Команда `media:import-legacy` (ідемпотентна, пропускає зовнішні URL/відсутні файли, не зупиняється на помилці файлу), і перевірити тестом: імпорт створює медіа з conversions, повторний запуск нічого не додає
- [x] 5.2 Виконати імпорт на локальній БД і `search:reindex`, і перевірити, що в HTML каталогу/головної/творців/новин `<img>` вказують на `/storage/.../conversions/*-thumb.webp`, а вага зображень сторінок упала

## 6. Підтвердження

- [x] 6.1 `php artisan test` без нових падінь (24 відомі червоні лишаються), `vendor/bin/pint` лише по змінених файлах
- [x] 6.2 Оновити `CLAUDE.md` (стек, команда імпорту, деплой) і перевірити сторінки в браузері

## 7. Розміри для десктопа й мобілки

- [x] 7.1 Таблиця `settings`, модель `Setting`, `ImageSizes` (дефолти, читання, збереження, валідація меж), і перевірити юніт-тестом дефолти й перезапис
- [x] 7.2 Conversions `thumb`/`thumb_mobile`/`large`/`large_mobile` для обкладинок і `thumb` для аватарів/логотипів із розмірами з `ImageSizes`, і перевірити тестом: при 800/400 завантаження 2000 px дає ширини 800 і 400
- [x] 7.3 Адмінка: сторінка «Розміри зображень» (форма, валідація, посилання в сайдбарі, SCSS-вхід), job перегенерації в черзі, і перевірити feature-тестами (доступ лише авторизованим, збереження, помилки валідації, job поставлено в чергу)
- [x] 7.4 Компонент `<x-cover>` (`<img srcset sizes>`: мобільний файл до 720 px, інакше десктопний; без мобільного conversion — звичайний `<img>`) у постері, hero гри, спотлайті, новинах, і перевірити тестом розмітки та переглядом у браузері на 390 px і 1440 px
