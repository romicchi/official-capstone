<?php

namespace Tests\Unit;

use App\Http\Controllers\ChartController;
use App\Models\Discussion;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ChartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowDashboard()
    {
        // Create some resources and discussions
        $resources = Resource::factory()->count(15)->create();
        $discussions = Discussion::factory()->count(15)->create();
    
        // Make some users favorite some resources and reply to some discussions
        $users = User::factory()->count(5)->create();
        foreach ($users as $user) {
            foreach ($resources->random(rand(1, 10)) as $resource) {
                $user->favorites()->save($resource);
            }
            foreach ($discussions->random(rand(1, 10)) as $discussion) {
                $user->replies()->save($discussion);
            }
        }
    
        // Authenticate a user
        $this->actingAs($users->first());
    
        $response = $this->get('/dashboard'); // Replace '/dashboard' with the actual route to the showDashboard method
    
        $response->assertStatus(200);
        $response->assertViewIs('dashboard'); // Replace 'dashboard' with the actual view name returned by the showDashboard method
        $response->assertViewHas('mostFavoriteResources');
        $response->assertViewHas('mostRepliedDiscussions');
    }
}