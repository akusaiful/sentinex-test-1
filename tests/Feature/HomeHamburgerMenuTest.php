<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeHamburgerMenuTest extends TestCase
{
    public function test_home_navigation_renders_a_hamburger_toggle_for_the_menu(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="nav-toggle"', false);
        $response->assertSee('aria-controls="primary-menu"', false);
        $response->assertSee('aria-expanded="false"', false);
        $response->assertSee('aria-label="Open navigation menu"', false);
        $response->assertSee('class="nav-toggle"', false);
    }

    public function test_nav_links_live_inside_the_collapsible_menu_container(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="primary-menu"', false);
        $response->assertSee('class="nav-menu"', false);

        $response->assertSeeInOrder(
            ['id="primary-menu"', 'Home', 'About', 'Contact', 'Registration'],
            false
        );
    }

    public function test_mobile_media_query_hides_the_menu_and_reveals_the_toggle(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('@media (max-width: 767px)', false);
        $response->assertSee('.nav-menu.is-open', false);
        $response->assertSee('display: none;', false);

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-toggle\s*\{[^}]*display:\s*inline-flex/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-menu\s*\{[^}]*display:\s*none/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/\.nav-menu\.is-open\s*\{[^}]*display:\s*flex/s',
            $html
        );
    }

    public function test_theme_toggle_remains_in_the_navigation_on_mobile(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="theme-toggle"', false);
        $response->assertSee('aria-label="Switch to light theme"', false);

        $response->assertSeeInOrder(['id="primary-menu"', 'id="theme-toggle"'], false);
    }

    public function test_desktop_keeps_the_full_horizontal_nav(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(
            'class="main-nav flex flex-wrap items-center justify-center gap-3"',
            false
        );

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/\.nav-menu\s*\{[^}]*display:\s*flex/s',
            $html
        );

        $menuRule = $this->baseNavMenuRule($html);
        $this->assertStringNotContainsString('display: none', $menuRule);
        $this->assertStringNotContainsString('max-width: 767px', $menuRule);
    }

    public function test_vanilla_js_toggles_the_menu_open_and_closed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertStringContainsString("getElementById('nav-toggle')", $html);
        $this->assertStringContainsString("getElementById('primary-menu')", $html);
        $this->assertStringContainsString("classList.toggle('is-open'", $html);
        $this->assertStringContainsString("setAttribute('aria-expanded'", $html);
    }

    private function baseNavMenuRule(string $html): string
    {
        $matches = [];

        if (preg_match('/\.nav-menu\s*\{([^}]*)\}/', $html, $matches) === 1) {
            return $matches[1];
        }

        return '';
    }
}
