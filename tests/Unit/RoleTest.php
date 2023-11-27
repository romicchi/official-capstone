<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_role_has_many_users()
    {
        $role = Role::factory()->create();
        $user1 = User::factory()->create(['role_id' => $role->id]);
        $user2 = User::factory()->create(['role_id' => $role->id]);

        $this->assertTrue($role->users->contains($user1));
        $this->assertTrue($role->users->contains($user2));
    }
}