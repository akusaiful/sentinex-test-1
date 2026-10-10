<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactConfirmationOnceTest extends TestCase
{
    public function test_confirming_the_modal_never_falls_back_to_a_native_browser_dialog(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-modal', false);
        $response->assertDontSee('window.confirm', false);
        $response->assertDontSee('confirm(', false);
        $response->assertDontSee('alert(', false);
    }

    public function test_the_confirmation_state_is_tracked_so_the_modal_is_only_shown_once(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('var confirmed = false;', false);
        $response->assertSee('if (confirmed)', false);
        $response->assertSee('confirmed = true;', false);
    }

    public function test_confirming_submits_the_form_without_replaying_the_submit_event(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('form.submit();', false);
        $response->assertDontSee('requestSubmit', false);
        $response->assertDontSee('dispatchEvent', false);
    }

    public function test_the_confirm_handler_guards_against_repeated_activation(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee(
            "confirmButton.addEventListener('click', function (event) {",
            false
        );
        $response->assertSee('event.preventDefault();', false);
    }

    public function test_the_confirmation_controls_do_not_natively_submit_the_form(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('data-confirmation-confirm', false);
        $response->assertSee('data-confirmation-cancel', false);
        $response->assertSee('type="button"', false);
    }
}
