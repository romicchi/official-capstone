<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Attempt to get the dashboard page as an authenticated user
        $response = $this->actingAs($user)->get('/dashboard');

        // Assert: The response status should be 200
        $response->assertStatus(200);
    }
}