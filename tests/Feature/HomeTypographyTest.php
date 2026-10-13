<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTypographyTest extends TestCase
{
    public function test_home_page_loads_roboto_from_the_google_fonts_cdn(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('https://fonts.googleapis.com/css2?family=Roboto', false);
        $response->assertSee('https://fonts.gstatic.com', false);
    }

    public function test_roboto_is_applied_to_the_body_and_headings(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee("--sg-font-sans: 'Roboto'", false);
        $response->assertSee('body.sg-page h1,', false);
        $response->assertSee('body.sg-page h2,', false);
        $response->assertSee('font-family: var(--sg-font-sans);', false);
    }

    public function test_home_page_defines_a_consistent_typography_scale(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('--sg-font-size-base: 1rem;', false);
        $response->assertSee('--sg-line-height-base: 1.65;', false);
        $response->assertSee('--sg-heading-line-height: 1.15;', false);
        $response->assertSee('--sg-font-size-h1: clamp(2.75rem, 8vw, 5rem);', false);
        $response->assertSee('--sg-font-size-h2: clamp(1.375rem, 2.4vw, 1.75rem);', false);
    }

    public function test_typography_tokens_are_applied_to_the_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('font-size: var(--sg-font-size-base);', false);
        $response->assertSee('line-height: var(--sg-line-height-base);', false);
        $response->assertSee('font-size: var(--sg-font-size-h1);', false);
        $response->assertSee('font-size: var(--sg-font-size-h2);', false);
    }

    public function test_home_page_uses_the_dark_theme_with_cards_and_badges(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('--sg-bg: #050816;', false);
        $html = $response->getContent();
        $this->assertGreaterThanOrEqual(2, substr_count($html, 'class="sg-card'));
        $response->assertSee('sg-badge', false);
    }

    public function test_existing_hero_and_intro_content_is_unchanged(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('class="sg-hero"', false);
        $response->assertSee('Sentigate');
        $response->assertSee('A modern Laravel foundation for your next project.');
        $response->assertSee("Let's get started", false);
        $response->assertSee('Across Malaysia');
    }
}
