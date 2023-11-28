<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateReplyRequest;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateReplyRequest $request, Discussion $discussion)
    {
        $reply = auth()->user()->replies()->create([
            'content' => $request->content,
            'discussion_id' => $discussion->id
        ]);
    
        // Retrieve the discussion again to ensure we get the updated attributes
        $discussion = Discussion::find($discussion->id);
    
        // Check if the discussion owner is different from the current user
        if ($discussion->user_id !== auth()->id()) {
            // Get the discussion's slug
            $discussionSlug = $discussion->slug;
    
            // Create a notification for the discussion owner and store the discussion slug and ID
            $notification = new Notification();
            $notification->user_id = $discussion->user_id;
            $notification->message = 'Someone commented on your discussion: ' . $discussion->title;
            $notification->discussion_id = $discussion->id;
            $notification->discussion_slug = $discussionSlug;
            $notification->save();
        }
    
        session()->flash('success', 'Replied to discussion.');
        return redirect()->back();
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion, Reply $reply)
    {
        if (Auth::user()->id === $reply->owner->id) {
            $reply->delete();
            session()->flash('success', 'Reply deleted successfully.');
        } else {
            session()->flash('error', 'You are not authorized to delete this reply.');
        }

        return redirect()->back();
    }
}
