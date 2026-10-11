<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_has_status_and_is_admin_columns(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'status'));
        $this->assertTrue(Schema::hasColumn('users', 'is_admin'));
    }

    public function test_new_users_default_to_pending_and_not_admin(): void
    {
        $user = User::factory()->create();
        $user->refresh();

        $this->assertSame('pending', $user->status);
        $this->assertFalse($user->is_admin);
    }

    public function test_seeded_user_is_an_approved_admin(): void
    {
        $this->seed();

        $admin = User::where('email', 'test@example.com')->firstOrFail();

        $this->assertSame('Test User', $admin->name);
        $this->assertSame('approved', $admin->status);
        $this->assertTrue($admin->is_admin);
    }
}
