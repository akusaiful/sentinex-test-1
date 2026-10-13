<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterStatusAjaxFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_fetch_sends_the_ajax_content_negotiation_headers(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee("'Accept': 'application/json'", false);
        $response->assertSee("'X-Requested-With': 'XMLHttpRequest'", false);
        $response->assertSee("'X-CSRF-TOKEN'", false);
        $response->assertSee("credentials: 'same-origin'", false);
    }

    public function test_the_ajax_submission_keeps_the_loading_indicator(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('data-loading="false"', false);
        $response->assertSee('setLoading(true)', false);
        $response->assertSee('sg-spinner', false);
        $response->assertSee('aria-busy', false);
    }

    public function test_a_unreachable_server_shows_a_clear_message_not_a_generic_error(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('We could not reach the server. Please check your connection and try again.', false);
        $response->assertDontSee('Something went wrong', false);
    }

    public function test_an_http_failure_shows_a_clear_message(): void
    {
        $response = $this->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('We could not check your registration status right now (error ', false);
        $response->assertSee('We received an unexpected response from the server.', false);
    }

    public function test_an_accept_json_request_returns_json_and_not_the_html_page(): void
    {
        User::factory()->create([
            'name' => 'Header Person',
            'email' => 'headers-ajax@example.com',
            'status' => 'approved',
        ]);

        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->post('/register/status', ['email' => 'headers-ajax@example.com']);

        $response->assertOk();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJson([
            'found' => true,
            'status' => 'approved',
            'label' => 'Approved',
        ]);
    }

    public function test_an_unregistered_email_with_accept_header_reports_not_found_as_json(): void
    {
        $response = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/register/status', ['email' => 'missing-headers@example.com']);

        $response->assertOk();
        $response->assertJson([
            'found' => false,
            'email' => 'missing-headers@example.com',
        ]);
    }
}
