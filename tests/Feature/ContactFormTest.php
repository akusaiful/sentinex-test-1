<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_page_returns_a_successful_response(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact');
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="mobile"', false);
    }

    public function test_home_page_has_a_button_linking_to_the_contact_form(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('contact.create'), false);
    }

    public function test_about_page_has_a_button_linking_to_the_contact_form(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee(route('contact.create'), false);
    }

    public function test_contact_form_submission_stores_a_contact(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);

        $response->assertRedirect(route('contact.create'));
        $this->assertDatabaseHas('contacts', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0123456789',
        ]);
    }
}
