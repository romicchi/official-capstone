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
use Spatie\PdfToText\Pdf;


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
        $resources = Resource::where('author', auth()->user()->firstname . ' ' . auth()->user()->lastname)->paginate(15)->onEachSide(1);
    
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
        'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,avi,pdf|max:25600',
        'title' => 'required',
        'topic' => 'nullable',
        'keywords' => 'nullable',
        'author' => 'nullable',
        'description' => 'nullable',
        'college' => 'nullable',
        'discipline' => 'nullable',
    ]);

        // Upload the file to Google Drive
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $originalFilename = $file->getClientOriginalName();

        // Map file extensions to folder IDs
        $folderIds = [
            // Text-Based
            'pdf' => '14jKZwtjsbdiTgGcs-P5fB5jhxg9N8PP_',
            'docx' => '14jKZwtjsbdiTgGcs-P5fB5jhxg9N8PP_',
            'pptx' => '14jKZwtjsbdiTgGcs-P5fB5jhxg9N8PP_',
            // Video-Based
            'mp4' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'avi' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'mov' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'webm' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'mkv' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'flv' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'wmv' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            '3gp' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            'ogg' => '1aNBhQlxIoGTSwFp487DdKkAsaH-LJx1A',
            // Image-Based
            'jpeg' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
            'jpg' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
            'png' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
            'gif' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
            'bmp' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
            'tiff' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
            'webp' => '1DFnA8EogYagN7VNXPk8ISY6avEQ7zIyJ',
        ];

        // Set access token for the Google client
        $googleClient = new GoogleClient();
        $googleClient->setAccessToken(self::getGoogleDriveAccessToken());

        // Initialize the Google Drive service
        $googleDrive = new GoogleDriveService($googleClient);

        // File metadata
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $originalFilename, // Use the original file name
            'parents' => [$folderIds[$extension]], // Folder ID of the destination folder
        ]);

        // Upload the file and get the file ID
        $uploadedFile = $googleDrive->files->create($fileMetadata, [
            'data' => file_get_contents($file->getPathname()),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink',
        ]);

        // Get the file URL from the file ID
        $fileUrl = 'https://drive.google.com/uc?id=' . $uploadedFile->id;

        // Fetch the firstname and lastname of the teacher who uploaded the resource
        $author = auth()->user()->firstname . ' ' . auth()->user()->lastname;

    // Create a new resource instance
    $resource = new Resource();
    $resource->title = $validatedData['title'];
   // $resource->topic = $validatedData['topic'];
   // $resource->keywords = $validatedData['keywords'];
   $resource->author = $author;
   // $resource->description = $validatedData['description'];
    $resource->url = $fileUrl;
   // $resource->college_id = $validatedData['college'];
   // $resource->discipline_id = $validatedData['discipline'];
    $resource->save();

    if ($resource) {
        // Process PDF file and create JSON file
        if ($extension === 'pdf') {
            $pdfContent = file_get_contents($file->getPathname());
            $jsonContent = $this->convertPdfToJson($pdfContent);
            $jsonFileName = $this->generateUniqueJsonFileName($resource->title);
            
            // Store the JSON file in a separate folder on Google Drive
            $jsonFolderId = '1auvNaRyQOiHvnOYRs8E831c83GC523L1';  // Replace with your Google Drive folder ID for JSON files
            $jsonFileId = $this->uploadJsonToGoogleDrive($jsonFileName, $jsonContent, $jsonFolderId);

            // Update the resource with the JSON file URL
            $resource->json_url = 'https://drive.google.com/uc?id=' . $jsonFileId;
            $resource->save();
        }

       // Redirect to the edit page for the newly uploaded resource
       return redirect()->route('resources.edit', $resource)->with('success', 'Resource uploaded successfully');
   } else {
       // Handle the case where no resource was found
       return redirect()->route('teachermanage')->with('error', 'Resource not found.');
   }
}

private function convertPdfToJson($pdfContent)
{
    try {
        // Use the PDF parser from the Spatie\PdfToText\Pdf library
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseContent($pdfContent);

        // Extract text from each page of the PDF
        $text = '';
        foreach ($pdf->getPages() as $page) {
            $text .= $page->getText();
        }

        // Check if the text is not empty before attempting to encode to JSON
        if (!empty($text)) {
            // Your logic to convert text to JSON goes here
            // For example, you can use json_encode if the text structure allows it
            $json = json_encode(['content' => $text]);

            return $json;
        } else {
            // Handle the case where the text is empty
            return null;
        }
    } catch (\Exception $e) {
        // Handle the exception if PDF parsing fails
        return null;
    }
}

