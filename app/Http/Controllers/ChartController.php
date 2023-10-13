<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function showDashboard(Request $request)
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

    public function getRecommendations(Request $request)
    {
        $query = $request->input('query');
    
        // Define a list of stopwords (common words to be removed)
        $stopwords = ['what', 'is', 'the', 'and', 'or', 'of', 'in', 'to'];
    
        // Explode the query into individual words, remove stopwords, and make the remaining words unique
        $keywords = array_unique(array_diff(explode(' ', strtolower($query)), $stopwords));

        // Initialize $resources with an empty array
        $resources = [];
    
        // Use a raw SQL query to search for resources based on keywords
        $resources = Resource::where(function ($queryBuilder) use ($keywords) {
            foreach ($keywords as $keyword) {
                $queryBuilder->orWhereRaw("LOWER(topic) LIKE '%$keyword%'")
                             ->orWhereRaw("LOWER(title) LIKE '%$keyword%'")
                             ->orWhereRaw("LOWER(keywords) LIKE '%$keyword%'");
            }
        })->select('title', 'url', 'author', 'topic', 'keywords', 'description')
          ->paginate(5);
    
        return view('recommendations', compact('resources'));
    }    

}