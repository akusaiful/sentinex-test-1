<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_contact_page_returns_a_successful_response(): void
    {
        $this->get('/contact')->assertStatus(200);
    }

    public function test_contact_page_contains_name_email_and_mobile_fields(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="mobile"', false);
    }

    public function test_contact_form_posts_to_the_store_route(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('action="'.route('contact.store').'"', false);
    }
}
