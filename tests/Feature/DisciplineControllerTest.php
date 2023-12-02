<?php

namespace Tests\Unit;

use App\Models\College;
use App\Models\Discipline;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisciplineControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateDisciplineAndAssociateWithCollege()
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a college to associate with the discipline
        $college = College::factory()->create();

        // Call the method
        $response = $this->post(route('academics.storeDiscipline'), [
            'disciplineName' => 'Computer Science',
            'college_id' => $college->id,
        ]);

        // Assert a new discipline was created
        $this->assertCount(1, Discipline::all());

        // Assert the discipline was associated with the college
        $discipline = Discipline::first();
        $this->assertTrue($college->disciplines->contains($discipline));
    }
}