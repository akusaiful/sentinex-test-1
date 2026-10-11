<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_renders_a_confirmation_modal(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-modal', false);
        $response->assertSee('id="confirmation-modal"', false);
        $response->assertSee('role="dialog"', false);
        $response->assertSee('aria-modal="true"', false);
    }

    public function test_confirmation_modal_summarises_the_name_and_email(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-summary="name"', false);
        $response->assertSee('data-confirmation-summary="email"', false);
        $response->assertSee('Confirm your details', false);
    }

    public function test_confirmation_modal_offers_confirm_and_cancel_controls(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-confirm', false);
        $response->assertSee('data-confirmation-cancel', false);
        $response->assertSee('Confirm &amp; create account', false);
        $response->assertSee('Cancel', false);
    }

    public function test_confirmation_is_driven_by_the_register_form_submit_event(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('id="register-form"', false);
        $response->assertSee("form.addEventListener('submit'", false);
    }

    public function test_cancel_closes_the_modal_without_submitting(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('cancelButton.addEventListener', false);
        $response->assertSee('closeModal', false);
    }

    public function test_confirm_proceeds_with_the_real_form_submit(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('confirmButton.addEventListener', false);
        $response->assertSee('form.submit()', false);
    }

    public function test_confirmation_does_not_use_the_native_browser_dialog(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertDontSee('window.confirm', false);
        $response->assertDontSee('confirm(', false);
        $response->assertDontSee('alert(', false);
    }

    public function test_confirmation_modal_matches_the_register_theme(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('sg-modal', false);
        $response->assertSee('sg-modal-panel', false);
        $response->assertSee('sg-modal-summary-row', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
    }

    public function test_account_is_only_created_when_the_form_is_submitted(): void
    {
        $this->assertDatabaseMissing('users', ['email' => 'modal@example.com']);

        $response = $this->post('/register', [
            'name' => 'Modal User',
            'email' => 'modal@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('register.create'));
        $this->assertDatabaseHas('users', [
            'email' => 'modal@example.com',
        ]);
    }
}
