<?php

namespace Tests\Feature;

use Tests\TestCase;

class SentigateHeroTest extends TestCase
{
    public function test_home_page_loads_and_shows_the_sentigate_hero(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="sentigate-hero-title"', false);
        $response->assertSee('Meet Sentigate', false);
        $response->assertSee('Get started', false);
    }

    public function test_hero_is_rendered_above_the_existing_home_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeInOrder(
            ['id="sentigate-hero-title"', "Let's get started"],
            false
        );
    }

    public function test_hero_keeps_the_navigation_and_cta_routes_intact(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-label="Main navigation"', false);
        $response->assertSeeInOrder(['<nav', 'id="sentigate-hero-title"', '<main'], false);
        $response->assertSee('href="'.route('contact.create').'"', false);
    }

    public function test_hero_uses_futuristic_and_accessible_styling(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('sentigate-hero', false);
        $response->assertSee('sentigate-hero-badge', false);
        $response->assertSee('sentigate-hero-cta', false);
        $response->assertSee('linear-gradient(135deg, #0b1020 0%, #111827 48%, #1e1b4b 100%)', false);
        $response->assertSee('.sentigate-hero-cta:focus-visible', false);
        $response->assertSee('@media (min-width: 1024px)', false);
    }
}
