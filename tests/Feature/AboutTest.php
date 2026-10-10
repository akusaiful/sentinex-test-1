<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutTest extends TestCase
{
    public function test_about_page_returns_a_successful_response(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('About');
        $response->assertSee('Our mission');
    }

    public function test_about_page_uses_a_blue_to_green_gradient(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('linear-gradient(to bottom right, #2563eb, #10b981)', false);
    }

    public function test_about_page_has_a_button(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('class="button"', false);
        $response->assertSee('Get started');
    }
}
