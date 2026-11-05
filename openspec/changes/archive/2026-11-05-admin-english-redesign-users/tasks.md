## 1. Specification
- [x] 1.1 proposal, specs (`admin-panel`, `users-admin`), design

## 2. English-only interface
- [x] 2.1 Middleware `SetAdminLocale` на групі `/control`, `<html lang="en">`
- [x] 2.2 Переписати українські тексти: dashboard, settings/images, `ImageSettingsController`, `ImageSizesRequest`, плейсхолдери форм, кириличні літери в кнопках категорій

## 3. Visual refresh
- [x] 3.1 Нові токени та оновлений каркас `admin.scss` (сайдбар, шапка, картки, швидкі дії)
- [x] 3.2 Оновлені `_table`, `_toolbar`, `_pager`, `_status`, `_form`, нові `_flash`, `_empty`
- [x] 3.3 Layout: групована навігація, active-стани, користувач у шапці, flash `status`
- [x] 3.4 Дашборд зі статистикою та швидкими діями

## 4. Users section
- [x] 4.1 `UserController`, `UserRequest`, маршрути
- [x] 4.2 Views: index, create, edit, `_form`; SCSS входи; пункт у меню
- [x] 4.3 Лічильники користувачів і новин на дашборді

## 5. Verification
- [x] 5.1 Тести `tests/Feature/Admin/` (users CRUD, доступ, self-delete, мова)
- [x] 5.2 `npm run build`, `vendor/bin/pint`, прогін тестів
