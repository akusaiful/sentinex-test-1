<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AboutContactThemeTest extends TestCase
{
    /**
     * Pages that must share the Home page chrome and theme.
     *
     * @return array<string, array{string}>
     */
    public static function pageProvider(): array
    {
        return [
            'about' => ['/about'],
            'contact' => ['/contact'],
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_page_uses_the_shared_home_theme_variables(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('data-theme="dark"', false);
        $response->assertSee('body.sg-page', false);
        $response->assertSee('--sg-bg: #050816', false);
        $response->assertSee('--sg-text: #e8ecf8', false);
        $response->assertSee('--sg-accent: #22d3ee', false);
        $response->assertSee('--sg-accent-2: #818cf8', false);
    }

    #[DataProvider('pageProvider')]
    public function test_page_supports_the_light_theme(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee("html[data-theme='light']", false);
        $response->assertSee('--sg-bg: #f4f6fb', false);
        $response->assertSee('--sg-text: #10152a', false);
    }

    #[DataProvider('pageProvider')]
    public function test_page_applies_the_theme_before_paint_and_persists_the_choice(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee("localStorage.getItem('sg-theme')", false);
        $response->assertSee("document.documentElement.setAttribute('data-theme', theme)", false);
        $response->assertSee('localStorage.setItem(storageKey, next)', false);
        $response->assertSee("root.setAttribute('data-theme', theme)", false);
    }

    #[DataProvider('pageProvider')]
    public function test_page_renders_the_shared_header_and_navigation(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('class="sg-header"', false);
        $response->assertSee('aria-label="Main navigation"', false);
        $response->assertSeeInOrder(['Home', 'About', 'Contact', 'Registration'], false);
        $response->assertSee('href="'.route('home').'"', false);
        $response->assertSee('href="'.url('/about').'"', false);
        $response->assertSee('href="'.route('contact.create').'"', false);
        $response->assertSee('href="'.route('register.create').'"', false);
        $response->assertSee('href="'.route('login').'"', false);
    }

    #[DataProvider('pageProvider')]
    public function test_page_renders_the_theme_toggle_and_responsive_menu(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('id="theme-toggle"', false);
        $response->assertSee('aria-pressed="false"', false);
        $response->assertSee('id="nav-toggle"', false);
        $response->assertSee('id="primary-menu"', false);
        $response->assertSee('class="nav-menu"', false);
    }

    #[DataProvider('pageProvider')]
    public function test_page_loads_the_roboto_font_stack_used_by_home(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('https://fonts.googleapis.com/css2?family=Roboto', false);
        $response->assertSee("'Roboto'", false);
    }

    public function test_about_page_content_is_preserved(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('About');
        $response->assertSee('Our mission');
        $response->assertSee('This application is built on Laravel and serves as a small,');
        $response->assertSee('Every feature starts with a clear user story');
        $response->assertSee('Get in touch');
        $response->assertSee('https://github.com/laravel/laravel', false);
        $response->assertSee('Contact us');
        $response->assertSee('Get started');
    }

    public function test_contact_page_content_is_preserved(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact');
        $response->assertSee('Send us a message and we will get back to you.');
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="mobile"', false);
        $response->assertSee('action="'.route('contact.store').'"', false);
        $response->assertSee('Send');
        $response->assertSee('data-confirmation-modal', false);
        $response->assertSee('Confirm your details');
        $response->assertSee('Yes, send');
    }
}
