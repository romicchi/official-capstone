<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class UsernavController extends Controller
{

    public function usernav() {
        // Check if the user has seen the guide before
        if (auth()->user()->seen_guide === 0) {
            // Display the guide to the user
            auth()->user()->update(['seen_guide' => 1]);
            return view('dashboard')->with('showGuide', true);
        }
    }

    public function updateSeenGuide()
    {
        // Update the seen_guide flag for the authenticated user
        auth()->user()->update(['seen_guide' => 1]);
        
        return response()->json(['success' => true]);
    }
  
}
