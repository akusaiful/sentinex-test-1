<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders_a_tailwind_confirmation_modal(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-modal', false);
        $response->assertSee('id="confirmation-modal"', false);
        $response->assertSee('role="dialog"', false);
        $response->assertSee('aria-modal="true"', false);
        $response->assertSee('fixed inset-0', false);
        $response->assertSee('bg-black/50', false);
        $response->assertSee('max-w-md', false);
    }

    public function test_confirmation_modal_is_hidden_until_the_form_is_submitted(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"', false);
    }

    public function test_confirmation_modal_offers_confirm_and_cancel_controls(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-confirm', false);
        $response->assertSee('data-confirmation-cancel', false);
        $response->assertSee('Yes, send', false);
        $response->assertSee('Cancel', false);
    }

    public function test_confirmation_modal_summarises_the_entered_details(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-summary="name"', false);
        $response->assertSee('data-confirmation-summary="email"', false);
        $response->assertSee('data-confirmation-summary="mobile"', false);
    }

    public function test_confirmation_is_driven_by_the_contact_form_submit_event(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('id="contact-form"', false);
        $response->assertSee("form.addEventListener('submit'", false);
    }

    public function test_confirmation_does_not_use_the_native_browser_dialog(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertDontSee('confirm(', false);
        $response->assertDontSee('window.confirm', false);
        $response->assertDontSee('alert(', false);
    }

    public function test_contact_form_still_submits_when_confirmation_is_bypassed(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Confirm User',
            'email' => 'confirm@example.com',
            'mobile' => '0199999999',
        ]);

        $response->assertRedirect(route('contact.create'));
        $this->assertDatabaseHas('contacts', [
            'email' => 'confirm@example.com',
        ]);
    }
}
