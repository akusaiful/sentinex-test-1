<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_returns_200_and_renders_email_and_password_fields(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('type="email"', false);
        $response->assertSee('type="password"', false);
    }

    public function test_pending_user_cannot_log_in_and_sees_awaiting_admin_approval(): void
    {
        $user = User::factory()->create([
            'email' => 'pending@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'pending',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'pending@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->get('/login')->assertSee('awaiting admin approval');
    }

    public function test_rejected_user_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'rejected@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'rejected',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'rejected@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();

        $this->get('/login')->assertSee('awaiting admin approval');
    }

    public function test_approved_user_logs_in_successfully(): void
    {
        $user = User::factory()->create([
            'email' => 'approved@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'approved',
        ]);

        $response = $this->post('/login', [
            'email' => 'approved@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_seeded_admin_logs_in_successfully(): void
    {
        $this->seed();

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs(User::where('email', 'test@example.com')->firstOrFail());
    }

    public function test_invalid_credentials_are_rejected_with_a_generic_error(): void
    {
        User::factory()->create([
            'email' => 'approved@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'approved',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'approved@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
        $this->assertGuest();
    }

    public function test_login_requires_an_email_and_password(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_user_can_log_out(): void
    {
        $user = User::factory()->create(['status' => 'approved']);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
