<?php

namespace Tests\Unit;

use App\Models\College;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollegeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_college_has_many_courses()
    {
        $college = College::factory()->create();
        $courses = Course::factory()->count(3)->create(['college_id' => $college->id]);

        $this->assertEquals(3, $college->courses->count());
        $this->assertInstanceOf(Course::class, $college->courses->first());
    }
}