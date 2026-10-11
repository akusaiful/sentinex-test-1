<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_registration_redirects_to_the_named_success_route(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertRedirect(route('register.success'));

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'status' => 'pending',
        ]);
    }

    public function test_success_page_returns_a_successful_response(): void
    {
        $response = $this->get('/register/success');

        $response->assertStatus(200);
    }

    public function test_success_page_states_the_account_is_awaiting_admin_approval(): void
    {
        $response = $this->get(route('register.success'));

        $response->assertStatus(200);
        $response->assertSee('Account created');
        $response->assertSee('Your account has been created and is awaiting admin approval.');
        $response->assertSee('Awaiting admin approval');
    }

    public function test_success_page_shares_the_registration_theme(): void
    {
        $response = $this->get(route('register.success'));

        $response->assertStatus(200);
        $response->assertSee('--sg-bg: #050816', false);
        $response->assertSee('--sg-text: #e8ecf8', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
        $response->assertSee('--sg-accent-2: #818cf8', false);
        $response->assertSee('body.sg-page', false);
        $response->assertSee('class="sg-card"', false);
        $response->assertSee('class="sg-btn sg-btn-primary"', false);
        $response->assertSee('linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2))', false);
        $response->assertSee('class="sg-btn sg-btn-ghost"', false);
    }

    public function test_success_page_displays_the_flashed_status_message(): void
    {
        $status = 'Your account has been created and is awaiting admin approval.';

        $response = $this->withSession(['status' => $status])->get(route('register.success'));

        $response->assertStatus(200);
        $response->assertSee($status);
    }
}
