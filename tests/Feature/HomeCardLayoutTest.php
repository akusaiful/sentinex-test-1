<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeCardLayoutTest extends TestCase
{
    public function test_home_page_is_split_into_card_based_feature_and_plan_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="features"', false);
        $response->assertSee('id="plans"', false);
        $response->assertSee('class="sg-feature-grid"', false);
        $response->assertSee('class="sg-plan-grid"', false);

        $html = $response->getContent();

        $this->assertGreaterThanOrEqual(6, substr_count($html, 'class="sg-card'));
        $this->assertGreaterThanOrEqual(3, substr_count($html, 'sg-feature-card'));
        $this->assertGreaterThanOrEqual(3, substr_count($html, 'sg-plan'));
    }

    public function test_cards_use_badges_and_pills_to_convey_hierarchy(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('class="sg-eyebrow"', false);
        $response->assertSee('sg-pill-accent', false);
        $response->assertSee('sg-pill-violet', false);
        $response->assertSee('sg-pill-pink', false);
        $response->assertSee('Popular');

        $html = $response->getContent();

        $this->assertGreaterThanOrEqual(3, substr_count($html, 'sg-pill'));
    }

    public function test_new_sections_have_a_clear_visual_hierarchy(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('.sg-section {', false);
        $response->assertSee('.sg-section-title {', false);
        $response->assertSee('.sg-h3 {', false);
        $response->assertSee('.sg-plan-price {', false);
        $response->assertSee('.sg-plan-featured {', false);
        $response->assertSee('@media (min-width: 768px)', false);
        $response->assertSee('grid-template-columns: repeat(3, 1fr);', false);
    }

    public function test_roboto_is_loaded_and_applied_to_headings_and_body(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('https://fonts.googleapis.com/css2?family=Roboto', false);
        $response->assertSee("font-family: 'Roboto', ui-sans-serif, system-ui, sans-serif;", false);
        $response->assertSee('.sg-page h1,', false);
        $response->assertSee('.sg-page h3,', false);
    }

    public function test_existing_hero_content_and_malaysia_map_remain(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('A modern Laravel foundation for your next project.');
        $response->assertSee("Let's get started", false);
        $response->assertSee('Across Malaysia');
        $response->assertSee('id="malaysia-map"', false);
        $response->assertSee('class="sg-map-canvas"', false);
    }
}
