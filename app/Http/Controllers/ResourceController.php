<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
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
        'course' => 'required',
        'subject' => 'required',
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
    $resource->course_id = $validatedData['course'];
    $resource->subject_id = $validatedData['subject'];
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

    //---------DEPARTMENTCHAIR-PROGCOORDINATOR-ADMIN----------------//
    public function showResourceManage(Request $request)
    {
        $resources = Resource::paginate(10);
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('resourcemanage', compact('resources', 'colleges', 'courses', 'subjects'));
    }
    
    public function searchResources(Request $request)
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

        return view('resourcemanage', compact('resources'));
    }

     //--------------ADMIN-----------------//
    public function showAdminResourceManage()
    {
        $resources = Resource::paginate(10);
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('administrator.adminresourcemanage', compact('resources', 'colleges', 'courses', 'subjects'));
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
    public function showEmbed(Request $request, $id)
    {
        // Retrieve the resource based on the given ID
        $resource = Resource::find($id);
    
        // Pass the resource to the 'embed' view
        return view('embed', compact('resource'));
    }

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
        return response()->download(public_path($resource->url));
    }

    public function show(Resource $resource)
    {
        return view('subjects.show', compact('resource'));
    }

}



