<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserApprovalMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_has_an_is_approved_column(): void
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasColumn('users', 'is_approved'));
    }

    public function test_is_approved_defaults_to_false(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->fresh()->is_approved);
    }
}
