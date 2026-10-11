<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_registration_creates_a_pending_user_with_a_hashed_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertRedirect(route('register.success'));

        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'status' => 'pending',
        ]);

        $user = User::where('email', 'jane@example.com')->firstOrFail();

        $this->assertNotSame('secret-password', $user->password);
        $this->assertTrue(Hash::check('secret-password', $user->password));
        $this->assertFalse($user->is_admin);
    }

    public function test_registration_requires_a_name(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'jane@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_requires_a_valid_email(): void
    {
        $missing = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => '',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $missing->assertSessionHasErrors('email');

        $invalid = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'not-an-email',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $invalid->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_requires_a_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_requires_a_matching_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_a_duplicate_email(): void
    {
        User::factory()->create(['email' => 'jane@example.com']);

        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 1);
    }
}
