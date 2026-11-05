## Decisions

- Один Blade-partial `partials.lang-switcher` з параметром `$variant` (`footer` | `drawer`) → модифікатор класу `lang-switcher--footer|drawer`. Розмітка: `<nav class="lang-switcher"><span class="lang-switcher__icon">(SVG глобус)</span><ul>…<li><a class="lang-link is-active"><b>UK</b><span>Українська</span></a></li>…</ul></nav>`.
- Футерний варіант (`--footer`) навмисно простий — таблетки зі скороченням UA / EN без капсули й глобуса; шторка (`--drawer`) — повний вигляд. Базові стилі `.lang-switcher` / `.lang-link` — в `index.scss` (він підключений в `layouts/main`, тож доступний і шапці); колір активного — `$pink-light` → фіолетовий градієнт, у тон футера. У шторці — перекриття через змінні `--sh-*` у `search.scss`.
- Активна локаль: `app()->getLocale() === $localeCode`.
- Хотфікс 1.1.2: новий ключ лише `header.language`.
