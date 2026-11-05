<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function dashboard_is_english_and_shows_counters_and_user(): void
    {
        $user = User::factory()->create(['name' => 'Jane', 'email' => 'jane@example.com']);
        User::factory()->count(2)->create();

        $response = $this->actingAs($user)->get('/control/dashboard');

        $response->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('Welcome to your control center')
            ->assertSee('jane@example.com')
            ->assertSee('Users')
            ->assertSee('Logout');

        $this->assertDoesNotMatchRegularExpression('/\p{Cyrillic}/u', strip_tags($response->getContent()));
    }

    #[Test]
    public function navigation_marks_only_the_current_section_active(): void
    {
        $html = $this->actingAs(User::factory()->create())->get('/control/users')->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'nav-item active'));
        $this->assertMatchesRegularExpression('/nav-item active"[^>]*>\s*<i[^>]*><\/i>\s*<span>Users/', $html);
    }

    #[Test]
    public function image_settings_page_is_english(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/control/settings/images')->assertOk();

        $response->assertSee('Game and news covers');
        $this->assertDoesNotMatchRegularExpression('/\p{Cyrillic}/u', strip_tags($response->getContent()));
    }
}