private function generateUniqueJsonFileName($title)
{
    // Your logic to generate a unique JSON file name goes here
    // For example, you can use a combination of timestamp and the title
    return time() . '_' . str_replace(' ', '_', strtolower($title)) . '.json';
}

private function uploadJsonToGoogleDrive($jsonFileName, $jsonContent, $jsonFolderId)
{
    // Your logic to upload JSON content to Google Drive goes here

    // Set access token for the Google client
    $googleClient = new \Google_Client();
    $googleClient->setAccessToken(self::getGoogleDriveAccessToken());

    // Initialize the Google Drive service
    $googleDrive = new \Google_Service_Drive($googleClient);

    // File metadata
    $fileMetadata = new \Google_Service_Drive_DriveFile([
        'name' => $jsonFileName,
        'parents' => [$jsonFolderId],
    ]);

    // Create a stream for the JSON content
    $stream = fopen('php://memory', 'r+');
    fwrite($stream, $jsonContent);
    rewind($stream);

    // Upload the JSON file and get the file ID
    $uploadedFile = $googleDrive->files->create($fileMetadata, [
        'data' => stream_get_contents($stream),
        'uploadType' => 'multipart',
        'fields' => 'id',
    ]);

    // Close the stream
    fclose($stream);

    return $uploadedFile->id;
}


        /**
     * Delete the file and its metadata.
     *
     * @param  int  $resource
     * @return \Illuminate\Http\Response
     */
 // Delete resource function
public function destroy($resourceId)
{
    $resource = Resource::findOrFail($resourceId);

    // Extract the file ID from the Google Drive URL for the resource file
    $urlParts = parse_url($resource->url);
    parse_str($urlParts['query'], $queryParameters);
    $fileId = $queryParameters['id'];

    // Set access token for the Google client
    $googleClient = new GoogleClient();
    $googleClient->setAccessToken(self::getGoogleDriveAccessToken());

    // Initialize the Google Drive service
    $googleDrive = new GoogleDriveService($googleClient);

    try {
        // Delete the resource file from Google Drive
        $googleDrive->files->delete($fileId);
    } catch (\Exception $e) {
        // Handle any errors that occur during file deletion from Google Drive
        return redirect()->back()->with('error', 'Failed to delete the resource file from Google Drive.');
    }

    // Check if the resource has a JSON file associated with it
    if (!empty($resource->json_url)) {
        // Extract the JSON file ID from the Google Drive URL for the JSON file
        $jsonUrlParts = parse_url($resource->json_url);
        parse_str($jsonUrlParts['query'], $jsonQueryParameters);
        $jsonFileId = $jsonQueryParameters['id'];

        try {
            // Delete the JSON file from Google Drive
            $googleDrive->files->delete($jsonFileId);
        } catch (\Exception $e) {
            // Handle any errors that occur during JSON file deletion from Google Drive
            return redirect()->back()->with('error', 'Failed to delete the JSON file from Google Drive.');
        }
    }

    // Delete the resource from the database
    $resource->delete();

    return redirect()->back()->with('success', 'Resource and associated files deleted successfully.');
}


    // Edit resource function
    public function edit(Resource $resource)
    {    
        $resources = Resource::all();
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();

        $disciplines = Discipline::pluck('disciplineName', 'id'); // Assuming you have a Discipline model

       // $colleges = College::pluck('collegeName', 'id');

        return view('teacher.edit', compact('resource', 'colleges', 'courses', 'subjects', 'disciplines'));
    }

// Update resource function
public function update(Request $request, Resource $resource)
{
    // Validate the form data
    $validatedData = $request->validate([
        'title' => 'required',
        // Add other validation rules as needed
    ]);

    // Update resource data
    $resource->update($validatedData);

    // Generate unique JSON file name
    $jsonFileName = $this->generateUniqueJsonFileNameAfterUpdate($resource);

    // Check if the resource has a JSON file associated with it
    if (!empty($resource->json_url)) {
        // Extract the JSON file ID from the Google Drive URL for the JSON file
        $jsonUrlParts = parse_url($resource->json_url);
        parse_str($jsonUrlParts['query'], $jsonQueryParameters);
        $jsonFileId = $jsonQueryParameters['id'];

        // Set access token for the Google client
        $googleClient = new GoogleClient();
        $googleClient->setAccessToken(self::getGoogleDriveAccessToken());

        // Initialize the Google Drive service
        $googleDrive = new GoogleDriveService($googleClient);

        try {
            // Fetch the existing file metadata
            $fileMetadata = $googleDrive->files->get($jsonFileId, ['fields' => 'name']);

            // Update the JSON file name on Google Drive
            $fileMetadata->setName($jsonFileName);
            $googleDrive->files->update($jsonFileId, $fileMetadata);
        } catch (\Exception $e) {
            // Handle any errors that occur during JSON file update on Google Drive
            return redirect()->back()->with('error', 'Failed to update the JSON file name on Google Drive.');
        }
    }

    return redirect()->route('teacher.manage')->with('success', 'Resource updated successfully.');
}

