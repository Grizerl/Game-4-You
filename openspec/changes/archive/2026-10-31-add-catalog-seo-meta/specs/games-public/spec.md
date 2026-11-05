## ADDED Requirements

### Requirement: Catalog SEO metadata
Каталог ігор SHALL містити `<title>` з ключа `game.meta_title`, опис `game.meta_description_games`, canonical, hreflang (uk/en) та Open Graph; `og:title` MUST збігатися з `<title>`.

#### Scenario: Catalog metadata
- **WHEN** відвідувач відкриває `/games`
- **THEN** HTML містить непорожній `<title>`, `meta description`, canonical на цю сторінку, `hreflang` для `uk` та `en` і `og:type`, `og:title`, `og:description`, `og:url`

#### Scenario: English interface
- **WHEN** інтерфейс англійською
- **THEN** `<title>`, опис та `og:*` англійською
