<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeNavigationLayoutTest extends TestCase
{
    public function test_nav_container_uses_a_consistent_centered_flex_layout(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(
            'class="main-nav flex flex-wrap items-center justify-center gap-3"',
            false
        );
    }

    public function test_every_nav_link_shares_the_same_aligned_base_classes(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertSame(3, substr_count($html, 'nav-link inline-flex items-center justify-center'));
        $this->assertStringNotContainsString('inline-block px-3 py-1.5', $html);
        $this->assertStringNotContainsString('gap-2 sm:gap-3', $html);
    }

    public function test_fallback_stylesheet_locks_down_the_nav_alignment(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('.main-nav', false);
        $response->assertSee('flex-wrap: wrap', false);
        $response->assertSee('gap: 0.75rem', false);
        $response->assertSee('.nav-link', false);
        $response->assertSee('white-space: nowrap', false);
        $response->assertSee('padding: 0.375rem 1.25rem', false);
    }
}
