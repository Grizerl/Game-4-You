## Why

Каталоги `/games`, `/creators`, `/company` не мали SEO-метаданих: лише `<title>` зі зліпленого з перекладів рядка, без опису, canonical, hreflang та Open Graph. Сторінка новин уже їх мала. Також на списку новин було видно посилання «RSS-стрічка», хоча стрічка — технічний ендпоінт і не має бути частиною інтерфейсу.

## What Changes

- **SEO каталогів** (`/games`, `/creators`, `/company`): `<title>` береться з окремого ключа `meta_title`, додаються `meta description`, canonical, hreflang (uk/en) та Open Graph (`og:type`, `og:title`, `og:description`, `og:url`) — за зразком сторінки новин. Тексти uk/en в `lang/*/{game,creators,companies}.php`.
- **RSS**: з вʼю списку новин прибрано видиме посилання «RSS-стрічка» і `<link rel="alternate" type="application/rss+xml">`; ендпоінт `/news/feed` лишається. Видалено невикористані ключі `news.rss` і стилі `.nw-rss`.
- Дрібне: підписи фільтра «Всі» та заголовок «Наші» (uk) з великої літери.

Не входить: JSON-LD для каталогів, `og:image`, зміни самих сторінок деталей.

## Capabilities

### Modified Capabilities
- `games-public`, `creators-public`, `companies-public`: SEO-метадані сторінок-каталогів.
- `news-public`: стрічка більше не рекламується у списку.

## Impact

- **Вʼюхи**: `pages/game/games`, `pages/creator/creators`, `pages/store/stores`, `pages/news/index`.
- **Переклади**: `lang/{uk,en}/{game,creators,companies,news,games}.php`.
- **Стилі**: `public/assets/css/news.css`.
- **Тести**: `NewsListingTest` (замість «рекламує RSS» — «не показує RSS»); додати перевірки SEO каталогів.
