<?php

namespace Tests\Unit;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_resource_can_be_favorited_by_a_user()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        // The user favorites the resource
        $resource->favoritedBy()->attach($user->id);

        // Assert the resource is in the user's favorites
        $this->assertTrue($resource->favoritedBy->contains($user));
    }
}