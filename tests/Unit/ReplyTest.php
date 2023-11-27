<?php

namespace Tests\Unit;

use App\Models\Discussion;
use App\Models\User;
use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_reply_belongs_to_a_user_and_a_discussion()
    {
        $user = User::factory()->create();
        $discussion = Discussion::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $user->id, 'discussion_id' => $discussion->id]);

        $this->assertEquals($user->id, $reply->owner->id);
        $this->assertEquals($discussion->id, $reply->discussion->id);
    }
}