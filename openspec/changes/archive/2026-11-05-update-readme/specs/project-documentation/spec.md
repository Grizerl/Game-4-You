## ADDED Requirements

### Requirement: README reflects the current project state
`README.md` SHALL відповідати реальному стану проєкту: перелік функцій (каталог, творці, студії, новини з RSS, глобальний пошук, коментарі, двомовність, англомовна адмінка з керуванням користувачами й розмірами зображень, публічне JSON API, Telegram-сповіщення), актуальний стек (Sass/SCSS, Vite, Elasticsearch 9, Spatie Media Library), кроки встановлення й запуску (зокрема `storage:link`, змінні пошуку й соцмереж, `media:import-legacy`, `search:reindex`), структуру проєкту, інструкції з тестування та git flow (feature, release, hotfix).

#### Scenario: No stale claims
- **WHEN** читається README
- **THEN** у ньому немає планів «міграції CSS → SCSS», посилань на неіснуючі OpenSpec-зміни та тверджень, що поточні тести загалом застарілі

### Requirement: README roadmap and releases
README SHALL містити лише актуальний роадмап (невиконані пункти) та короткий перелік випущених версій з головними змінами.

#### Scenario: Releases list
- **WHEN** читається розділ релізів
- **THEN** кожна версія з git-тегів (`1.0.0` … поточна) має рядок з описом
