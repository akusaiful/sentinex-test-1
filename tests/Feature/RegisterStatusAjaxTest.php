<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterStatusAjaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_page_contains_the_ajax_form_hooks(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('id="status-form"', false);
        $response->assertSee('id="status-submit"', false);
        $response->assertSee('id="status-result"', false);
        $response->assertSee('aria-live="polite"', false);
        $response->assertSee('sg-spinner', false);
        $response->assertSee('data-loading', false);
        $response->assertSee('fetch(form.action', false);
        $response->assertSee('X-Requested-With', false);
    }

    public function test_the_form_still_has_a_non_ajax_fallback_action(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('method="POST"', false);
        $response->assertSee('action="'.route('register.status.check').'"', false);
    }

    public function test_ajax_lookup_returns_pending_status_as_json(): void
    {
        User::factory()->create([
            'name' => 'Pending Person',
            'email' => 'pending-ajax@example.com',
            'status' => 'pending',
        ]);

        $response = $this->postJson('/register/status', ['email' => 'pending-ajax@example.com']);

        $response->assertOk();
        $response->assertJson([
            'found' => true,
            'email' => 'pending-ajax@example.com',
            'name' => 'Pending Person',
            'status' => 'pending',
            'label' => 'Pending',
            'modifier' => 'pending',
        ]);
    }

    public function test_ajax_lookup_returns_approved_status_as_json(): void
    {
        User::factory()->create([
            'name' => 'Approved Person',
            'email' => 'approved-ajax@example.com',
            'status' => 'approved',
        ]);

        $response = $this->postJson('/register/status', ['email' => 'approved-ajax@example.com']);

        $response->assertOk();
        $response->assertJson([
            'found' => true,
            'status' => 'approved',
            'label' => 'Approved',
            'modifier' => 'approved',
        ]);
    }

    public function test_ajax_lookup_returns_rejected_status_as_json(): void
    {
        User::factory()->create([
            'name' => 'Rejected Person',
            'email' => 'rejected-ajax@example.com',
            'status' => 'rejected',
        ]);

        $response = $this->postJson('/register/status', ['email' => 'rejected-ajax@example.com']);

        $response->assertOk();
        $response->assertJson([
            'found' => true,
            'status' => 'rejected',
            'label' => 'Rejected',
            'modifier' => 'rejected',
        ]);
    }

    public function test_ajax_lookup_for_an_unregistered_email_reports_not_found(): void
    {
        $response = $this->postJson('/register/status', ['email' => 'nobody-ajax@example.com']);

        $response->assertOk();
        $response->assertJson([
            'found' => false,
            'email' => 'nobody-ajax@example.com',
        ]);
    }

    public function test_ajax_lookup_validates_the_email(): void
    {
        $response = $this->postJson('/register/status', ['email' => 'not-an-email']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
