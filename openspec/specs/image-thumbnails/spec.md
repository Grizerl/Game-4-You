# image-thumbnails Specification

## Purpose

Зменшити вагу зображень на сторінках: картки, списки й банери показують легкі WebP-мініатюри, згенеровані Spatie Media Library, а не багатомегабайтові оригінали.

## Requirements

### Requirement: Thumbnails generated on upload
Коли адміністратор завантажує обкладинку гри чи новини, аватар творця або логотип компанії, система SHALL зберегти оригінал через Media Library і одразу створити conversions у форматі WebP: `thumb` (обкладинки — шириною до 640 px, аватари й логотипи — до 480 px) і, лише для обкладинок, `large` (до 1280 px). Conversions MUST NOT збільшувати зображення, менше за задану ширину, і MUST зберігати пропорції.

#### Scenario: Cover upload creates conversions
- **WHEN** адміністратор створює гру із завантаженою обкладинкою 2000×1000
- **THEN** у колекції `cover` є оригінал, а conversions `thumb` і `large` згенеровані як WebP шириною 640 і 1280 px

#### Scenario: Small image is not upscaled
- **WHEN** завантажено обкладинку шириною 400 px
- **THEN** її `thumb` має ширину 400 px

### Requirement: Single image per field
Кожне поле зображення SHALL мати не більше одного файлу: нове завантаження заміщує попереднє, а старі файли й conversions видаляються. Видалення запису MUST видаляти всі його файли та conversions.

#### Scenario: Replacing a cover
- **WHEN** адміністратор завантажує нову обкладинку для гри, що вже має обкладинку
- **THEN** у колекції лишається лише нове зображення, файли попереднього видалено

#### Scenario: Deleting a record
- **WHEN** адміністратор видаляє гру
- **THEN** її медіа-файли та conversions видаляються

### Requirement: Pages serve thumbnails
Публічні сторінки та адмінські списки SHALL використовувати `thumb` у картках, постерах, мініатюрах і списках та `large` у великих банерах (hero гри, спотлайт головної, обкладинка новини), а не оригінал. Оригінал MAY використовуватись лише там, де потрібен повний файл (`og:image`, структуровані дані).

#### Scenario: Catalog uses thumbnails
- **WHEN** відвідувач відкриває каталог ігор, і в ігор є conversions
- **THEN** кожен постер завантажується з WebP-`thumb`, а не з оригінального файлу

#### Scenario: Open Graph keeps the original
- **WHEN** відкрито сторінку гри
- **THEN** `og:image` вказує на оригінальну обкладинку

### Requirement: Fallback to the original
Якщо в запису немає зображення в Media Library або потрібного conversion ще не створено, система SHALL показати оригінал зі старого шляху (`cover_image`, `avatar`, `logo_path`), а за його відсутності — плейсхолдер; сторінка MUST NOT падати.

#### Scenario: Legacy image not imported yet
- **WHEN** у гри є лише старий шлях `cover_image` без запису в Media Library
- **THEN** сторінка показує зображення за старим шляхом

#### Scenario: No image at all
- **WHEN** у гри немає ні медіа, ні старого шляху
- **THEN** показується плейсхолдер обкладинки

### Requirement: Import of existing images
Система SHALL надавати команду, яка імпортує наявні зображення з колонок-шляхів у Media Library без видалення оригіналів і старих значень. Команда MUST бути ідемпотентною: записи, що вже мають медіа, пропускаються; зовнішні URL і відсутні файли пропускаються з повідомленням.

#### Scenario: Import creates media and thumbnails
- **WHEN** виконано `media:import-legacy` для гри зі старим локальним `cover_image`
- **THEN** у гри з'являється медіа в колекції `cover` з conversions, а старий файл і значення колонки лишаються

#### Scenario: Repeated import is safe
- **WHEN** команду виконано вдруге
- **THEN** нових медіа не створюється

### Requirement: Search index references thumbnails
Пошуковий індекс SHALL зберігати для кожного документа шлях до мініатюри (відносний URL), якщо вона є, і старий шлях зображення — інакше, щоб підказки пошуку не завантажували оригінали.

#### Scenario: Indexed game with media
- **WHEN** індексується гра, що має `thumb`
- **THEN** поле `image` документа вказує на файл `thumb`

### Requirement: Configurable image sizes for desktop and mobile
Адміністратор SHALL мати в адмінці сторінку «Розміри зображень», де задаються ширини в пікселях: для обкладинок (ігор і новин) — `thumb` і `large` окремо для десктопа та мобільного; для аватарів творців і логотипів компаній — одна ширина `thumb`. Кожна ширина MUST бути цілим числом від 100 до 3000, а мобільна ширина MUST NOT перевищувати десктопну. Збережені розміри SHALL діяти для нових завантажень одразу, а для наявних зображень система MUST поставити в чергу перегенерацію conversions.

#### Scenario: Saving valid sizes
- **WHEN** адміністратор зберігає для обкладинки `thumb` десктоп 800 і мобільний 400
- **THEN** розміри зберігаються, а перегенерація наявних зображень ставиться в чергу

#### Scenario: Invalid sizes are rejected
- **WHEN** адміністратор вводить мобільну ширину більшу за десктопну або значення поза діапазоном 100–3000
- **THEN** форма показує помилку, розміри не змінюються

#### Scenario: New upload uses configured sizes
- **WHEN** задано `thumb` десктоп 800 / мобільний 400, і завантажується обкладинка 2000 px
- **THEN** згенеровані `thumb` шириною 800 і `thumb_mobile` шириною 400

#### Scenario: Settings page is admin-only
- **WHEN** неавторизований користувач відкриває сторінку розмірів
- **THEN** його перенаправляє на вхід

### Requirement: Responsive image delivery
Публічні сторінки SHALL подавати мобільний conversion обкладинок (`thumb_mobile`, `large_mobile`) відвідувачам із вікном шириною до 720 px, а десктопний — іншим, через `<img srcset sizes>` (без обгортки `<picture>`, яка ламає розкладку). Якщо мобільного conversion немає, MUST показуватися лише десктопний `<img>`.

#### Scenario: Mobile source is offered
- **WHEN** у гри згенеровано `thumb_mobile`, і відкрито каталог
- **THEN** постер — `<img>` із `srcset`, де мобільний WebP має меншу ширину, і `sizes`, що в вікнах до 720 px обирає мобільний файл, а в ширших — десктопний

#### Scenario: No mobile conversion
- **WHEN** мобільного conversion ще немає
- **THEN** постер — звичайний `<img>` на десктопний `thumb`
