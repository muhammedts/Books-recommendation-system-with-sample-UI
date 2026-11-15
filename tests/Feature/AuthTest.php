<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_register(): void
    {
        $this->get(route('register'))->assertOk();

        $this->post(route('register'), [
            'name' => 'New Reader',
            'email' => 'reader@example.com',
            'password' => 'correct-horse-battery',
            'password_confirmation' => 'correct-horse-battery',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $user = User::firstWhere('email', 'reader@example.com');
        $this->assertFalse($user->is_admin);
    }

    public function test_registration_cannot_make_a_user_admin(): void
    {
        $this->post(route('register'), [
            'name' => 'Sneaky',
            'email' => 'sneaky@example.com',
            'password' => 'correct-horse-battery',
            'password_confirmation' => 'correct-horse-battery',
            'is_admin' => 1,
        ]);

        $this->assertFalse(User::firstWhere('email', 'sneaky@example.com')->is_admin);
    }

    public function test_a_user_can_log_in_and_out(): void
    {
        $user = User::factory()->create(['email' => 'ada@example.com']);

        $this->get(route('login'))->assertOk();

        $this->post(route('login'), ['email' => 'ada@example.com', 'password' => 'password'])
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))->assertRedirect(route('books.index'));
        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected(): void
    {
        User::factory()->create(['email' => 'ada@example.com']);

        $this->post(route('login'), ['email' => 'ada@example.com', 'password' => 'nope'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
