{{-- Перемикач мов. $variant: 'footer' | 'drawer'. Посилання ведуть на поточну сторінку в обраній мові. --}}
@php($variant = $variant ?? 'footer')
<nav class="lang-switcher lang-switcher--{{ $variant }}" aria-label="{{ __('header.language') }}">
    <span class="lang-switcher__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.6 2.7 3.9 5.7 3.9 9s-1.3 6.3-3.9 9c-2.6-2.7-3.9-5.7-3.9-9S9.4 5.7 12 3z"/></svg>
    </span>
    <ul class="lang-switcher__list">
        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php($active = app()->getLocale() === $localeCode)
            @php($short = $localeCode === 'uk' ? 'UA' : strtoupper($localeCode))
            <li>
                <a class="lang-link @if ($active) is-active @endif"
                   rel="alternate"
                   hreflang="{{ $localeCode }}"
                   title="{{ $properties['native'] }}"
                   aria-label="{{ $properties['native'] }}"
                   lang="{{ $localeCode }}"
                   @if ($active) aria-current="true" @endif
                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <b class="lang-link__code">{{ $short }}</b>
                    <span class="lang-link__name">{{ $properties['native'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
