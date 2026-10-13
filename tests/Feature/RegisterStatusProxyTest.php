<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterStatusProxyTest extends TestCase
{
    public function test_status_form_action_uses_https_when_the_proxy_forwards_https(): void
    {
        $response = $this
            ->withHeaders(['X-Forwarded-Proto' => 'https'])
            ->get('/register/status');

        $response->assertStatus(200);
        $response->assertSee('action="https://', false);
        $response->assertDontSee('action="http://', false);
    }

    public function test_url_generation_is_https_when_the_proxy_forwards_https(): void
    {
        $pending = $this->withHeaders(['X-Forwarded-Proto' => 'https'])->get('/register/status');

        $pending->assertStatus(200);

        preg_match('/href="([^"]+)"[^>]*class="sg-link"/', $pending->getContent(), $matches);

        $this->assertNotEmpty($matches, 'Expected the home link to be rendered.');
        $this->assertStringStartsWith('https://', $matches[1]);
    }
}
