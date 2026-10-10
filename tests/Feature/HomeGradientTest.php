<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeGradientTest extends TestCase
{
    public function test_home_screen_uses_a_gradient_background(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('bg-gradient-to-br', false);
        $response->assertSee('from-[#FDFDFC]', false);
        $response->assertSee('dark:from-[#0a0a0a]', false);
    }
}
