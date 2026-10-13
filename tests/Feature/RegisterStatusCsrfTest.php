<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterStatusCsrfTest extends TestCase
{
    public function test_the_status_page_exposes_a_csrf_token_meta_tag(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('name="csrf-token"', false);
    }

    public function test_the_form_still_contains_the_hidden_csrf_token_input(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('name="_token"', false);
    }

    public function test_the_ajax_fetch_sends_the_csrf_token_from_the_form_and_meta_tag(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('input[name="_token"]', false);
        $response->assertSee('meta[name="csrf-token"]', false);
        $response->assertSee("'X-CSRF-TOKEN': token", false);
        $response->assertSee('new FormData(form)', false);
    }

    public function test_the_ajax_fetch_sends_the_token_as_a_form_field(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee("body.append('_token', token)", false);
    }

    public function test_a_419_response_shows_a_clear_session_expired_message(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('Your session expired. Please refresh the page and try again.', false);
    }

    public function test_non_2xx_responses_show_a_clear_message_with_the_status_code(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('We could not check your registration status right now (error ', false);
    }
}
