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

    public function test_map_section_renders_a_leaflet_map_container(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="malaysia-map"', false);
        $response->assertSee('class="sg-map-canvas"', false);
    }

    public function test_map_section_loads_leaflet_from_a_pinned_cdn_and_centres_on_malaysia(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertStringContainsString('cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css', $html);
        $this->assertStringContainsString('cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js', $html);
        $this->assertStringContainsString('https://tile.openstreetmap.org/{z}/{x}/{y}.png', $html);
        $this->assertStringNotContainsString('cartocdn', $html);
        $this->assertStringContainsString('L.map(', $html);
        $this->assertStringContainsString('data-map-lat="4.2"', $html);
        $this->assertStringContainsString('data-map-lng="109"', $html);
        $this->assertStringContainsString('data-map-zoom="6"', $html);
    }

    public function test_map_section_uses_dark_themed_tiles_and_controls(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertStringContainsString('tile.openstreetmap.org', $html);
        $this->assertStringNotContainsString('cartocdn', $html);
        $this->assertStringContainsString(
            '.sg-map-canvas .leaflet-tile-pane { filter: invert(1) hue-rotate(180deg) brightness(0.95) contrast(0.9); }',
            $html
        );
        $this->assertStringContainsString('.sg-map-canvas.leaflet-container .leaflet-bar a', $html);
        $this->assertStringContainsString('.sg-map-canvas.leaflet-container .leaflet-control-attribution', $html);
        $this->assertStringContainsString('rgba(5, 8, 22, 0.85)', $html);
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
