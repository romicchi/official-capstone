<?php

namespace Tests\Unit;

use App\Models\Discussion;
use App\Models\User;
use App\Models\Course;
use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscussionTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_discussion_belongs_to_a_user_and_a_course_and_has_many_replies()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
        $reply1 = Reply::factory()->create(['discussion_id' => $discussion->id]);
        $reply2 = Reply::factory()->create(['discussion_id' => $discussion->id]);

        $this->assertEquals($user->id, $discussion->author->id);
        $this->assertEquals($course->id, $discussion->course->id);
        $this->assertTrue($discussion->replies->contains($reply1));
        $this->assertTrue($discussion->replies->contains($reply2));
    }
}