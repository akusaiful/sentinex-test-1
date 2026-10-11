<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeMalaysiaMapTest extends TestCase
{
    public function test_home_page_loads_and_contains_the_malaysia_map_section(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="malaysia"', false);
        $response->assertSee('Across Malaysia');
    }

    public function test_map_section_renders_an_inline_svg_malaysia_outline(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<svg class="sg-map-svg"', false);
        $response->assertSee('viewBox="0 0 400 260"', false);
        $response->assertSee('class="sg-map-land"', false);
        $response->assertSee('Map of Malaysia');

        $html = $response->getContent();
        $this->assertGreaterThanOrEqual(2, substr_count($html, 'sg-map-land'));
        $this->assertStringContainsString('<path d="M88 40', $html);
        $this->assertStringContainsString('<path d="M196 150', $html);
    }

    public function test_map_section_matches_the_sentigate_theme(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('.sg-map {', false);
        $response->assertSee('radial-gradient', false);
        $response->assertSee('sg-h2', false);
        $response->assertSee('sg-muted', false);
        $response->assertSee('var(--sg-accent)', false);
        $response->assertSee('class="sg-dot"', false);
    }

    public function test_map_section_is_responsive_on_mobile_and_desktop(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('.sg-map-layout {', false);
        $response->assertSee('grid-template-columns: 1fr;', false);
        $response->assertSee('grid-template-columns: 1.05fr 0.95fr;', false);
        $response->assertSee('@media (min-width: 768px)', false);
    }

    public function test_existing_sections_and_navigation_are_preserved(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sentigate');
        $response->assertSee("Let's get started", false);
        $response->assertSee('aria-label="Main navigation"', false);
        $response->assertSee('href="'.route('home').'"', false);
        $response->assertSee('href="'.url('/about').'"', false);
        $response->assertSee('href="'.route('contact.create').'"', false);
    }
}
