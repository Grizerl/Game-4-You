<?php

namespace Tests\Feature\Home;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LanguageSwitcherTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function switcher_is_rendered_in_footer_and_burger_drawer(): void
    {
        $html = $this->get(route('home.page'))->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'lang-switcher--footer'));
        $this->assertSame(1, substr_count($html, 'lang-switcher--drawer'));
        // по два посилання (uk, en) у кожному з двох перемикачів
        foreach (['uk', 'en'] as $code) {
            $this->assertSame(2, preg_match_all('/<a class="lang-link[^"]*"[^>]*hreflang="'.$code.'"/s', $html), $code);
        }
    }

    #[Test]
    public function current_locale_is_highlighted_with_code_and_native_name(): void
    {
        $locale = app()->getLocale();
        $html = $this->get(route('home.page'))->assertOk()->getContent();

        $this->assertSame(2, preg_match_all('/class="lang-link\s+is-active\s*"[^>]*aria-current="true"/s', $html));
        $this->assertSame(2, preg_match_all('/<b class="lang-link__code">'.($locale === 'uk' ? 'UA' : strtoupper($locale)).'<\/b>/', $html));
        $this->assertStringContainsString('lang-link__name', $html);
    }
}
