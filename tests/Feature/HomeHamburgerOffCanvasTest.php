<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeHamburgerOffCanvasTest extends TestCase
{
    public function test_mobile_menu_is_an_off_canvas_panel_positioned_off_screen_to_the_left(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-menu\s*\{[^}]*position:\s*fixed/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-menu\s*\{[^}]*left:\s*0/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-menu\s*\{[^}]*transform:\s*translateX\(-100%\)/s',
            $html
        );
    }

    public function test_mobile_menu_transitions_smoothly_when_it_opens_and_closes(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/\.nav-menu\s*\{[^}]*transition:\s*transform[^}]*\}/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/\.nav-menu\.is-open\s*\{[^}]*display:\s*flex[^}]*transform:\s*translateX\(0\)/s',
            $html
        );

        $this->assertStringContainsString('@starting-style', $html);
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $html);
    }

    public function test_open_panel_is_rendered_and_slid_into_place(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/\.nav-menu\.is-open\s*\{[^}]*display:\s*flex[^}]*transform:\s*translateX\(0\)/s',
            $html
        );
    }

    public function test_off_canvas_keeps_the_links_registration_and_theme_toggle(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="primary-menu"', false);
        $response->assertSee('class="nav-menu"', false);

        $response->assertSeeInOrder(
            ['id="primary-menu"', 'Home', 'About', 'Contact', 'Registration'],
            false
        );

        $response->assertSee('nav-link nav-link-register', false);

        $response->assertSee('id="theme-toggle"', false);
        $response->assertSeeInOrder(['id="primary-menu"', 'id="theme-toggle"'], false);
    }

    public function test_mobile_hamburger_and_theme_toggle_stay_above_the_panel(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-toggle\s*\{[^}]*z-index:\s*70/s',
            $html
        );

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.theme-toggle\s*\{[^}]*z-index:\s*70/s',
            $html
        );
    }

    public function test_vanilla_js_closes_the_panel_when_a_link_is_tapped(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertStringContainsString("menu.addEventListener('click'", $html);
        $this->assertStringContainsString("event.target.closest('a')", $html);
        $this->assertStringContainsString('setOpen(false)', $html);
        $this->assertStringContainsString("classList.toggle('is-open'", $html);
    }
}
