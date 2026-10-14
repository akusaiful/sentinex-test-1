<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeSentigateIzazayTest extends TestCase
{
    public function test_home_page_branding_reads_sentigate_izazay(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sentigate Izazay');
        $response->assertSee(
            '<h1 id="hero-title" class="sg-title">Sentigate Izazay</h1>',
            false
        );
    }

    public function test_home_page_no_longer_reads_sentigate_fazlin(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Sentigate Fazlin');
    }

    public function test_rest_of_home_page_branding_is_unchanged(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sentigate Platform');
        $response->assertSee('A modern Laravel foundation for your next project.');
    }
}
