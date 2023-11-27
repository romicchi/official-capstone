<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_subject_belongs_to_a_course()
    {
        $course = Course::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);

        $this->assertEquals($course->id, $subject->course->id);
    }
}