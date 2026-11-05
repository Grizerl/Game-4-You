# users-admin Specification

## Purpose
TBD - created by archiving change admin-english-redesign-users. Update Purpose after archive.

## Requirements

### Requirement: Access restricted to authenticated users
Усі сторінки й дії керування користувачами SHALL бути доступні лише авторизованим користувачам; гість MUST бути перенаправлений на вхід. Публічних сторінок користувачів немає.

#### Scenario: Guest opens the list
- **WHEN** неавторизований відвідувач відкриває `/control/users`
- **THEN** його перенаправлено на сторінку входу

### Requirement: Users list with search and pagination
Список SHALL бути посторінковим (20 на сторінку, найновіші першими), підтримувати пошук за іменем або email (параметр `q` зберігається в пагінації) і показувати: id, ім'я, email, статус підтвердження email (Verified / Unverified), дату реєстрації. Поточний користувач MUST бути позначений міткою «You».

#### Scenario: Search
- **WHEN** адмін шукає `jane`
- **THEN** у списку лише користувачі, чиє ім'я або email містить `jane`

### Requirement: Create a user
Форма SHALL приймати name (обов'язково, ≤255), email (обов'язково, валідний, унікальний), password (обов'язково, мінімум 8 символів) із підтвердженням. Пароль зберігається хешованим; новий акаунт вважається підтвердженим (`email_verified_at` = зараз).

#### Scenario: Successful creation
- **WHEN** адмін заповнює коректні дані
- **THEN** користувача створено з хешованим паролем, адміна повернуто до списку зі статусом успіху

#### Scenario: Duplicate email
- **WHEN** email уже існує
- **THEN** користувача не створено, помилка біля поля email

### Requirement: Edit a user
Редагування SHALL змінювати name та email (унікальність ігнорує сам запис). Поле password необов'язкове: порожнє — пароль не змінюється; заповнене — оновлюється (мін. 8 символів, з підтвердженням).

#### Scenario: Keep password
- **WHEN** адмін змінює ім'я й залишає пароль порожнім
- **THEN** ім'я оновлено, пароль той самий

### Requirement: Delete a user
Адмін SHALL мати змогу видалити користувача, окрім себе: спроба видалити власний акаунт MUST бути відхилена без видалення, з повідомленням про помилку.

#### Scenario: Delete another user
- **WHEN** адмін видаляє іншого користувача
- **THEN** запис видалено, показано статус успіху

#### Scenario: Delete self
- **WHEN** адмін намагається видалити себе
- **THEN** запис лишається, показано помилку
