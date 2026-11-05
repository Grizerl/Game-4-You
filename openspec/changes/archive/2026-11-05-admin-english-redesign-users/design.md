## Context

Адмінка — Blade + SCSS (`resources/scss/admin/*`), без SPA; кожна сторінка підключає власний вхід через `@push('styles')`. Шаблони вже здебільшого англійською, лишаються українські місця: дашборд, `settings/images`, flash-тексти й повідомлення `ImageSizesRequest`, кириличні літери «с» у кнопках категорій, плейсхолдери з `$locale === 'uk'`.

## Decisions

- **Мова**: middleware `SetAdminLocale` (`app()->setLocale('en')`) на групі `/control`; виправлення текстів прямо в Blade/контролерах. Дані перекладів не чіпаємо.
- **Стилі**: оновлюємо наявні партіали (`admin.scss`, `_table`, `_toolbar`, `_pager`, `_status`, `_form`) — усі сторінки отримують новий вигляд без правок кожного входу; додаємо токени в `abstracts/_variables` і нові партіали `_flash`, `_empty`. Вхід `list-users.scss` для списку, `form-user.scss` для форм користувачів.
- **Навігація**: сайдбар групується (Overview / Catalog / Content / System); active-стан через `request()->routeIs(...)`.
- **Users**: ресурсний `UserController` (без `show`), `UserRequest` (правила залежать від методу), маршрут `users` у групі `control`. Видалення себе забороняється. Ролей немає — будь-який авторизований користувач і так має доступ до адмінки (див. CLAUDE.md), тому роль не вводимо.

## Risks / Trade-offs

- Локаль `en` у `/control` впливає на сортування/пошук за `JSON_EXTRACT(... app()->getLocale())` у списках — тепер за англійськими назвами, що відповідає мові UI.
- Видалення користувача не чіпає коментарі (немає FK на users).
