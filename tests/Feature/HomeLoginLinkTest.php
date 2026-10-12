<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeLoginLinkTest extends TestCase
{
    public function test_login_link_appears_at_the_end_of_the_navigation_after_the_theme_toggle(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeInOrder(
            ['id="theme-toggle"', 'Theme', 'href="'.route('login').'"', 'Login'],
            false
        );
    }

    public function test_login_link_lives_inside_the_collapsible_menu_container(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeInOrder(
            ['id="primary-menu"', 'id="theme-toggle"', 'Login', '<main'],
            false
        );
    }

    public function test_login_link_points_to_the_login_route(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="'.route('login').'"', false);
        $this->assertSame('/login', parse_url(route('login'), PHP_URL_PATH));
    }
}
