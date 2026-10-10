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
}
