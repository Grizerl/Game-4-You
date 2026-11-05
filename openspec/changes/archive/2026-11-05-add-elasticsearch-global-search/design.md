## Context

- Публічний контент: `Game`, `Category`, `Creator`, `Company`, `Article` (+ `Tag`). Переклади живуть у JSON-колонках (`spatie/laravel-translatable`), мови `uk`/`en`. Креатор має `first_name`/`last_name` (не перекладні) і перекладні `bio`, `role`, `country`.
- Зараз пошук — `scopeSearch` на моделях (LIKE по `JSON_EXTRACT`), лише за назвою, всередині кожного розділу.
- Черги й кеш — БД (`QUEUE_CONNECTION=database`); у Laradock є контейнер `php-worker`. Redis-розширення в PHP 8.4 немає.
- У Laradock `elasticsearch-8` збирається з `ELK_VERSION=7.9.1`; його Dockerfile (`laradock/elasticsearch/Dockerfile`) уже ставить `analysis-ukrainian`. Спільний `docker-compose.yml` Laradock не чіпаємо — розширюємо `docker-compose.game4you.yml`.
- Мотивація — див. proposal.md.

## Goals / Non-Goals

**Goals:**
- Elasticsearch 9.x, що стартує однією командою поруч з наявним стеком, і детермінований індекс, який можна перебудувати з нуля з БД.
- Один запит — один рейтинг по всіх типах сутностей; пошук не залежить від мови інтерфейсу.
- Збій ES ніколи не ламає сайт і адмінку.

**Non-Goals:**
- Заміна наявних `?q=` фільтрів у каталогах на ES (вони комбінуються з іншими фільтрами, сортуванням і пагінацією; окремий change).
- Пошук по коментарях, адмінці та користувачах; фасети, збережені запити, аналітика пошуку.
- Кластер, безпека ES (TLS/ролі) у локальному середовищі — лише змінні для прод-автентифікації.
- Laravel Scout: драйвери для ES 9 непідтримувані/застарілі, а потрібна нам логіка (мульти-модельний індекс, alias-перебудова) у Scout відсутня.

## Decisions

**1. Окремий сервіс `elasticsearch-9` в override-файлі Laradock.**
Образ `elasticsearch:${ELK_VERSION}` із `ELK_VERSION=9.x` (точну патч-версію зафіксувати під час apply, не `latest`) збираємо з наявного `laradock/elasticsearch/Dockerfile` (плагіни `analysis-ukrainian`, версія плагіна = версії ES). Single-node (`discovery.type=single-node`), `xpack.security.enabled=false` лише локально, `ES_JAVA_OPTS=-Xms512m -Xmx512m`, окремий том, мережа `backend` (де `php-fpm-84` і `workspace-84`), хост-порт 9200 (змінна, якщо зайнятий). `docker-compose.game4you.yml` змінюємо, `docker-compose.yml` Laradock — ні.
*Альтернатива:* виправити `elasticsearch-8` у спільному файлі — зачепить інші проєкти й назва вводить в оману.

**2. Офіційний клієнт `elasticsearch/elasticsearch` ^9.0 без Scout.**
Тонка обгортка `App\Services\Search\SearchClient` (будує клієнт із `config/search.php`, `isEnabled()`, перехоплює транспортні помилки). Клієнт реєструється singleton у `AppServiceProvider`/окремому провайдері, у тестах підміняється.
*Альтернативи:* `babenkoivan/elastic-scout-driver` (залежність від Scout і відставання від ES 9), «голий» HTTP через `Http::` (дублювання серіалізації й помилок).

**3. Єдиний індекс `games4you_content_vN` + alias `games4you_content`.**
Документ: `type` (`game|category|creator|company|news`), `model_id`, `slug`, `title.{uk,en}`, `body.{uk,en}` (опис/анонс/біо/початок тексту новини без Markdown/HTML), `extra.{uk,en}` (жанр, студія, роль, країна, теги), `image` (відносний шлях), `rating`/`published_at` для сортування й `boost`. Ідентифікатор документа: `{type}-{model_id}`. Тексти — `text` із підполями: `title.uk` аналізатор `ukrainian`, `title.en` — `english`, плюс підполе `.ngram` (edge-ngram аналізатор) для підказок. Мапінг `dynamic: strict`.
*Чому єдиний індекс:* один запит, один рейтинг, групування через `terms` агрегацію/`collapse` за `type`. *Альтернатива:* індекс на тип + multi-index search — складніше для рейтингу й alias-перебудови.

**4. Пошуковий запит.**
`bool.must`: `multi_match` (`best_fields`, `fuzziness: AUTO`, `operator: and` для довших запитів) по `title.uk^4`, `title.en^4`, `extra.*^2`, `body.*`, `title.*.ngram^1` лише для підказок; `bool.filter` по `type`. Для сторінки: агрегація `terms` за `type` для лічильників груп + окремий запит на групу з пагінацією (`size`/`from`), для підказок — один запит `size: 8` по ngram-підполях. Підсвічування — `highlight` з тегами `<mark>`; перед виводом текст екранується, а `<mark>` відновлюється (див. Ризики). Перебудова результатів у моделі не потрібна: картка рендериться із `_source` на поточній мові (`title.{locale}` із фолбеком на іншу мову); URL будується через `route()` зі slug і типом.

