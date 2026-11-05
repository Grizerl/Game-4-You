## ADDED Requirements

### Requirement: Admin interface is English only
Усі сторінки `/control` SHALL відображати інтерфейс англійською: заголовки, підписи, плейсхолдери, кнопки, flash-повідомлення, повідомлення та назви полів валідації. Для запитів до `/control` локаль застосунку MUST бути `en` незалежно від `APP_LOCALE`. Дані (переклади `uk`/`en` ігор, категорій тощо) та підписи полів мов (UA/EN) лишаються без змін.

#### Scenario: Dashboard text
- **WHEN** авторизований користувач відкриває `/control/dashboard`
- **THEN** сторінка не містить кириличного тексту інтерфейсу, `<html lang="en">`

#### Scenario: Validation messages
- **WHEN** адмін надсилає форму з помилкою валідації
- **THEN** повідомлення англійською

### Requirement: Navigation with correct active state
Сайдбар SHALL містити пункти Dashboard, Games, Categories, Creators, Companies, News, Users, Image sizes, згруповані за секціями, та посилання на публічний сайт. Пункт, що відповідає поточному розділу, MUST мати клас `active`.

#### Scenario: Active item
- **WHEN** відкрито `/control/users`
- **THEN** активний лише пункт Users

### Requirement: Header shows the current user
Шапка SHALL показувати назву сторінки, ім'я та email поточного користувача й кнопку виходу.

#### Scenario: Header
- **WHEN** користувач `Jane` відкриває будь-яку сторінку адмінки
- **THEN** шапка містить `Jane`, її email і кнопку Logout

### Requirement: Dashboard with statistics
Дашборд SHALL показувати лічильники: Games, Categories, Creators, Companies, News, Users, а також блок швидких дій (додати гру, новину, творця, користувача).

#### Scenario: Counters
- **WHEN** у БД 2 гри і 3 користувачі
- **THEN** картки показують 2 та 3

### Requirement: Consistent list and form styling
Списки SHALL мати стилізовану таблицю, порожній стан, пагінацію, кнопки дій у єдиному стилі; flash-повідомлення `status` MUST відображатися на всіх сторінках. Форми — єдині стилі полів, помилок і кнопок.

#### Scenario: Empty list
- **WHEN** у списку немає записів
- **THEN** показано повідомлення про порожній список
