<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginSentigateThemeTest extends TestCase
{
    public function test_login_page_defines_the_sentigate_theme_variables(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('--sg-bg: #050816', false);
        $response->assertSee('--sg-text: #e8ecf8', false);
        $response->assertSee('--sg-muted: #9aa8bd', false);
        $response->assertSee('--sg-border: rgba(148, 163, 184, 0.18)', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
        $response->assertSee('--sg-accent-2: #818cf8', false);
        $response->assertSee('body.sg-page', false);
    }

    public function test_login_page_uses_the_dark_card_and_accent_button(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('class="sg-card"', false);
        $response->assertSee('class="sg-input"', false);
        $response->assertSee('class="sg-btn sg-btn-primary"', false);
        $response->assertSee('linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2))', false);
    }

    public function test_login_page_posts_to_the_login_route(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('action="'.route('login.store').'"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
    }
}
