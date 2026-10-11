<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeSentigateThemeTest extends TestCase
{
    public function test_home_page_loads_and_renders_the_sentigate_hero(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sentigate');
        $response->assertSee('A modern Laravel foundation for your next project.');

        $response->assertSee('class="sg-hero"', false);
        $response->assertSee('sg-title', false);
        $response->assertSee('sg-badge', false);
        $response->assertSee('Sentigate Platform');
    }

    public function test_hero_cta_link_has_visible_hover_and_focus_states(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('class="sg-btn sg-btn-primary"', false);
        $response->assertSee('href="'.route('contact.create').'"', false);
        $response->assertSee('.sg-btn:focus-visible', false);
        $response->assertSee('.sg-btn-primary:hover', false);
    }

    public function test_hero_uses_a_dark_gradient_and_glow_background(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('.sg-hero {', false);
        $response->assertSee('linear-gradient(150deg, #0b1030 0%, #0a0a1f 58%, #14082b 100%)', false);
        $response->assertSee('radial-gradient', false);
    }

    public function test_all_existing_sections_and_copy_are_preserved_and_themed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee("Let's get started", false);
        $response->assertSee('Laravel has an incredibly rich ecosystem. We suggest starting with the following.');
        $response->assertSee('Documentation');
        $response->assertSee('Laracasts');
        $response->assertSee('Deploy now');
        $response->assertSee('Contact us');

        $html = $response->getContent();
        $this->assertGreaterThanOrEqual(2, substr_count($html, 'class="sg-card'));
        $response->assertSee('sg-card-visual', false);
    }

    public function test_navigation_links_are_preserved(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-label="Main navigation"', false);
        $response->assertSee('href="'.route('home').'"', false);
        $response->assertSee('href="'.url('/about').'"', false);
        $response->assertSee('href="'.route('contact.create').'"', false);
    }

    public function test_layout_is_responsive_on_mobile_and_desktop(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('name="viewport"', false);
        $response->assertSee('grid-template-columns: 1fr;', false);
        $response->assertSee('@media (min-width: 768px)', false);
        $response->assertSee('grid-template-columns: 1.15fr 0.85fr;', false);
    }
}
