<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use App\Models\Image;
use Session;

class ImageController extends Controller
{
    /**
     * Show the form for managing images.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $files = Image::all();

        return view('teachermanage', compact('files'));
    }

    /**
     * Handle file upload and save metadata to database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
      $request->validate([
        'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,avi,doc,pdf,pptx|max:8192',
        'title' => 'required|string|max:255',
        'topics' => 'nullable|string|max:255',
        'keywords' => 'nullable|string|max:255',
        'owners' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
    ]);
    
    $firebase_storage_path = 'images/';
    $file = $request->file('file');
    $extension = $file->getClientOriginalExtension();
    $filename = uniqid() . '.' . $extension;
    $localPath = storage_path('app/' . $file->storeAs('public', $filename));
    
    $uploadedFile = fopen($localPath, 'r');
    
    app('firebase.storage')->getBucket()->upload($uploadedFile, [
        'name' => $firebase_storage_path . $filename,
    ]);
    
    $file = $request->file('file');
    $path = $file->store('public');
    $url = Storage::url($path);
    $url = app('firebase.storage')->getBucket()->object($firebase_storage_path . $filename)->signedUrl(new \DateTime('tomorrow'));
    
    $image = new Image;
    $image->title = $request->title;
    $image->topics = $request->topics;
    $image->keywords = $request->keywords;
    $image->owners = $request->owners;
    $image->description = $request->description;
    $image->url = $url;
    $image->save();
    
    return redirect()->back()->with('success', 'File uploaded successfully.');
    }
    
    /**
     * Delete the file and its metadata.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
{
    $image = Image::findOrFail($id);

    // Delete Firebase Storage bucket file
    $firebase_storage_path = 'images/';
    $filename = basename(parse_url($image->url, PHP_URL_PATH));
    app('firebase.storage')->getBucket()->object($firebase_storage_path . $filename)->delete();

    // Delete MySQL data
    $image->delete();

    return redirect()->back()->with('success', 'File deleted successfully.');
}

}
