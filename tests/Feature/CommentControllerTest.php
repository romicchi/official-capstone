<?php

namespace Tests\Unit;

use App\Http\Controllers\CommentController;
use App\Models\Comment;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $request = new Request([
            'comment_text' => 'Test comment',
            'resource_id' => $resource->id,
        ]);

        $this->actingAs($user);

        $controller = new CommentController();

        $response = $controller->store($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'resource_id' => $resource->id,
            'comment_text' => 'Test comment',
        ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);
    
        $this->actingAs($user);
    
        $controller = new CommentController();
    
        $response = $controller->destroy($comment);
    
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}