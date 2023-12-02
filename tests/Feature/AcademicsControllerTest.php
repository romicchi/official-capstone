<?php

namespace Tests\Unit;

use App\Models\College;
use App\Models\Course;
use App\Models\Discipline;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AcademicsControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
    
        // Create and authenticate a user
        $user = User::factory()->withoutCollege()->create();
        $this->actingAs($user);
    }
    protected function tearDown(): void
    {
        College::query()->delete();

        parent::tearDown();
    }

    public function testCreateCollege()
    {
        $response = $this->get(route('academics.createCollege'));
        $response->assertStatus(200);
    }

    public function testStoreCollege()
    {
        $response = $this->post(route('academics.storeCollege'), ['collegeName' => 'Test College']);
        $response->assertRedirect(route('academics.index'));
    
        $this->assertCount(1, College::all());
    }

    // Repeat similar tests for editCollege, updateCollege, destroyCollege

    public function testCreateCourse()
    {
        $response = $this->get(route('academics.createCourse'));
        $response->assertStatus(200);
    }

    public function testStoreCourse()
    {
        $college = College::factory()->create();
        $response = $this->post(route('academics.storeCourse'), ['courseName' => 'Test Course', 'college_id' => $college->id]);
        $response->assertRedirect(route('academics.index', ['activeTab' => 'courses']));
        $this->assertCount(1, Course::all());
    }

    // Repeat similar tests for editCourse, updateCourse, destroyCourse

    public function testCreateDiscipline()
    {
        $response = $this->get(route('academics.createDiscipline'));
        $response->assertStatus(200);
    }

    public function testStoreDiscipline()
    {
        $college = College::factory()->create();
        $response = $this->post(route('academics.storeDiscipline'), ['disciplineName' => 'Test Discipline', 'college_id' => $college->id]);
        $response->assertRedirect(route('academics.index', ['activeTab' => 'disciplines']));
        $this->assertCount(1, Discipline::all());
    }

    // Repeat similar tests for editDiscipline, updateDiscipline, destroyDiscipline
}