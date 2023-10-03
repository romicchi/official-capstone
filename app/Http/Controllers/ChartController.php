<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resource;
use App\Models\Discussion;

class ChartController extends Controller
{
    public function showDashboard()
    {
        // Retrieve the top 10 most favorite resources
        $mostFavoriteResources = Resource::withCount('favoritedBy') // Use 'favoritedBy' instead of 'favorites'
        ->orderBy('favorited_by_count', 'desc') // Use 'favorited_by_count' instead of 'favorites_count'
        ->take(10) // You can change this number as needed
        ->get();
        
        // Retrieve the top 10 most replied discussion
        $mostRepliedDiscussions = Discussion::withCount('replies')
        ->orderBy('replies_count', 'desc')
        ->take(10)
        ->get();

        $studentsCount = User::where('role_id', 1)->count();
        $teachersCount = User::where('role_id', 2)->count();
        return view('dashboard', compact('studentsCount','teachersCount','mostFavoriteResources','mostRepliedDiscussions'));
    }
}
