<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Discussion;
use App\Models\Channel;
use App\Models\Course;
use Database\Factories\DiscussionFactory;
use Database\Factories\CourseFactory;
use Database\Factories\ChannelFactory;
use Illuminate\Foundation\Testing\WithFaker;

class DiscussionsControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function teststore(): void
    {
        // Arrange
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        $course = Course::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => 'Test Discussion',
            'content' => 'This is a test discussion.',
            'channel' => $channel->id,
            'course' => $course->id,
        ];

        // Act
        $response = $this->post(route('discussions.store'), $data);

        // Assert
        $response->assertRedirect(route('discussions.index'));
        $this->assertDatabaseHas('discussions', [
            'title' => $data['title'],
            'content' => $data['content'],
            'channel_id' => $data['channel'],
            'course_id' => $data['course'],
            'user_id' => $user->id,
        ]);
    }

    public function testupdate(): void
    {
        // Arrange
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $user->id, 'channel_id' => $channel->id]);
        $this->actingAs($user);
    
        $updatedData = [
            'title' => 'Updated title',
            'content' => 'Updated content',
        ];
    
        // Act
        $response = $this->patch(route('discussions.update', $discussion->id), $updatedData);
    
        // Assert
        $response->assertRedirect(route('discussions.show', $discussion->fresh()->slug));
        $this->assertEquals($updatedData['title'], $discussion->fresh()->title);
        $this->assertEquals($updatedData['content'], $discussion->fresh()->content);
    }
    
    public function testdestroy(): void
    {
        // Arrange
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $user->id, 'channel_id' => $channel->id]);
        $this->actingAs($user);
    
        // Act
        $response = $this->delete(route('discussions.destroy', $discussion));
    
        // Assert
        $response->assertRedirect(route('discussions.index'));
        $this->assertDatabaseMissing('discussions', ['id' => $discussion->id]);
    }

}
