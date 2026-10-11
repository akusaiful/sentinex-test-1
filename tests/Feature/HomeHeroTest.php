<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeHeroTest extends TestCase
{
    public function test_home_page_shows_a_sentigate_hero_above_the_existing_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-labelledby="sentigate-hero-title"', false);
        $response->assertSee('Introducing Sentigate', false);
        $response->assertSee('Sentigate is now available in this application.', false);
        $response->assertSeeInOrder(['sentigate-hero-title', "Let's get started"], false);
    }

    public function test_hero_includes_a_visible_call_to_action_button(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('hero-cta', false);
        $response->assertSee('Get started', false);

        $this->assertMatchesRegularExpression(
            '/<a\b(?=[^>]*hero-cta)(?=[^>]*href="[^"]+")[^>]*>\s*Get started/s',
            $response->getContent()
        );
    }

    public function test_hero_uses_a_responsive_container_that_avoids_overflow(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(
            '<section class="w-full max-w-[335px] lg:max-w-4xl mb-6"',
            false
        );
        $response->assertSee('lg:p-10', false);
    }

    public function test_fallback_stylesheet_renders_the_hero_without_a_build(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('.hero-panel', false);
        $response->assertSee('.hero-description', false);
        $response->assertSee('.hero-cta', false);
        $response->assertSee('text-align: center', false);
        $response->assertSee('display: inline-flex', false);
    }

    public function test_existing_home_content_and_navigation_are_preserved(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-label="Main navigation"', false);
        $response->assertSee('href="'.route('home').'"', false);
        $response->assertSee("Let's get started", false);
        $response->assertSeeInOrder(['<nav', '<section', '<main'], false);
    }
}
