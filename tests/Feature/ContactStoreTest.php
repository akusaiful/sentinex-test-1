<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_submission_stores_contact_and_redirects_with_success_flash(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);

        $response->assertRedirect(route('contact.create'));
        $response->assertSessionHas('status');

        $this->assertDatabaseCount('contacts', 1);
        $this->assertDatabaseHas('contacts', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);
    }

    public function test_success_flash_is_shown_on_the_redirected_page(): void
    {
        $response = $this->followingRedirects()->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Thanks! Your details have been received.');
    }

    public function test_name_is_required(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_email_is_required_and_must_be_valid(): void
    {
        $missing = $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => '',
            'mobile' => '0123456789',
        ]);

        $missing->assertSessionHasErrors('email');

        $invalid = $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'not-an-email',
            'mobile' => '0123456789',
        ]);

        $invalid->assertSessionHasErrors('email');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_mobile_is_required(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '',
        ]);

        $response->assertSessionHasErrors('mobile');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_validation_errors_are_displayed_on_the_form(): void
    {
        $response = $this->from(route('contact.create'))
            ->followingRedirects()
            ->post('/contact', [
                'name' => '',
                'email' => 'not-an-email',
                'mobile' => '',
            ]);

        $response->assertStatus(200);
        $response->assertSee('class="error"', false);
    }

    public function test_valid_submission_returns_a_contact_instance(): void
    {
        $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);

        $contact = Contact::first();

        $this->assertSame('Jane Doe', $contact->name);
        $this->assertSame('jane@example.com', $contact->email);
        $this->assertSame('0123456789', $contact->mobile);
    }
}
