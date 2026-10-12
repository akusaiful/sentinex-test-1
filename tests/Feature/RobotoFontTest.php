<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RobotoFontTest extends TestCase
{
    /**
     * Pages that should load the shared Roboto font stack.
     *
     * @return array<string, array{string}>
     */
    public static function pageProvider(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'contact' => ['/contact'],
            'register' => ['/register'],
            'login' => ['/login'],
            'register success' => ['/register/success'],
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_pages_load_roboto_from_google_fonts_cdn(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('https://fonts.googleapis.com/css2?family=Roboto', false);
        $response->assertSee('https://fonts.gstatic.com', false);
    }

    #[DataProvider('pageProvider')]
    public function test_pages_use_roboto_as_the_base_font_family(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee("'Roboto'", false);
        $response->assertDontSee('Instrument Sans', false);
    }
}
