<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use App\Models\College;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\File;
use Google\Client as GoogleClient;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use PDF;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedDiscipline = $request->input('discipline');

        // Query to retrieve journals with matching titles
        $matchingJournals = Journal::where('title', 'like', "%$search%");

        // Query to filter by selected discipline
        if (!empty($selectedDiscipline)) {
            $matchingJournals->where('discipline_id', $selectedDiscipline);
        }

        // Filter journals to only include those owned by the authenticated user
        $user = auth()->user();
        $matchingJournals->where('user_id', $user->id);

        // Retrieve the filtered journals
        $journals = $matchingJournals->paginate(5);
        
            // If the request is AJAX, return the journals as JSON
    if ($request->ajax()) {
        return response()->json(view('journals.list', compact('journals'))->render());
    }

        // Retrieve all disciplines for the dropdown
        $disciplines = Discipline::all();

        return view('journals.index', compact('journals', 'search', 'disciplines', 'selectedDiscipline'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('journals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|max:65535',
            'college_id' => 'required',
            'discipline_id' => 'required',
        ]);
    
        // Check if the title exceeds the maximum word limit
        if (str_word_count($validatedData['title']) > 100) {
            return redirect()->back()->withErrors(['title' => 'The title exceeds the maximum allowed word limit.']);
        }
    
        // Check if the content exceeds the maximum word limit
        if ($validatedData['content'] !== null && str_word_count($validatedData['content']) > 65535) {
            return redirect()->back()->withErrors(['content' => 'The content exceeds the maximum allowed word limit.']);
        }
    
        $journal = Journal::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'college_id' => $validatedData['college_id'], // Use college_id
            'discipline_id' => $validatedData['discipline_id'], // Use discipline_id
            'user_id' => auth()->user()->id,
        ]);

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => auth()->user()->id,
            'activity' => 'Created a journal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        $user = auth()->user();
        $user->journals()->save($journal);
    
        return redirect()->route('journals.show', $journal);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = $file->getClientOriginalName();

            // Create a new Google client
            $googleClient = new GoogleClient();
            $googleClient->setAccessToken($this->getGoogleDriveAccessToken()); // Set access token for the Google client
            $googleDrive = new Drive($googleClient);

            // Upload the image directly to Google Drive
            $imageMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => ['18dcSo0GQ0Kki6ewvyljVHsISfwnRcS6C'], // Replace with the folder ID of your Google Drive folder
            ]);

            try {
                $uploadedImage = $googleDrive->files->create(
                    $imageMetadata,
                    [
                        'data' => file_get_contents($file->getPathname()), // Get the file content
                        'uploadType' => 'multipart',
                    ]
                );

                // Get the image file ID and generate the preview link
                $imageFileId = $uploadedImage->id;
                $imagePreviewLink = "https://drive.google.com/uc?id=$imageFileId";

                // Return the image URL in Google Drive
                return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $imagePreviewLink]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Image upload to Google Drive failed: ' . $e->getMessage()], 400);
            }
        } else {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }
    }

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
    

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
        
        return view('journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
    
        $validatedData = $request->validate([
            'title' => 'required|max:100', // Set the maximum length as per your requirement
            'content' => 'required',
        ]);
    
        // Check if the title exceeds the maximum length
        if (strlen($validatedData['title']) > 100) {
            return redirect()->back()->withErrors(['title' => 'The title exceeds the maximum allowed length.']);
        }
    
        // Check if the content exceeds the maximum length
        if ($validatedData['content'] !== null && strlen($validatedData['content']) > 65535) {
            return redirect()->back()->withErrors(['content' => 'The content exceeds the maximum allowed length.']);
        }
    
        $journal->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => auth()->user()->id,
            'activity' => 'Updated a journal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('journals.show', $journal);
    }

    public function downloadPdf(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
    
        // Parse the content to find image URLs and embed them
        $content = preg_replace_callback('/<img src="(https:\/\/drive\.google\.com\/uc\?id=[^"]+)">/', function ($match) {
            $imageUrl = $match[1];
            // Fetch the image data
            $imageData = file_get_contents($imageUrl);
            // Convert it to base64 for embedding
            $imageBase64 = base64_encode($imageData);
            // Embed the image in the PDF
            return '<img src="data:image/jpeg;base64,' . $imageBase64 . '">';
        }, $journal->content);
    
        // Generate the PDF from the modified content
        $pdf = PDF::loadView('journals.pdf', ['journal' => $journal, 'content' => $content]);
    
        // PDF file name
        $fileName = $journal->title . '.pdf';

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => auth()->user()->id,
            'activity' => 'Downloaded a journal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return $pdf->download($fileName);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
    
        // Parse the content to find the image URL
        preg_match('/<img src="(https:\/\/drive\.google\.com\/uc\?id=([^"]+))"/', $journal->content, $matches);
    
        if (count($matches) === 3) {
            // Extract the image URL and its file ID
            $imageUrl = $matches[1];
            $imageFileId = $matches[2];
    
            // Use the same code to get Google Drive access token
            $googleAccessToken = $this->getGoogleDriveAccessToken();
    
            // Initialize the Google Drive client
            $googleClient = new GoogleClient();
            $googleClient->setAccessToken($googleAccessToken);
            $googleDrive = new Drive($googleClient);
    
            // Delete the image from Google Drive
            try {
                $googleDrive->files->delete($imageFileId);
            } catch (\Exception $e) {
                // Handle any errors if the image couldn't be deleted
                return redirect()->back()->withErrors(['error' => 'Failed to delete the image from Google Drive: ' . $e->getMessage()]);
            }
        }
    
        // Now, you can safely delete the journal
        $journal->delete();
    
        return redirect()->route('journals.index');
    }

}
