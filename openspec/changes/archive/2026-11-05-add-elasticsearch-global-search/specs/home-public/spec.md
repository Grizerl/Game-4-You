## MODIFIED Requirements

### Requirement: Video respects user preferences
Відео SHALL не завантажуватися й не відтворюватися, якщо користувач обрав зменшений рух (`prefers-reduced-motion`) або економію трафіку (`Save-Data`); у цих випадках показується лише постер. Hero MUST NOT містити кнопок керування відео (пауза, звук): відео — беззвучний декоративний луп.

#### Scenario: Reduced motion
- **WHEN** користувач увімкнув зменшений рух
- **THEN** відео не відтворюється, лишається постер

#### Scenario: No video controls
- **WHEN** відвідувач відкриває головну
- **THEN** у hero немає кнопок паузи й вимкнення/увімкнення звуку

## REMOVED Requirements

### Requirement: Hero quick search
**Reason**: пошук тепер єдиний — глобальне поле в шапці з випадаючим списком результатів (capability `global-search-public`); окреме поле в hero дублювало його.
**Migration**: відвідувач шукає через поле пошуку в шапці; каталог ігор `/games?q=` і дія пошуку в JSON-LD `WebSite` лишаються без змін.
