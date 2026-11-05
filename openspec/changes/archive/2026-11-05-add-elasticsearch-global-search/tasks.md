## 1. Elasticsearch 9 у Laradock

- [x] 1.1 Визначити актуальну патч-версію ES 9.x і наявність `analysis-ukrainian` для неї; зафіксувати у змінній `ELK_VERSION` (перевірка: `docker run --rm elasticsearch:<версія> bin/elasticsearch-plugin --help` або збірка образу без помилок)
- [x] 1.2 Додати сервіс `elasticsearch-9` у `C:\projects\laradock\docker-compose.game4you.yml` (build з `./elasticsearch`, single-node, security off, heap 512m, окремий том, мережа `backend`, порт 9200) і необхідні змінні в `laradock/.env`; перевірка: `docker compose -f docker-compose.yml -f docker-compose.game4you.yml up -d elasticsearch-9` піднімається, `curl localhost:9200` повертає версію 9.x
- [x] 1.3 Перевірити плагін і доступність із `workspace-84`: `curl http://elasticsearch-9:9200/_cat/plugins` містить український аналізатор
- [x] 1.4 Оновити `CLAUDE.md` (команда запуску з `elasticsearch-9`, вимоги до пам'яті Docker, `reindex` після сідерів) і додати `ELASTICSEARCH_*`/`SEARCH_*` у `.env.example` та локальний `.env`; перевірка: інструкція відтворюється з нуля

## 2. Підключення в застосунку

- [x] 2.1 `composer require elasticsearch/elasticsearch:^9.0` у `workspace-84`; перевірка: пакет у `composer.json`/`composer.lock`, `php artisan about` без помилок
- [x] 2.2 Створити `config/search.php` (enabled, hosts, auth, index, таймаути) і `SearchUnavailableException`; перевірка: `php artisan tinker` читає `config('search.index')`
- [x] 2.3 Реалізувати `App\Services\Search\SearchClient` (singleton, `isEnabled()`, обгортка помилок транспорту) і зареєструвати в провайдері; перевірка: юніт-тест — вимкнений пошук не робить запитів, транспортна помилка перетворюється на `SearchUnavailableException`
- [x] 2.4 Додати `SEARCH_ENABLED=false` у `phpunit.xml`; перевірка: `php artisan test` не звертається до ES

## 3. Індекс і маппінги

- [x] 3.1 Описати мапінг/налаштування індексу (аналізатори `ukrainian`, `english`, edge-ngram, `dynamic: strict`) в `App\Services\Search\IndexDefinition`; перевірка: тест порівнює структуру з очікуваною
- [x] 3.2 Реалізувати мапер документів (`DocumentMapper`) для `Game`, `Category`, `Creator`, `Company`, `Article` (поля `title/body/extra` для uk/en, очищення Markdown/HTML, `{type}-{id}`, відсутні переклади → порожнє поле); перевірка: юніт-тести на кожен тип, включно з сутністю без англійського перекладу
- [x] 3.3 Правила видимості: новина індексується лише коли `isPublished()`; перевірка: тест — чернетка й запланована новина дають «не індексувати»

## 4. Індексація й синхронізація

- [x] 4.1 Artisan-команда `search:reindex` (новий версійований індекс → bulk чанками → refresh → атомарний swap alias → видалення старого; при помилці alias не чіпається; вивід кількостей за типами); перевірка: feature-тест із fake-клієнтом + ручний запуск у `workspace-84`, документи за типами збігаються з БД
- [x] 4.2 Джоби `IndexModelJob` і `DeleteFromIndexJob` (afterCommit, tries/backoff, логування збоїв) та `SearchIndexObserver` для п'яти моделей; перевірка: тести з `Queue::fake()` — create/update/delete ставлять правильні джоби, неопублікована новина видаляється з індексу
- [x] 4.3 Каскад залежних даних: зміна `Category`/`Company`/`Creator` переіндексує їхні ігри (чанками), збереження тегів новини в адмінці переіндексує новину; перевірка: тести каскаду
- [x] 4.4 Команда `search:sync-scheduled` + розклад щохвилини в `routes/console.php` для новин, чия дата публікації настала; перевірка: тест — запланована новина після настання дати індексується
- [x] 4.5 Відмовостійкість запису: збереження моделі в адмінці успішне при недоступному ES; перевірка: тест із fake-клієнтом, що кидає виняток, — запис у БД є, помилка залогована, джоб повертається в чергу

## 5. Пошуковий запит

- [x] 5.1 `SearchService::suggest(q, locale)` (multi_match з fuzziness і бустами назв + edge-ngram для початку слова, до 8 результатів єдиним рейтингом); перевірка: інтеграційні тести проти реального ES — релевантність назви над описом, словоформа, одна помилка, крос-мовний пошук, чернетка не знаходиться
- [x] 5.2 `SearchResult` (тип, назва поточною мовою з фолбеком, позначка, URL через `route()`); перевірка: юніт-тести URL для всіх типів

## 6. Шапка, випадаючий список і валідація

- [x] 6.1 `SearchRequest` (обовʼязковий `q`, ≥ 2 символи, нормалізація, обрізання до 100, відповідь 422 JSON) і `SearchController@suggest` (200 / 422 / 503, `throttle:30,1`); окремої сторінки `/search` немає; перевірка: feature-тести на формат, 422 для порожнього/короткого, 503, 429, 404 для `/search`
- [x] 6.2 Шапка: логотип + поле пошуку на всю ширину + бургер зі шторкою для решти меню; на мобільному поле ховається за іконкою пошуку, яка при відкритті стає хрестиком (адаптивно); перевірка: ручна в браузері (десктоп, 390px, 320px)
- [x] 6.3 JS випадаючого списку: від 2 символів, debounce, «Нічого не знайдено», підказка для порожнього/короткого значення, клавіатура, безпечний вивід через textContent; перевірка: ручна в браузері
- [x] 6.4 Переклади `lang/{uk,en}/search.php`, стилі в палітрі сайту; перевірка: тексти коректні в обох мовах

## 7. Завершення

- [x] 7.1 Індексація локальних даних: `search:reindex` у `workspace-84`, перевірка пошуку на `game4you.local` (гра, творець, компанія, новина, категорія, словоформа, помилка)
- [x] 7.2 `php artisan test` — нові тести зелені (відомі старі червоні тести не рахуються), `vendor/bin/pint` без зауважень, `chmod -R a+rwX storage/framework` після тестів
- [x] 7.3 Створити специфікації `openspec/specs/` через `/opsx:sync` і оновити `README.md`/`CLAUDE.md` (запуск ES, `search:reindex`, змінні `.env`, вимога queue worker і `schedule:run` на проді)
