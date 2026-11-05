## 1. База даних і підтримка

- [x] 1.1 Міграція `games`: `slug` (backfill із JSON-назви → unique), `released_at` (backfill із `created_at`), `trailer_url`, `screenshots`; перевірити migrate → rollback → migrate на `game_test` із дублями
- [x] 1.2 `App\Support\YouTube` (розбір посилань і безпечна валідація) + unit-тести
- [x] 1.3 `Game`: slug-хук, `getRouteKeyName`/`resolveRouteBinding` (slug або id), cast-и, accessor-и (`screenshot_urls`, `platform_list`), scope-и `search`/`inCategory`/`onPlatform`/`sortedBy`, `platformOptions()`; `GameFactory` з новими полями; плейсхолдер обкладинки; тести моделі

## 2. Публічні сторінки

- [x] 2.1 `GamesIndexRequest` і `GamesController@index` (пошук, жанр, платформа, сортування, чіпи з лічильниками, пагінація); feature-тести
- [x] 2.2 `GamesController@show` (slug, 301 з id, 404, зв'язані ігри, трейлер, галерея, SEO-дані); feature-тести (редірект, XSS в описі, YouTube, порожні блоки, запити)
- [x] 2.3 Коментарі: `CommentController` (validated, honeypot, редірект на `#comments`, flash), throttle на маршруті; тести (успіх, помилки зі збереженням, honeypot, 429, екранування)
- [x] 2.4 Вʼюхи й стилі: каталог (`pages/game/games`), сторінка гри (`pages/details/detail`), partials, `games.css`, `games.js`, переклади uk/en (паритет ключів); оновити всі посилання на гру (`home`, `games-list`, `creator/show`, `store/show`) і тести на slug

## 3. Адмінка

- [x] 3.1 `GameRequest` + Store/Update; `Dashboard\Pages\GameController` (payload, slug, обкладинка, скріншоти, видалення файлів і коментарів, Telegram після save з try/catch); тести з `Http::fake()` (створення, валідація, slug, обкладинка/скріншоти, видалення, збій Telegram, доступ)
- [x] 3.2 Вʼюхи адмінки: `_form` (прев'ю обкладинки, управління скріншотами), `create`/`edit`, список із пошуком і пагінацією

## 4. Завершення

- [x] 4.1 `vendor/bin/pint --dirty`; тести ігор, творців і студій зелені
- [x] 4.2 Міграція на dev і перевірка живого сайту (curl): каталог, гра uk/en, редірект з id, 404
- [x] 4.3 Адаптив: відсутність горизонтального переповнення на 320–1440 px (6 сторінок) і скріншоти 390/768/1280
- [x] 4.4 `openspec validate improve-game-pages`, оновити `CLAUDE.md`

## 5. Доопрацювання за відгуком

- [x] 5.1 Пагінація коментарів по 4 (`comments_page`, фрагмент `#comments`, редірект за межі діапазону), власний вигляд пагінатора; загальна кількість через `total()`; тести
- [x] 5.2 Ряд жанрів: приховані скролбари, затемнення країв, кнопки та перетягування, прокрутка активного чіпа; переклади; перевірка в браузері

