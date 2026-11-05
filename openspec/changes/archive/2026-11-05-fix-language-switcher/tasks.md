## 1. Implementation
- [x] 1.1 Partial `partials/lang-switcher` (глобус, код + назва, active/aria-current)
- [x] 1.2 Підключити у футері замість старого списку
- [x] 1.3 Підключити у шторці шапки + ключ `header.language` (uk/en)
- [x] 1.4 Стилі: капсула, active-градієнт, hover/focus, reduced-motion, мобільний ≤550px (`index.scss`), шторка (`search.scss`)

## 2. Verification
- [x] 2.1 Тест: перемикач у футері та шторці, active-локаль
- [x] 2.2 `npm run build`, `pint`, прогін тестів

## 3. Sticky header
- [x] 3.1 `.sc-fdhCDF` → `position: sticky; top: 0; z-index: 1500`; зсув липких `.gm-tabs` і `.gm-form` під шапку

## 4. Search validation
- [x] 4.1 Порожній submit: червоний контур без тексту підказки (`search.js`, `.hs-search.is-invalid`)
