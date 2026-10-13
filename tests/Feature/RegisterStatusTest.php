<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_page_returns_a_successful_response(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('Check registration status');
    }

    public function test_status_page_renders_an_email_form(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('name="email"', false);
        $response->assertSee('action="'.route('register.status.check').'"', false);
    }

    public function test_status_page_uses_the_site_theme(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('--sg-bg: #050816', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
        $response->assertSee('class="sg-card"', false);
        $response->assertSee('sg-btn sg-btn-primary', false);
    }

    public function test_a_pending_registration_shows_pending_status(): void
    {
        User::factory()->create([
            'email' => 'pending@example.com',
            'status' => 'pending',
        ]);

        $response = $this->post('/register/status', ['email' => 'pending@example.com']);

        $response->assertStatus(200);
        $response->assertSee('data-status-result="pending"', false);
        $response->assertSee('Pending');
    }

    public function test_an_approved_registration_shows_approved_status(): void
    {
        User::factory()->create([
            'email' => 'approved@example.com',
            'status' => 'approved',
        ]);

        $response = $this->post('/register/status', ['email' => 'approved@example.com']);

        $response->assertStatus(200);
        $response->assertSee('data-status-result="approved"', false);
        $response->assertSee('Approved');
    }

    public function test_a_rejected_registration_shows_rejected_status(): void
    {
        User::factory()->create([
            'email' => 'rejected@example.com',
            'status' => 'rejected',
        ]);

        $response = $this->post('/register/status', ['email' => 'rejected@example.com']);

        $response->assertStatus(200);
        $response->assertSee('data-status-result="rejected"', false);
        $response->assertSee('Rejected');
    }

    public function test_an_unregistered_email_shows_a_not_found_message(): void
    {
        $response = $this->post('/register/status', ['email' => 'missing@example.com']);

        $response->assertStatus(200);
        $response->assertSee('data-status-result="not-found"', false);
        $response->assertSee('No registration found');
        $response->assertSee('missing@example.com');
    }

    public function test_the_email_field_is_required_and_validated(): void
    {
        $response = $this->from('/register/status')->post('/register/status', ['email' => 'not-an-email']);

        $response->assertRedirect('/register/status');
        $response->assertSessionHasErrors('email');
    }
}
