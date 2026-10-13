<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeSentigateFazlinTest extends TestCase
{
    public function test_home_page_branding_reads_sentigate_fazlin(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sentigate Fazlin');
        $response->assertSee(
            '<h1 id="hero-title" class="sg-title">Sentigate Fazlin</h1>',
            false
        );
    }

    public function test_rest_of_home_page_branding_is_unchanged(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sentigate Platform');
        $response->assertSee('A modern Laravel foundation for your next project.');
    }
}
