<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): static
    {
        return $this->actingAs(User::factory()->create(['name' => 'Root Admin']));
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret-pass-1',
            'password_confirmation' => 'secret-pass-1',
        ], $overrides);
    }

    #[Test]
    public function guest_is_redirected_to_login(): void
    {
        $this->get('/control/users')->assertRedirect(route('login'));
        $this->post('/control/users', $this->payload())->assertRedirect(route('login'));
    }

    #[Test]
    public function list_shows_users_search_and_marks_current_user(): void
    {
        User::factory()->create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);
        User::factory()->create(['name' => 'Bob', 'email' => 'bob@example.com']);

        $this->admin()->get('/control/users')
            ->assertOk()
            ->assertSee('Jane Doe')
            ->assertSee('Bob')
            ->assertSee('You');

        $this->admin()->get('/control/users?q=jane')
            ->assertOk()
            ->assertSee('jane@example.com')
            ->assertDontSee('bob@example.com');
    }

    #[Test]
    public function admin_can_create_user_with_hashed_password(): void
    {
        $this->admin()->post('/control/users', $this->payload())
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status');

        $user = User::where('email', 'jane@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('secret-pass-1', $user->password));
        $this->assertNotNull($user->email_verified_at);
    }

    #[Test]
    public function creation_validates_input(): void
    {
        User::factory()->create(['email' => 'jane@example.com']);

        $this->admin()->post('/control/users', $this->payload(['password_confirmation' => 'nope']))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 2);
    }

    #[Test]
    public function validation_messages_are_english(): void
    {
        $response = $this->admin()->from('/control/users/create')->post('/control/users', []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertSame('The name field is required.', session('errors')->first('name'));
    }

    #[Test]
    public function password_is_optional_on_update_and_kept_when_empty(): void
    {
        $user = User::factory()->create(['password' => 'old-password-1']);

        $this->admin()->put(route('users.update', $user), [
            'name' => 'New Name',
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
        ])->assertRedirect(route('users.index'));

        $user->refresh();
        $this->assertSame('New Name', $user->name);
        $this->assertTrue(Hash::check('old-password-1', $user->password));
    }

    #[Test]
    public function password_is_changed_when_provided(): void
    {
        $user = User::factory()->create();

        $this->admin()->put(route('users.update', $user), $this->payload([
            'name' => $user->name,
            'email' => $user->email,
        ]))->assertRedirect(route('users.index'));

        $this->assertTrue(Hash::check('secret-pass-1', $user->refresh()->password));
    }

    #[Test]
    public function admin_can_delete_another_user_but_not_self(): void
    {
        $other = User::factory()->create();
        $admin = User::factory()->create();

        $this->actingAs($admin)->delete(route('users.destroy', $other))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status');
        $this->assertModelMissing($other);

        $this->actingAs($admin)->delete(route('users.destroy', $admin))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');
        $this->assertModelExists($admin);
    }
}
