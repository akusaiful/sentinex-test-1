<?php

namespace Tests\Unit;

use App\Models\Contact;
use Tests\TestCase;

class ContactFactoryTest extends TestCase
{
    public function test_factory_produces_valid_contact_data(): void
    {
        $contact = Contact::factory()->make();

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertNotEmpty($contact->name);
        $this->assertNotEmpty($contact->email);
        $this->assertNotEmpty($contact->mobile);
        $this->assertTrue(filter_var($contact->email, FILTER_VALIDATE_EMAIL) !== false);
    }
}