// Updated helper function to generate unique JSON file name
private function generateUniqueJsonFileNameAfterUpdate(Resource $resource)
{
    // Get discipline name based on discipline_id
    $disciplineName = Discipline::find($resource->discipline_id)->disciplineName;

    // Get unique identifier based on resource ID
    $uniqueIdNo = $resource->id;

    // Combine the elements to form the unique JSON file name
    return "{$disciplineName}_{$resource->title}-{$uniqueIdNo}.json";
}


    public function autofill(Request $request)
    {
        $title = $request->title;
        $resource = Resource::where('title', $title)->first();
    
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
    
        $summary = ''; // Your logic to get the summary goes here
    
        $disciplineId = $resource->discipline_id;
        $discipline = Discipline::find($disciplineId);
    
        if (!$discipline) {
            $isDisciplineValid = false;
            $disciplineName = null;
        } else {
            $isDisciplineValid = true;
            $disciplineName = $discipline->name;
        }
    
        // Retrieve the college_id and college_name from the resource
        $collegeId = $resource->college_id;
        $college = College::find($collegeId);
    
        if (!$college) {
            $isCollegeValid = false;
            $collegeName = null;
        } else {
            $isCollegeValid = true;
            $collegeName = $college->collegeName;
        }
    
        $keywords = $resource->keywords;
    
        $response = [
            'discipline' => $isDisciplineValid,
            'discipline_name' => $disciplineName,
            'college' => $isCollegeValid,
            'collegeName' => $collegeName,
            'keywords' => $keywords,
            'summary' => $summary,
        ];
    
        return response()->json($response);
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
        $resources = Resource::paginate(10)->onEachSide(1);
    
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
        ->paginate(10)
        ->onEachSide(1);

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
    
            // Determine the MIME type based on the file contents
            $fileContents = $file->getBody()->getContents();
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $fileMimeType = $finfo->buffer($fileContents);
    
            // Get the file extension for naming the downloaded file
            $fileExtension = $this->getExtensionFromMimeType($fileMimeType);
    
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
    
    private function getExtensionFromMimeType($mimeType)
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/tiff' => 'tiff',
            'image/webp' => 'webp',
            'video/mp4' => 'mp4',
            'video/x-msvideo' => 'avi',
            'video/quicktime' => 'mov',
            'video/webm' => 'webm',
            'video/x-matroska' => 'mkv',
            'video/x-flv' => 'flv',
            'video/x-ms-wmv' => 'wmv',
            'video/3gpp' => '3gp',
            'video/ogg' => 'ogg',
            'application/pdf' => 'pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        ];
    
        return $extensions[$mimeType] ?? 'bin';
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

            // Check if the user has already viewed this resource in the current session
    if (!$request->session()->has('viewed_resource_' . $resource->id)) {
        // If not viewed in this session, increment the view count and mark as viewed
        $resource->increment('view_count');
        $request->session()->put('viewed_resource_' . $resource->id, true);
    }

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
        // resource
        $resources = $discipline->resources()->paginate(18);

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
                    ->orWhere('description', 'LIKE', '%' . $query . '%');
            })
            ->paginate(18);
    
        return view('disciplines.disciplines', compact('discipline', 'college', 'resources'));
    }

    public function sortDisciplineResources(Request $request, $college_id, $discipline_id)
    {
        $sortBy = $request->input('sort', 'title'); // Get the selected sorting criteria (default to 'title' if not provided)
    
        $college = College::findOrFail($college_id);
        $discipline = Discipline::findOrFail($discipline_id);
    
        $resources = $discipline->resources();
    
        // Handle different sorting options
        if ($sortBy === 'title') {
            $resources->orderBy('title', 'asc');
        } elseif ($sortBy === 'author') {
            $resources->orderBy('author', 'asc');
        } elseif ($sortBy === 'created_at') {
            $resources->orderBy('created_at', 'desc');
        }
    
        $resources = $resources->paginate(18);
    
        return view('disciplines.disciplines', compact('discipline', 'college', 'resources'));
    }

    
}
