<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeNavigationTest extends TestCase
{
    public function test_home_page_renders_the_top_navigation_bar(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-label="Main navigation"', false);
        $response->assertSeeInOrder(['<nav', '<main'], false);
    }

    public function test_navigation_links_point_to_the_existing_main_routes(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="'.route('home').'"', false);
        $response->assertSee('href="'.url('/about').'"', false);
        $response->assertSee('href="'.route('contact.create').'"', false);
    }

    public function test_navigation_indicates_the_active_home_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-current="page"', false);

        $home = 'href="'.route('home').'"';
        $active = 'aria-current="page"';
        $about = 'href="'.url('/about').'"';

        $response->assertSeeInOrder([$home, $active, $about], false);
    }
}
