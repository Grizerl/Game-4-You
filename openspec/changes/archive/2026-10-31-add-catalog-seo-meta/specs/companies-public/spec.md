## ADDED Requirements

### Requirement: Catalog SEO metadata
Каталог студій SHALL містити `<title>` з ключа `companies.meta_title`, опис `companies.meta_description_company`, canonical, hreflang (uk/en) та Open Graph; `og:title` MUST збігатися з `<title>`.

#### Scenario: Catalog metadata
- **WHEN** відвідувач відкриває `/company`
- **THEN** HTML містить непорожній `<title>`, `meta description`, canonical на цю сторінку, `hreflang` для `uk` та `en` і `og:type`, `og:title`, `og:description`, `og:url`

#### Scenario: English interface
- **WHEN** інтерфейс англійською
- **THEN** `<title>`, опис та `og:*` англійською
