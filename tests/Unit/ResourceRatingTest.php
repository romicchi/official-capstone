<?php

namespace Tests\Unit;

use App\Models\Resource;
use App\Models\ResourceRating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceRatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_resource_rating_belongs_to_a_user_and_a_resource()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        $resourceRating = ResourceRating::factory()->create([
            'user_id' => $user->id,
            'resource_id' => $resource->id,
        ]);

        $this->assertEquals($user->id, $resourceRating->user->id);
        $this->assertEquals($resource->id, $resourceRating->resource->id);
    }
}