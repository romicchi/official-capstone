<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Resource;
use App\Models\College;
use App\Models\Discpline;
use App\Models\User;
use App\Models\History;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ResourceController;
use openai;

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

    public function ask(Request $request)
    {
        $question = $request->input('query');

        // Define your Flask application URL
        $flaskUrl = 'http://127.0.0.1:8080/ask'; // Adjust the URL as needed

        $response = Http::post($flaskUrl, ['query' => $question]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to communicate with the chatbot'], 500);
        }
    }
    
    public function getRecommendations(Request $request)
{
    $query = $request->input('query');
    $resourceId = $request->input('resourceId'); // Capture the resource ID

    // Define a list of stopwords (common words to be removed)
    $stopwords = ['what', 'is', 'the', 'and', 'or', 'of', 'in', 'to'];

    // Explode the query into individual words, remove stopwords, and make the remaining words unique
    $keywords = array_unique(array_diff(explode(' ', strtolower($query)), $stopwords));

    // Use a raw SQL query to search for resources based on keywords and the captured resource ID
    $resources = Resource::where(function ($queryBuilder) use ($keywords, $resourceId) {
        // Use WHERE IN for a more concise query
        $queryBuilder->whereIn('id', function ($subquery) use ($keywords) {
            $subquery->select('id')
                ->from('resources')
                ->whereRaw("LOWER(CONCAT(',', TRIM(keywords), ',')) LIKE ?", ['%,' . implode(',%', $keywords) . ',%'])
                ->orWhere(function ($orWhere) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $orWhere->orWhereRaw("LOWER(title) LIKE ?", ["%$keyword%"])
                            ->orWhereRaw("LOWER(keywords) LIKE ?", ["%$keyword%"]);
                    }
                });
        });

        // Add a condition to filter by the captured resource ID
        $queryBuilder->orWhere('id', $resourceId);
    })->select('id', 'title', 'url', 'author', 'topic', 'keywords', 'description', 'college_id', 'discipline_id')
        ->paginate(5);

    return view('recommendations', compact('resources'));
}

    public function resources(Request $request)
    {
        $subjectId = $request->query('subject_id');
        $subject = Subject::findOrFail($subjectId);
        $resources = $subject->resources;
    
        return view('subjects.resources', compact('resources', 'subject'));
    }

    public function download(Resource $resource) 
    {
        // Extract the file ID from the Google Drive URL
        $urlParts = parse_url($resource->url);
        parse_str($urlParts['query'], $queryParameters);
        $fileId = $queryParameters['id'];
    
        try {
            // Set access token for the Google client
            $googleClient = new GoogleClient();
            $googleClient->setAccessToken(self::getGoogleDriveAccessToken());
    
            // Initialize the Google Drive service
            $googleDrive = new GoogleDriveService($googleClient);
    
            // Get the file from Google Drive
            $file = $googleDrive->files->get($fileId, ['alt' => 'media']);
    
            // Determine the MIME type based on the file extension
            $fileExtension = pathinfo($resource->url, PATHINFO_EXTENSION);
            $fileMimeType = $this->getMimeTypeByExtension($fileExtension);
    
            // Get the file contents
            $fileContents = $file->getBody()->getContents();
    
            // Create a new Laravel HTTP response and set the file contents
            $response = new \Illuminate\Http\Response($fileContents);
    
            // Set the appropriate content type and disposition for download
            $response->header('Content-Type', $fileMimeType);
            $response->header('Content-Disposition', 'attachment; filename="' . $resource->title . '.' . $fileExtension . '"');
    
            // Return the response
            return $response;
        } catch (\Exception $e) {
            // Handle any errors that occur during file retrieval from Google Drive
            return redirect()->back()->with('error', 'Failed to download the file: ' . $e->getMessage());
        }
    } 

}