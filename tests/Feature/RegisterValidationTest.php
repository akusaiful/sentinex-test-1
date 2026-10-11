<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterValidationTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ], $overrides);
    }

    public function test_name_is_required(): void
    {
        $response = $this->post('/register', $this->validPayload(['name' => '']));

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_email_must_be_valid(): void
    {
        $response = $this->post('/register', $this->validPayload(['email' => 'not-an-email']));

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->post('/register', $this->validPayload(['email' => 'taken@example.com']));

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_password_must_be_at_least_eight_characters(): void
    {
        $response = $this->post('/register', $this->validPayload([
            'password' => 'short',
            'password_confirmation' => 'short',
        ]));

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_password_confirmation_must_match(): void
    {
        $response = $this->post('/register', $this->validPayload([
            'password' => 'secret-password',
            'password_confirmation' => 'different-password',
        ]));

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_validation_errors_are_displayed_on_the_form(): void
    {
        $response = $this->from(route('register'))
            ->followingRedirects()
            ->post('/register', $this->validPayload([
                'name' => '',
                'email' => 'not-an-email',
                'password' => 'short',
                'password_confirmation' => 'mismatch',
            ]));

        $response->assertStatus(200);
        $response->assertSee('class="error"', false);
    }
}
