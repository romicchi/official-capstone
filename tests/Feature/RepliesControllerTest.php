<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\RepliesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Mockery;
use App\Http\Requests\CreateReplyRequest;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class RepliesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

     public function testStore()
     {
         $user = User::factory()->create();
         $discussion = Discussion::factory()->forAuthor($user)->create();
         $reply = Reply::factory()->make();
             // Notify the author of the discussion that a new reply has been added
            NotificationFacade::fake();
     
         $response = $this->actingAs($user)->post(route('replies.store', $discussion), $reply->toArray());
     
         $response->assertRedirect();
         $this->assertDatabaseHas('replies', ['content' => $reply->content]);
     }
}
