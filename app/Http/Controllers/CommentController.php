<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'comment_text' => 'required|string',
            'resource_id' => 'required|exists:resources,id',
        ]);
    
        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'resource_id' => $validatedData['resource_id'],
            'comment_text' => $validatedData['comment_text'],
        ]);
    
        return redirect()->back()->with('success', 'Comment added successfully.');
    }
    
    public function destroy(Comment $comment)
    {
        if (auth()->user()->id !== $comment->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }
    
        $comment->delete();
    
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
