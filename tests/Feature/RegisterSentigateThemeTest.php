<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterSentigateThemeTest extends TestCase
{
    public function test_register_page_defines_the_sentigate_theme_variables(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('--sg-bg: #050816', false);
        $response->assertSee('--sg-text: #e8ecf8', false);
        $response->assertSee('--sg-muted: #9aa8bd', false);
        $response->assertSee('--sg-border: rgba(148, 163, 184, 0.18)', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
        $response->assertSee('--sg-accent-2: #818cf8', false);
        $response->assertSee('body.sg-page', false);
    }

    public function test_register_page_uses_a_dark_card_and_dark_inputs(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('class="sg-card"', false);
        $response->assertSee('border: 1px solid var(--sg-border);', false);
        $response->assertSee('class="sg-input"', false);
        $response->assertSee('background: rgba(255, 255, 255, 0.04);', false);
    }

    public function test_register_page_uses_the_accent_gradient_button(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('class="sg-btn sg-btn-primary"', false);
        $response->assertSee('linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2))', false);
    }

    public function test_register_page_preserves_fields_route_copy_and_status_message(): void
    {
        $status = 'Your account has been created and is awaiting admin approval.';

        $response = $this->withSession(['status' => $status])->get('/register');

        $response->assertStatus(200);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="password_confirmation"', false);
        $response->assertSee('action="'.route('register.store').'"', false);
        $response->assertSee('Create your account');
        $response->assertSee('Register below. New accounts are reviewed by an administrator before they can log in.');
        $response->assertSee('Create account');
        $response->assertSee($status);
    }

    public function test_register_page_no_longer_uses_the_old_light_theme(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertDontSee('linear-gradient(to bottom right, #2563eb, #10b981)', false);
        $response->assertDontSee('background: #ffffff;', false);
    }
}
