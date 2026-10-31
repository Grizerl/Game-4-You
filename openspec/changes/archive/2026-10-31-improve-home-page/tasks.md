## 1. Підготовка

- [x] 1.1 Відео-ресурси `public/assets/video/hero.{mp4,webm}` + `hero-poster.jpg` (згенеровано) і конфіг `services.social.*` з `.env.example`; тест на наявність файлів і конфіг
- [x] 1.2 Переклади `lang/{uk,en}/home.php` (нові ключі, паритет)

## 2. Бекенд

- [x] 2.1 `HomeController`: редірект `category_id`, статистика, нові/топ, spotlight, жанри, студії, творці, коментарі; тести логіки (порядок, пріоритет spotlight, лише жанри з іграми, порожній сайт, запити)

## 3. Вʼюхи та ресурси

- [x] 3.1 `pages/home/index.blade.php` і partials (hero, trending, spotlight, жанри, студії/творці, відгуки, спільнота), SEO-блок, `home.css`, `home.js` (відео-контроль, reduced-motion/Save-Data, вкладки, лічильники, reveal, marquee)
- [x] 3.2 Прибирання: видалити `main.blade.php`, `partials/games-list.blade.php`, Swiper (скрипт і підключення в layout); тести hero/SEO/XSS/локалізації

## 4. Завершення

- [x] 4.1 `vendor/bin/pint --dirty`; тести головної, ігор, творців і студій зелені
- [x] 4.2 Перевірка живого сайту (curl): `/`, `/en`, редірект `?category_id=`, інші сторінки без Swiper
- [x] 4.3 Адаптив: відсутність горизонтального переповнення на 320–1440 px і скріншоти 390/768/1280
- [x] 4.4 `openspec validate improve-home-page`, оновити `CLAUDE.md`
