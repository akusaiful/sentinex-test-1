<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeHamburgerPlainMenuTest extends TestCase
{
    public function test_mobile_menu_links_drop_the_button_box_chrome(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $rule = $this->mobilePanelLinkRule($response->getContent());

        $this->assertNotSame('', $rule, 'Expected a mobile rule for .nav-menu .nav-link.');
        $this->assertStringContainsString('width: 100%', $rule);
        $this->assertStringContainsString('justify-content: flex-start', $rule);
        $this->assertMatchesRegularExpression('/border:\s*(none|0)\b/', $rule);
        $this->assertMatchesRegularExpression('/border-radius:\s*0\b/', $rule);
        $this->assertMatchesRegularExpression('/background:\s*transparent/', $rule);
        $this->assertMatchesRegularExpression('/box-shadow:\s*none/', $rule);
    }

    public function test_mobile_active_link_is_not_rendered_as_a_gradient_button(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $matches = [];
        $this->assertSame(
            1,
            preg_match(
                "/body\\.sg-page \\.nav-menu \\.nav-link\\[aria-current='page'\\]\\s*\\{([^}]*)\\}/s",
                $html,
                $matches
            )
        );

        $this->assertMatchesRegularExpression('/background:\s*none/', $matches[1]);
        $this->assertMatchesRegularExpression('/border:\s*none/', $matches[1]);
        $this->assertMatchesRegularExpression('/box-shadow:\s*none/', $matches[1]);
    }

    public function test_mobile_theme_toggle_is_styled_as_a_plain_item(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $matches = [];
        $this->assertSame(
            1,
            preg_match(
                '/@media \(max-width: 767px\).*?body\.sg-page \.theme-toggle\s*\{([^}]*)\}/s',
                $html,
                $matches
            )
        );

        $this->assertMatchesRegularExpression('/border:\s*(none|0)\b/', $matches[1]);
        $this->assertMatchesRegularExpression('/border-radius:\s*0\b/', $matches[1]);
        $this->assertMatchesRegularExpression('/background:\s*transparent/', $matches[1]);
    }

    public function test_mobile_menu_is_a_stacked_vertical_list_of_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('class="nav-menu"', false);
        $response->assertSeeInOrder(
            ['id="primary-menu"', 'Home', 'About', 'Contact', 'Registration'],
            false
        );

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/@media \(max-width: 767px\).*?\.nav-menu\s*\{[^}]*flex-direction:\s*column/s',
            $html
        );
    }

    public function test_desktop_nav_links_keep_their_pill_styling(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $html = $response->getContent();

        $matches = [];
        $this->assertSame(
            1,
            preg_match('/body\.sg-page \.nav-link\s*\{([^}]*)\}/s', $html, $matches)
        );

        $this->assertStringContainsString('border-radius: 9999px', $matches[1]);
        $this->assertStringContainsString('border: 1px solid', $matches[1]);
    }

    private function mobilePanelLinkRule(string $html): string
    {
        $matches = [];

        if (
            preg_match(
                '/@media \(max-width: 767px\).*?body\.sg-page \.nav-menu \.nav-link\s*\{([^}]*)\}/s',
                $html,
                $matches
            ) === 1
        ) {
            return $matches[1];
        }

        return '';
    }
}
