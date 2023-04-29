<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Show the teacher management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Image::all();

        return view('teachermanage', compact('files'));
    }

    /**
     * Upload a file to Firebase Storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        // Validate file input
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,mp4|max:10240',
        ]);

        // Store file in Firebase Storage
        $path = $request->file('file')->store('images', 'local');
        $url = Storage::disk('local')->url($path);
        $type = $request->file('file')->getMimeType();

        // Save file metadata to database
        $file = new Image;
        $file->name = $request->file('file')->getClientOriginalName();
        $file->subject = '';
        $file->about = '';
        $file->url = $url;
        $file->type = $type;
        $file->save();

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    /**
     * Save metadata of a file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveMetadata(Request $request)
    {
        // Find file by ID
        $file = Image::find($request->input('id'));

        // Update file metadata
        $file->subject = $request->input('subject');
        $file->about = $request->input('about');
        $file->save();

        return redirect()->back()->with('success', 'Metadata saved successfully!');
    }

    /**
     * Delete a file from Firebase Storage and the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFile($id)
    {
        // Find file by ID
        $file = Image::find($id);

        // Delete file from Firebase Storage
        Storage::disk('local')->delete($file->url);

        // Delete file from database
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }
}
