<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeThemeToggleTest extends TestCase
{
    public function test_home_navigation_shows_registration_after_contact(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeInOrder(['Home', 'About', 'Contact', 'Registration'], false);
        $response->assertSee('href="'.route('register.create').'"', false);
    }

    public function test_registration_link_opens_the_registration_form(): void
    {
        $this->get(route('register.create'))
            ->assertStatus(200)
            ->assertSee('Create your account');
    }

    public function test_home_navigation_renders_a_theme_toggle_button(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="theme-toggle"', false);
        $response->assertSee('aria-pressed="false"', false);
        $response->assertSee('data-theme="dark"', false);
    }

    public function test_home_page_defines_a_light_theme_via_css_variables(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee("html[data-theme='light']", false);
        $response->assertSee('--sg-bg: #f4f6fb', false);
        $response->assertSee('--sg-text: #10152a', false);
    }

    public function test_theme_toggle_persists_the_choice_in_local_storage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertStringContainsString('localStorage', $html);
        $this->assertStringContainsString('localStorage.setItem(storageKey, next)', $html);
        $this->assertStringContainsString("localStorage.getItem('sg-theme')", $html);
        $this->assertStringContainsString("root.setAttribute('data-theme', theme)", $html);
    }
}
