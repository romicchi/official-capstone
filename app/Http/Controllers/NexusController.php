<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NexusController extends Controller
{
    public function index()
    {
        $resources = Resource::with('college', 'course', 'subject', 'discipline')->get();
        return view('nexus', compact('resources'));
    }


    public function search(Request $request)
    {
        try {
            $keywords = $request->input('keywords');

            // Search by title
            $titleResults = Resource::where('title', 'like', "%$keywords%")->get();

            // Search by keyword
            $keywordResults = Resource::where('keywords', 'like', "%$keywords%")->get();

            // Combine and return the results
            $combinedResults = $titleResults->merge($keywordResults);

            return response()->json($combinedResults);
        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during the search.']);
        }
    }

    public function fetch(Request $request)
    {
        try {
            $title = $request->get('title');
    
            // Fetch the data from the database
            $data = DB::table('resources')->where('title', $title)->first();
    
            // If no data was found, return an error message
            if (!$data) {
                return response()->json(['error' => 'No data found for title ' . $title], 404);
            }
    
            // Return the data as JSON
            return response()->json($data);
        } catch (\Exception $e) {
            // Return the error message as JSON
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}