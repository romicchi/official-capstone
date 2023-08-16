<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Channel; 
use App\Models\Course;
use Illuminate\Support\Str;
use App\Http\Requests\CreateDiscussionRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


class DiscussionsController extends Controller
{


    // public function __construct()
    // {
    //     $this->middleware('auth')->only(['create', 'store']);
    // }

    /**
     * Display a listing of the resource.
     */

    public function getCoursesByChannel(Request $request, $channel)
    {
        $channel = Channel::findOrFail($channel);
        $courses = Course::where('college_id', $channel->id)->get();
        return response()->json($courses);
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap();
    
        $query = Discussion::query();

        // Eager load author and course relationships
        $query->with(['author', 'course']);
    
        // Filter by channel
        $channelSlug = $request->query('channel');
        if ($channelSlug) {
            $channel = Channel::where('slug', $channelSlug)->firstOrFail();
            $query->where('channel_id', $channel->id);
        }
    
        // Filter by course
        $courseId = $request->query('course');
        if ($courseId) {
            $query->where('course_id', $courseId);
        }
    
        // Sort discussions
        $sort = $request->query('sort');
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // Default to newest
        }
    
        $discussions = $query->paginate(10);
        $discussions->appends($request->query());
    
        return view('discussions.index', [
            'discussions' => $discussions
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
        $slug = Str::slug($request->title); // Generate a unique slug based on the title

        // Check if the generated slug is already in use and append a number to make it unique
        $count = 1;
        while (Discussion::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->title) . '-' . $count;
            $count++;
        }

        auth()->user()->discussions()->create([ //discussions meaning user can have many discussions so we i added some public function discussion in User.php
            'title' => $request->title,
            'content' => $request->content,
            'channel_id' => $request->channel,
            'course_id' => $request->course,
            'slug' => $slug,
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
        $replies = $discussion->replies()->paginate(3); // Fetch replies and paginate

        return view('discussions.show', [
            'discussion' => $discussion,
            'replies' => $replies, // Pass the paginated replies to the view

            'userId' => auth()->check() ? auth()->user()->id : null 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        $channels = Channel::all();
        
        return view('discussions.edit', compact('discussion', 'channels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $discussion = Discussion::findOrFail($id);
    
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        // Only update the slug if the title has changed
        if ($discussion->title !== $validatedData['title']) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
    
            // Checks if the generated slug is already in use and append a number to make it unique
            $count = 1;
            while (Discussion::where('slug', $validatedData['slug'])->exists()) {
                $validatedData['slug'] = Str::slug($validatedData['title']) . '-' . $count;
                $count++;
            }
        }
    
        // Update the discussion with the validated data
        $discussion->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'slug' => $validatedData['slug'] ?? $discussion->slug, // Use the existing slug if not generated a new one
        ]);
    
        // Redirect to the discussion's show page or any other appropriate page
        return redirect()->route('discussions.show', $discussion->slug)->with('success', 'Discussion updated successfully.');
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
