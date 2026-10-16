<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_returns_200_and_renders_email_and_password_fields(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('type="email"', false);
        $response->assertSee('type="password"', false);
    }

    public function test_admin_login_page_posts_to_the_admin_login_route(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('action="'.route('admin.login.store').'"', false);
        $response->assertSee('Admin log in');
    }

    public function test_a_valid_admin_can_log_in_and_is_redirected_to_the_approval_page(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'approved',
            'is_admin' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('admin.approvals'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_the_approval_page_is_reachable_for_a_logged_in_admin(): void
    {
        $admin = User::factory()->create([
            'status' => 'approved',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/approvals');

        $response->assertStatus(200);
        $response->assertSee('Admin approval');
    }

    public function test_the_approval_page_lists_pending_users(): void
    {
        $admin = User::factory()->create([
            'status' => 'approved',
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Pending Person',
            'email' => 'pending@example.com',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get('/admin/approvals');

        $response->assertStatus(200);
        $response->assertSee('Pending Person');
        $response->assertSee('pending@example.com');
    }

    public function test_wrong_credentials_show_an_error_and_do_not_log_the_user_in(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'approved',
            'is_admin' => true,
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_a_non_admin_user_cannot_log_in_through_the_admin_login(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'approved',
            'is_admin' => false,
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'user@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_a_guest_cannot_view_the_approval_page(): void
    {
        $response = $this->get('/admin/approvals');

        $response->assertRedirect('/admin/login');
    }
}
