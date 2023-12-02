<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Resource;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testShowFavorites()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        $user->favorites()->attach($resource->id);

        $response = $this->actingAs($user)->get('/favorites');

        $response->assertStatus(200);
        $response->assertViewHas('resources');
    }

    public function testSearch()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create(['title' => 'Test Resource']);
        $user->favorites()->attach($resource->id);

        $response = $this->actingAs($user)->get('/favorites/search?query=Test');

        $response->assertStatus(200);
        $response->assertViewHas('resources');
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        $user->favorites()->attach($resource->id);

        $response = $this->actingAs($user)->delete("/favorites/{$resource->id}");

        $response->assertRedirect('/favorites');
        $this->assertDatabaseMissing('favorites', ['resource_id' => $resource->id, 'user_id' => $user->id]);
    }

    public function testClear()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        $user->favorites()->attach($resource->id);
    
        $response = $this->actingAs($user)->post('/favorites/clear');
    
        $response->assertRedirect('/favorites');
        $this->assertDatabaseMissing('favorites', ['resource_id' => $resource->id, 'user_id' => $user->id]);
    }
}