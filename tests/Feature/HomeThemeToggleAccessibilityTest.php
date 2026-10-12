<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeThemeToggleAccessibilityTest extends TestCase
{
    public function test_theme_toggle_lives_inside_the_off_canvas_drawer(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        // The toggle must be a child of the drawer so it cannot be covered
        // by the panel/overlay when the menu slides open.
        $this->assertMatchesRegularExpression(
            '/id="primary-menu".*?id="theme-toggle".*?<\/div>/s',
            $html
        );

        // It is listed as the last item, after all the navigation links.
        $response->assertSeeInOrder(
            ['id="primary-menu"', 'Home', 'About', 'Contact', 'Registration', 'id="theme-toggle"'],
            false
        );
    }

    public function test_theme_toggle_is_styled_as_a_full_width_plain_item_in_the_drawer(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $rule = $this->mobileThemeToggleRule($response->getContent());

        $this->assertNotSame('', $rule, 'Expected a mobile rule for body.sg-page .theme-toggle.');
        $this->assertStringContainsString('width: 100%', $rule);
        $this->assertStringContainsString('justify-content: flex-start', $rule);
        $this->assertMatchesRegularExpression('/border:\s*(none|0)\b/', $rule);
        $this->assertMatchesRegularExpression('/border-radius:\s*0\b/', $rule);
        $this->assertMatchesRegularExpression('/background:\s*transparent/', $rule);
    }

    public function test_theme_toggle_is_not_rendered_as_a_header_button(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        // The toggle is no longer a sibling of the drawer in the header bar;
        // it should render only once, inside the drawer.
        $this->assertSame(1, substr_count($html, 'id="theme-toggle"'));
        $this->assertMatchesRegularExpression(
            '/id="theme-toggle".*?<\/button>\s*<\/div>\s*<\/nav>/s',
            $html
        );
    }

    private function mobileThemeToggleRule(string $html): string
    {
        $matches = [];

        if (
            preg_match(
                '/@media \(max-width: 767px\).*?body\.sg-page \.theme-toggle\s*\{([^}]*)\}/s',
                $html,
                $matches
            ) === 1
        ) {
            return $matches[1];
        }

        return '';
    }
}
