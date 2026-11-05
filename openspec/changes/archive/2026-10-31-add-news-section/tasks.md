## 1. Дані та моделі

- [x] 1.1 Міграція `tags`, `articles`, `article_tag`, `article_game`, `article_company`; `ArticleFactory`, `TagFactory`; перевірка migrate → rollback → migrate на `game_test`
- [x] 1.2 Моделі `Article` (slug-хук, зарезервований `feed`, scope-и, статус, `cover_url`, `bodyHtml()` з безпечним Markdown, час читання, звʼязки) і `Tag`; тести моделі (slug, Markdown XSS, статуси, пошук)

## 2. Публічна частина

- [x] 2.1 `NewsIndexRequest`, `NewsController@index` (топ-картка, сітка, пошук, теги-чіпи, пагінація); тести
- [x] 2.2 `NewsController@show` (slug, 404/адмін-перегляд, пов'язані ігри й студії, «Читайте також», SEO-дані) і `@feed` (RSS); маршрути; тести (XSS, JSON-LD, RSS-XML, запити)
- [x] 2.3 Вʼюхи й ресурси: список, стаття, partials, `news.css`, `news.js`, плейсхолдер обкладинки, переклади uk/en; пункт «Новини» в шапці; блок «Останні новини» на головній + тести

## 3. Адмінка

- [x] 3.1 `ArticleRequest` (+ Store/Update), `Dashboard\Pages\ArticleController` (теги `Назва|Name`, slug, обкладинка, планування, звʼязки, видалення), маршрут-ресурс; тести з `Storage::fake`
- [x] 3.2 Вʼюхи адмінки: `_form` (прев'ю обкладинки, теги, вибір ігор і студій, дата публікації), `create`/`edit`, список зі статусами, пошуком і пагінацією

## 4. Завершення

- [x] 4.1 `vendor/bin/pint --dirty`; тести новин, головної, ігор, творців і студій зелені
- [x] 4.2 Міграція на dev і перевірка живого сайту (curl): `/news`, `/en/news`, стаття, RSS, 404 чернетки
- [x] 4.3 Адаптив: відсутність горизонтального переповнення на 320–1440 px і скріншоти 390/768/1280
- [x] 4.4 `openspec validate add-news-section`, оновити `CLAUDE.md`
