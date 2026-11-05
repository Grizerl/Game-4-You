# language-switcher Specification

## Purpose
TBD - created by archiving change fix-language-switcher. Update Purpose after archive.

## Requirements

### Requirement: Language switcher in footer and burger menu
Публічні сторінки SHALL містити перемикач мов і у футері, і у шторці шапки (бургер-меню). Кожна підтримувана локаль MUST бути посиланням з `hreflang`, що веде на поточну сторінку в цій мові; поточна локаль MUST бути позначена класом `is-active` та `aria-current="true"`.

#### Scenario: Both places on a page
- **WHEN** відкрито будь-яку публічну сторінку
- **THEN** розмітка містить перемикач у футері та у шторці з посиланнями на `uk` і `en`

#### Scenario: Current locale highlighted
- **WHEN** сторінка відкрита українською
- **THEN** посилання `uk` має `is-active` і `aria-current="true"`, посилання `en` — ні

### Requirement: Polished switcher appearance
У шторці перемикач SHALL виглядати як єдиний сегментований контрол: капсула з іконкою глобуса та кнопками, кожна з кодом мови й рідною назвою; активна мова виділена акцентним градієнтом. У футері перемикач SHALL бути простішим: лише окремі таблетки зі скороченням мови `UA` / `EN` (без капсули, глобуса й повної назви), активна — суцільна акцентна заливка. Усі стани MUST мати hover і `:focus-visible`; анімації MUST вимикатися за `prefers-reduced-motion`.

#### Scenario: Markup structure
- **WHEN** відкрито публічну сторінку
- **THEN** кожне посилання перемикача містить скорочення (`UA` для української, `EN`) і рідну назву (атрибути `title`/`aria-label`), а футерний варіант стилями ховає глобус і повну назву

### Requirement: Switcher layout on mobile
На екранах шириною до 550px перемикач у футері SHALL бути відцентрований і не виходити за межі екрана; у шторці він розташований окремим блоком над соцмережами.

#### Scenario: Mobile footer
- **WHEN** ширина вікна ≤ 550px
- **THEN** контейнер перемикача у футері центрований (`justify-content: center`)

### Requirement: Sticky site header
Шапка публічного сайту SHALL бути «липкою»: під час скролу вона лишається вгорі вікна (`position: sticky; top: 0`), нижче за шторку й оверлей. Інші липкі елементи сторінок (вкладки, форма) MUST зміщуватися на висоту шапки, щоб не ховатися під нею.

#### Scenario: Scrolling
- **WHEN** користувач гортає сторінку
- **THEN** шапка лишається видимою вгорі, а відкрита шторка перекриває її
