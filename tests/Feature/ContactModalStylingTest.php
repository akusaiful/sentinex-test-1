<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactModalStylingTest extends TestCase
{
    public function test_modal_panel_uses_tailwind_card_styling(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('modal-panel', false);
        $response->assertSee('rounded-2xl', false);
        $response->assertSee('shadow-2xl', false);
        $response->assertSee('ring-1 ring-black/5', false);
    }

    public function test_modal_header_renders_a_leading_icon(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('modal-header', false);
        $response->assertSee('modal-icon', false);
        $response->assertSee('aria-hidden="true"', false);
    }

    public function test_modal_body_groups_the_summary_rows(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('modal-summary mt-5', false);
        $response->assertSee('modal-summary-row', false);
    }

    public function test_fallback_stylesheet_polishes_the_modal_panel(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('[data-confirmation-modal] .modal-panel', false);
        $response->assertSee('border-radius: 1rem', false);
        $response->assertSee('backdrop-filter: blur(4px)', false);
        $response->assertSee('box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25)', false);
    }

    public function test_modal_animations_respect_reduced_motion(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('@keyframes modal-panel-in', false);
        $response->assertSee('@keyframes modal-backdrop-in', false);
        $response->assertSee('prefers-reduced-motion', false);
    }
}
