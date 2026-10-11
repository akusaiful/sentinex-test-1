<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_returns_a_successful_response(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Create your account');
    }

    public function test_register_page_renders_the_expected_inputs(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="password_confirmation"', false);
    }

    public function test_register_page_uses_the_site_theme(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('linear-gradient(to bottom right, #2563eb, #10b981)', false);
        $response->assertSee('class="card"', false);
        $response->assertSee('class="button"', false);
    }

    public function test_register_form_posts_to_the_register_route(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('action="'.route('register.store').'"', false);
    }
}
