<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeGradientCssTest extends TestCase
{
    public function test_home_screen_renders_a_visible_gradient_background(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(
            'background-image: linear-gradient(to bottom right, #FDFDFC, #f4efec, #e9dfd8)',
            false
        );
        $response->assertSee('@media (prefers-color-scheme: dark)', false);
        $response->assertSee(
            'background-image: linear-gradient(to bottom right, #0a0a0a, #160f0d, #241009)',
            false
        );
    }

    public function test_home_screen_keeps_tailwind_gradient_utilities(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('bg-gradient-to-br', false);
        $response->assertSee('bg-linear-to-br', false);
        $response->assertSee('from-[#FDFDFC]', false);
        $response->assertSee('dark:from-[#0a0a0a]', false);
    }
}
