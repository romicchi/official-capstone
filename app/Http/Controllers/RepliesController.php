<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateReplyRequest;
use App\Models\Discussion;
use App\Models\Reply;
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
    public function store(CreateReplyRequest $request, Discussion $discussion) //default: store(Request $request)
    {
        auth()->user()->replies()->create([
            'content' => $request->content,
            'discussion_id' => $discussion->id
        ]);

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
