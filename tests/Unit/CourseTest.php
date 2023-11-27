<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\College;
use App\Models\Subject;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_course_can_be_created()
    {
        $college = College::factory()->create();
        $course = Course::factory()->create(['college_id' => $college->id]);

        $this->assertDatabaseHas('course', ['id' => $course->id]);
    }

    public function test_a_course_belongs_to_a_college()
    {
        $college = College::factory()->create();
        $course = Course::factory()->create(['college_id' => $college->id]);

        $this->assertEquals($college->id, $course->college->id);
    }

    public function test_a_course_has_many_subjects()
    {
        $course = Course::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);

        $this->assertTrue($course->subjects->contains($subject));
    }
}