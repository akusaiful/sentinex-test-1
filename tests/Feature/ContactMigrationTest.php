<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ContactMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contacts_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasTable('contacts'));

        foreach (['id', 'name', 'email', 'mobile', 'created_at', 'updated_at'] as $column) {
            $this->assertTrue(
                Schema::hasColumn('contacts', $column),
                "Expected contacts table to have a [{$column}] column."
            );
        }
    }
}
