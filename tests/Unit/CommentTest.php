<?php

namespace Tests\Unit;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_comment_can_be_created()
    {
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }
}