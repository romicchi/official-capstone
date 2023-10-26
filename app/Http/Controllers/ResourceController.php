<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Discipline;
use App\Models\History;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceRating;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use Session;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDriveService;


class ResourceController extends Controller
{
    private static function getGoogleDriveAccessToken()
    {
        $jsonKeyFilePath = base_path('resources/credentials/generapp-c64fbc26723c.json'); // Replace with the path to your JSON key file
        $jsonKey = file_get_contents($jsonKeyFilePath);

        $googleClient = new GoogleClient();
        $googleClient->setAuthConfig(json_decode($jsonKey, true));
        $googleClient->setScopes([\Google_Service_Drive::DRIVE]);
        $googleClient->fetchAccessTokenWithAssertion();

        return $googleClient->getAccessToken()['access_token'];
    }

    //--------------TEACHER-----------------//
    public function showTeacherManage()
    {
        $resources = Resource::paginate(10);
    
        return view('teacher.teachermanage', compact('resources'));
    }

    public function getDisciplinesByCollege($collegeId)
    {
        $disciplines = Discipline::where('college_id', $collegeId)->get();

        return response()->json($disciplines);
    }
    
    public function getCoursesByCollege($collegeId)
    {
        $courses = Course::where('college_id', $collegeId)->get();
    
        return response()->json($courses);
    }

    public function getSubjectsByCourse($courseId)
    {
        $subjects = Subject::where('course_id', $courseId)->get();

        return response()->json($subjects);
    }

