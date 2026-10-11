<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    public function test_register_page_returns_a_successful_response(): void
    {
        $this->get('/register')->assertStatus(200);
    }

    public function test_register_page_contains_the_expected_fields(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="password_confirmation"', false);
    }

    public function test_register_form_posts_to_the_store_route(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('action="'.route('register.store').'"', false);
    }

    public function test_home_page_links_to_the_register_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="'.route('register').'"', false);
    }
}
