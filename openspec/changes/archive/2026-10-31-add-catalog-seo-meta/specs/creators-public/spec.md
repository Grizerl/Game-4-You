## ADDED Requirements

### Requirement: Catalog SEO metadata
Каталог творців SHALL містити `<title>` з ключа `creators.meta_title`, опис `creators.meta_description_creators`, canonical, hreflang (uk/en) та Open Graph; `og:title` MUST збігатися з `<title>`.

#### Scenario: Catalog metadata
- **WHEN** відвідувач відкриває `/creators`
- **THEN** HTML містить непорожній `<title>`, `meta description`, canonical на цю сторінку, `hreflang` для `uk` та `en` і `og:type`, `og:title`, `og:description`, `og:url`

#### Scenario: English interface
- **WHEN** інтерфейс англійською
- **THEN** `<title>`, опис та `og:*` англійською