    // Store resource function for Teacher
    public function storeResource(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,avi,docx,pdf,pptx|max:25600',
            'title' => 'required',
            'topic' => 'required',
            'keywords' => 'required',
            'author' => 'required',
            'description' => 'required',
            'college' => 'required',
            'discipline' => 'required',
        ]);

        // Upload the file to Google Drive
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;

        // Set access token for the Google client
        $googleClient = new GoogleClient();
        $googleClient->setAccessToken(self::getGoogleDriveAccessToken());

        // Initialize the Google Drive service
        $googleDrive = new GoogleDriveService($googleClient);

        // File metadata
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $filename,
            'parents' => ['1rB94wMkHFoUvZbkTUC8TqHJEWGCMBS2U'], // Replace with the folder ID where you want to upload the file
        ]);

        // Upload the file and get the file ID
        $uploadedFile = $googleDrive->files->create($fileMetadata, [
            'data' => file_get_contents($file->getPathname()),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink',
        ]);

        // Get the file URL from the file ID
        $fileUrl = 'https://drive.google.com/uc?id=' . $uploadedFile->id;

        // Create a new resource instance
        $resource = new Resource();
        $resource->title = $validatedData['title'];
        $resource->topic = $validatedData['topic'];
        $resource->keywords = $validatedData['keywords'];
        $resource->author = $validatedData['author'];
        $resource->description = $validatedData['description'];
        $resource->url = $fileUrl;
        $resource->college_id = $validatedData['college'];
        $resource->discipline_id = $validatedData['discipline'];
        $resource->save();

        // Redirect or perform additional actions as needed
        return redirect()->back()->with('success', 'Resource added successfully.');
    }


        /**
     * Delete the file and its metadata.
     *
     * @param  int  $resource
     * @return \Illuminate\Http\Response
     */
    // Delete resource function
    public function destroy($resource)
    {
        $resource = Resource::findOrFail($resource);
    
        // Extract the file ID from the Google Drive URL
        $urlParts = parse_url($resource->url);
        parse_str($urlParts['query'], $queryParameters);
        $fileId = $queryParameters['id'];
    
          // Set access token for the Google client
         $googleClient = new GoogleClient();
         $googleClient->setAccessToken(self::getGoogleDriveAccessToken());

         // Initialize the Google Drive service
         $googleDrive = new GoogleDriveService($googleClient);
    
        try {
            // Delete the file from Google Drive
            $googleDrive->files->delete($fileId);
        } catch (\Exception $e) {
            // Handle any errors that occur during file deletion from Google Drive
            return redirect()->back()->with('error', 'Failed to delete the file from Google Drive.');
        }
    
        // Delete the resource from the database
        $resource->delete();
    
        return redirect()->back()->with('success', 'Resource deleted successfully.');
    }

    // Edit resource function
    public function edit(Resource $resource)
    {    
        $resources = Resource::all();
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
        return view('teacher.edit', compact('resource', 'colleges', 'courses', 'subjects'));
    }

    // Update resource function
    public function update(Request $request, Resource $resource)
    {
        $resource->update($request->all());

        return redirect()->route('teacher.manage')->with('success', 'Resource updated successfully.');
    }

     //--------------ADMIN-----------------//
    public function showAdminResourceManage()
    {
        $resources = Resource::paginate(10);
    
        return view('administrator.adminresourcemanage', compact('resources'));
    }

    public function adminsearchResources(Request $request)
    {
        $query = $request->input('query');

        $resources = Resource::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('author', 'LIKE', '%' . $query . '%')
                ->orWhere('created_at', 'LIKE', '%' . $query . '%');
        })
        ->orWhereHas('subject', function ($queryBuilder) use ($query) {
            $queryBuilder->where('subjectName', 'LIKE', '%' . $query . '%');
        })
        ->paginate(10);

        return view('administrator.adminresourcemanage', compact('resources'));
    }

    //---------Subject Resources----------//
    public function subjects(Request $request)
    {
        $courseId = $request->query('course_id');
        $course = Course::findOrFail($courseId);
        $subjects = $course->subjects;

        return view('subjects.subjects', compact('subjects', 'course'));
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
    
    // Function to map file extensions to MIME types
    private function getMimeTypeByExtension($extension) 
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream'; // Default to binary stream
    }

    public function toggleFavorite(Request $request)
    {
        $resourceId = $request->input('resourceId');
        $user = auth()->user();
        $resource = Resource::find($resourceId);
    
        if (!$resource) {
            return response()->json(['error' => 'Resource not found']);
        }
    
        if ($user->favorites->contains($resource)) {
            // User has already favorited this resource, remove it from favorites
            $user->favorites()->detach($resource);
            $isFavorite = false;
        } else {
            // User is adding this resource to favorites
            $user->favorites()->attach($resource);
            $isFavorite = true;
        }
    
        // Return the updated favorite status
        return response()->json(['isFavorite' => $isFavorite]);
    }
    
    // display the selected resources/subject
    public function show(Resource $resource, Request $request)
    {
        // Record the resource view in the history
        $user = auth()->user();

        // Check if the user has already viewed this resource to prevent duplicate entries
        if (!$user->history->contains('resource_id', $resource->id)) {
            $user->history()->create(['resource_id' => $resource->id]);
        }

        $resource->increment('view_count');

        $comments = $resource->comments()->latest()->paginate(7);

        if ($request->ajax()) {
            return view('subjects.comment', compact('comments', 'resource'));
        }

        return view('subjects.show', compact('comments', 'resource'));
    }

    public function disciplines(Request $request, $college_id, $discipline_id)
    {
        $college = College::findOrFail($college_id);
        $discipline = Discipline::findOrFail($discipline_id);
        $resources = $discipline->resources;

        return view('disciplines.disciplines', compact('discipline', 'college', 'resources'));
    }

    public function rate(Request $request)
    {
        $resourceId = $request->input('resourceId');
        $rating = $request->input('rating');
        $user = auth()->user();
    
        // Check if the user has already rated this resource, if yes, update the rating, otherwise create a new rating
        $user->resourceRatings()->updateOrCreate(
            ['resource_id' => $resourceId],
            ['rating' => $rating]
        );
    
        return response()->json(['success' => true]);
    }

    public function trackDownload(Request $request)
    {
        $resourceId = $request->input('resourceId');
        $resource = Resource::find($resourceId);

        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        // Increment the download count
        $resource->increment('download_count');

        return response()->json(['message' => 'Download counted successfully']);
    }

    // search resource in disciplines.discipline based on selected discipline
    public function searchDisciplineResources(Request $request, $college_id, $discipline_id)
    {
        $query = $request->input('query');
    
        $college = College::findOrFail($college_id);
        $discipline = Discipline::findOrFail($discipline_id);
    
        $resources = $discipline->resources()
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->orWhere('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('author', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%'); // Add additional columns if needed
            })
            ->paginate(10);
    
        return view('disciplines.disciplines', compact('discipline', 'college', 'resources'));
    }
    
}
