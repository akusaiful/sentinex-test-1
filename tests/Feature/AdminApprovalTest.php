<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminApprovalTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'status' => 'approved',
            'is_admin' => true,
        ]);
    }

    public function test_guest_is_redirected_away_from_the_admin_users_page(): void
    {
        $response = $this->get('/admin/users');

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_is_redirected_away_from_the_admin_users_page(): void
    {
        $user = User::factory()->create([
            'status' => 'approved',
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_sees_the_list_of_pending_users(): void
    {
        User::factory()->create([
            'name' => 'Pending Pat',
            'email' => 'pat@example.com',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin())->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Pending users');
        $response->assertSee('Pending Pat');
        $response->assertSee('pat@example.com');
    }

    public function test_admin_users_page_only_lists_pending_users(): void
    {
        User::factory()->create([
            'name' => 'Approved Anna',
            'email' => 'anna@example.com',
            'status' => 'approved',
        ]);
        User::factory()->create([
            'name' => 'Rejected Rita',
            'email' => 'rita@example.com',
            'status' => 'rejected',
        ]);
        User::factory()->create([
            'name' => 'Pending Pat',
            'email' => 'pat@example.com',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin())->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Pending Pat');
        $response->assertDontSee('Approved Anna');
        $response->assertDontSee('Rejected Rita');
    }

    public function test_admin_users_page_exposes_approve_and_reject_actions(): void
    {
        $user = User::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin())->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee(route('admin.users.approve', $user), false);
        $response->assertSee(route('admin.users.reject', $user), false);
        $response->assertSee('Approve');
        $response->assertSee('Reject');
    }

    public function test_approving_a_user_sets_status_to_approved(): void
    {
        $user = User::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin())
            ->post(route('admin.users.approve', $user));

        $response->assertRedirect(route('admin.users'));
        $this->assertSame('approved', $user->fresh()->status);
    }

    public function test_rejecting_a_user_sets_status_to_rejected(): void
    {
        $user = User::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin())
            ->post(route('admin.users.reject', $user));

        $response->assertRedirect(route('admin.users'));
        $this->assertSame('rejected', $user->fresh()->status);
    }

    public function test_non_admin_cannot_approve_a_user(): void
    {
        $user = User::factory()->create(['status' => 'pending']);
        $nonAdmin = User::factory()->create(['status' => 'approved', 'is_admin' => false]);

        $response = $this->actingAs($nonAdmin)
            ->post(route('admin.users.approve', $user));

        $response->assertRedirect(route('login'));
        $this->assertSame('pending', $user->fresh()->status);
    }

    public function test_admin_users_page_uses_the_sentigate_theme(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('--sg-bg: #050816', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
        $response->assertSee('body.sg-page', false);
        $response->assertSee('class="sg-card"', false);
        $response->assertSee('linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2))', false);
    }
}
