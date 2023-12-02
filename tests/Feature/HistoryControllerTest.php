<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Resource;
use App\Models\History;

class HistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        History::create(['user_id' => $user->id, 'resource_id' => $resource->id]);

        $response = $this->actingAs($user)->get('/history');

        $response->assertStatus(200);
        $response->assertViewHas('resources');
    }

    public function testSearch()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create(['title' => 'Test Resource']);
        History::create(['user_id' => $user->id, 'resource_id' => $resource->id]);

        $response = $this->actingAs($user)->get('/history/search?query=Test');

        $response->assertStatus(200);
        $response->assertViewHas('resources');
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        History::create(['user_id' => $user->id, 'resource_id' => $resource->id]);

        $response = $this->actingAs($user)->delete("/history/{$resource->id}");

        $response->assertRedirect('/history');
        $this->assertDatabaseMissing('history', ['resource_id' => $resource->id, 'user_id' => $user->id]);
    }

    public function testClear()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        History::create(['user_id' => $user->id, 'resource_id' => $resource->id]);

        $response = $this->actingAs($user)->post('/history/clear');

        $response->assertRedirect('/history');
        $this->assertDatabaseMissing('history', ['resource_id' => $resource->id, 'user_id' => $user->id]);
    }
}