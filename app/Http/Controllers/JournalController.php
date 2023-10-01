<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
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
    
        // Retrieve journals with matching titles
        $matchingJournals = Journal::where('title', 'like', "%$search%");
    
        // Retrieve remaining journals
        $otherJournals = Journal::where('title', 'not like', "%$search%");
    
        // Merge the two sets of journals
        $journals = $matchingJournals->union($otherJournals)->paginate(5);
    
        return view('journals.index', compact('journals', 'search'));
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
            'title' => 'required',
            'content' => 'nullable',
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
            'user_id' => auth()->user()->id,
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
            'content' => 'nullable',
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
        
        $journal->delete();

        return redirect()->route('journals.index');
    }

}
