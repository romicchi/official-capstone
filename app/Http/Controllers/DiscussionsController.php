<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Channel; 
use Illuminate\Support\Str;
use App\Http\Requests\CreateDiscussionRequest;

class DiscussionsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('discussions.index', [
            'discussions' => Discussion::filterByChannels()->paginate(8) //change the pagination for each Channel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discussions.create');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDiscussionRequest $request)
    {
        auth()->user()->discussions()->create([ //discussions meaning user can have many discussions so we i added some public function discussion in User.php
            'title' => $request->title,
            'content' => $request->content,
            'channel_id' => $request->channel,
            'slug' => Str::slug($request->title)
        ]);

        session()->flash('success', 'Discussion posted.');
        return redirect()->route('discussions.index');
    }

    /**
     * Display the specified resource.
     */
    //Note: $discussion is found at the database
    public function show(Discussion $discussion) //default: show(string $id)
    {
        return view('discussions.show', [
            'discussion' => $discussion,
            'userId' => auth()->check() ? auth()->user()->id : null 
        ]);
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
    public function destroy(Discussion $discussion)
    {
        // Check if the authenticated user is the owner of the discussion
        if (auth()->user()->id !== $discussion->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $discussion->delete();

        session()->flash('success', 'Discussion deleted.');
        return redirect()->route('discussions.index');
    }
}
