<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\College;
use App\Models\Discipline;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_role_3_can_view_disciplines_page()
    {
        // Arrange
        $user = User::factory()->create(['role_id' => 3]);
        $college = College::factory()->create();
        $discipline = Discipline::factory()->create(['college_id' => $college->id]);

        // Act
        $response = $this->actingAs($user)->get("/disciplines/{$college->id}/{$discipline->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('disciplines.disciplines'); // replace 'disciplines' with the actual view name
    }
}