**5. Синхронізація: observers → черга.**
Observer `SearchIndexObserver` на п'яти моделях ставить у чергу `IndexModelJob` (`saved`) / `DeleteFromIndexJob` (`deleted`), `afterCommit`, `tries=5`, експоненційний `backoff`. Джоб сам вирішує індексувати чи видалити (новина не опублікована → видалити). Побічні залежності: зміна `Category`/`Company`/`Creator` додатково ставить у чергу переіндексацію їхніх ігор (чанками); зміна тегів новини — через `saved` новини (в адмінці теги синхронізуються після збереження — перевірити й за потреби викликати `searchable`-перерахунок явно у контролері).
Заплановані новини: команда `search:sync-scheduled` у `routes/console.php` щохвилини індексує новини, у яких `published_at` настав, але документа ще немає (потрібен запущений `schedule:run`/`schedule:work`).
*Альтернатива:* синхронна індексація в `saved` — ризик 500 і гальмування адмінки при збої ES.

**6. Перебудова: `search:reindex`.**
Створює `games4you_content_v{timestamp}` з мапінгом, bulk-наповнює чанками (по 200) з БД, `refresh`, атомарно перемикає alias (`updateAliases` remove+add в одній дії), видаляє старі версії (залишає попередню — для ручного відкату з `--keep`). При винятку нового індексу видаляє його, alias не чіпає. Перше розгортання: якщо alias відсутній — створюється. Команда виводить кількість за типами.

**7. Відмовостійкість.**
`SearchClient` кидає власний `SearchUnavailableException` для транспортних помилок/вимкненого пошуку; контролер ловить і рендерить сторінку зі станом «недоступно» (HTTP 200), JSON-ендпоінт повертає `[]`. Таймаути клієнта короткі (connect 1 с, request 3 с) для запитів користувача, довші для reindex. Помилки індексації логуються (`Log::warning`) і повторюються чергою.

**8. Маршрути й UI.**
`GET /search` (`search.page`) у локалізованій групі `routes/web.php` — `SearchController@index` із `SearchRequest` (по аналогії з `NewsIndexRequest`: `q` ≤ 100 символів, некоректне тихо відкидається). Підказки: `GET /search/suggest` (локалізований маршрут `search.suggest`, `throttle:30,1`), JSON. Резервне слово `search` у slug-ах не конфліктує (жодних `/{slug}` на корені). Поле в `partials/header.blade.php` (десктоп + бургер) з невеликим Alpine-компонентом (debounce 250 мс, клавіатурна навігація). Сторінка — Blade `pages/search/index.blade.php`, стилі у наявній системі (Bootstrap/Tailwind-класи проєкту, мінімум нового CSS), переклади `lang/{uk,en}/search.php`, `routes.php` не потрібен.

**9. Конфігурація.**
`config/search.php`: `enabled` (`SEARCH_ENABLED`), `hosts` (`ELASTICSEARCH_HOST`, дефолт `http://elasticsearch-9:9200`), `username`/`password`/`api_key` (необов'язкові), `index` (`SEARCH_INDEX`), таймаути. Значення додаємо в `.env.example` без секретів; `phpunit.xml` встановлює `SEARCH_ENABLED=false` за замовчуванням.

**10. Тести.**
Юніт/feature-тести з підміненим клієнтом (`SearchClient` fake) для контролера, observer-ів, джобів і мапера документів; невелика група інтеграційних тестів проти реального ES з окремим тестовим індексом, що `markTestSkipped`, якщо ES недоступний. Нові тести — проти реальних маршрутів (`tests/Feature/Search/`), `#[Test]`-атрибути.

## Risks / Trade-offs

- [Плагін `analysis-ukrainian` має збігатися з версією ES; образ ламається при апгрейді] → `ELK_VERSION` пінимо в одному місці й використовуємо його як `build arg`; у документації — перебудова образу при зміні версії.
- [ES 9 потребує пам'яті; Docker Desktop на Windows може впасти] → heap 512 МБ, `bootstrap.memory_lock` не вмикаємо; у `CLAUDE.md` — вимога ≥ 2 ГБ для Docker та `vm.max_map_count` для WSL2.
- [Підсвічування й XSS] → `highlight` повертає HTML зі вмісту; у Blade виводимо `e()` від фрагмента, а `<mark>`/`</mark>` повертаємо точковою заміною, не `{!! !!}` на сирому тексті.
- [Індекс розходиться з БД (пропущена подія, збій черги)] → команда `search:reindex` як джерело істини, `search:sync-scheduled` для новин; зміни через `DB::table`/seed-и обходять observer-и — після сідерів запускати `search:reindex` (додати в `CLAUDE.md`).
- [Прод без ES] → `SEARCH_ENABLED=false` лишає сайт працездатним; шапка тоді ховає поле пошуку.
- [Двомовна релевантність: `uk` аналізатор погано стемить англійські слова й навпаки] → окремі поля й пошук по обох, `title.*` з вищим бустом для поточної мови (`locale` додаємо в запит як множник).
- [Ключ `slug` кількох типів може збігатися] → ідентифікатор документа містить тип; посилання будуються за типом.

## Migration Plan

1. Підняти ES 9 локально, переконатися у версії та плагіні.
2. Задеплоїти код із `SEARCH_ENABLED=false`, виставити `ELASTICSEARCH_*` на проді.
3. Запустити `php artisan search:reindex`, увімкнути `SEARCH_ENABLED=true`, перевірити пошук.
4. Переконатися, що працюють queue worker і `schedule:run` (cron).
Відкат: `SEARCH_ENABLED=false` (пошук зникає, решта сайту без змін); індекс можна видалити без наслідків для БД.

## Open Questions

- Точна патч-версія Elasticsearch 9.x і наявність відповідного релізу `analysis-ukrainian` — зафіксувати під час apply (перший крок у tasks).
- Чи є на проді вже ES 9 або його потрібно розгортати окремо — не впливає на код, лише на деплой.
