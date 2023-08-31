<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\Backup\Tasks\Restore\RestoreJob;
use Spatie\Backup\BackupServiceProvider;

class BackupRestoreController extends Controller
{
    public function showLoginForm()
    {
        return view('administrator.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the authenticated user has the super-admin role
            if (Auth::user()->role_id == 4) {
                return view('administrator.dashboard');

            } else {
                return redirect()->back()->with('error', 'You do not have the required privileges.');
            }
        }

        return redirect()->back()->with('error', 'Invalid login credentials.');
    }

    public function backup()
    {
        $artisanPath = base_path('artisan');
        $exitCode = null;
        $output = null;
        
        exec("php \"$artisanPath\" backup:run", $output, $exitCode);
        
        if ($exitCode === 0) {
            return redirect()->back()->with('success', 'Backup completed successfully.');
        } else {
            return redirect()->back()->with('error', 'Backup operation failed.');
        }
    }

    public function restore(Request $request)
    {
            $request->validate([
                'backup_file' => 'required|file|mimes:zip',
            ]);

            $uploadedFile = $request->file('backup_file');

            if ($uploadedFile) {
                // Store the uploaded file in a temporary location
                $tempPath = $uploadedFile->store('temp');

                // Extract the contents of the uploaded zip file
                $extractedPath = storage_path('app/' . $tempPath);
                $zip = new \ZipArchive();
                if ($zip->open($extractedPath) === true) {
                    $zip->extractTo(storage_path('app/temp-extracted'));
                    $zip->close();

                    $exitCode = null;
                    $output = null;

                    // Run the backup:restore command using exec
                    $artisanPath = base_path('artisan');
                    exec("php \"$artisanPath\" backup:restore", $output, $exitCode);

                    dd($exitCode, $output);

                    // Clean up temporary files
                    Storage::delete([$tempPath, 'temp-extracted']);

                    if ($exitCode === 0) {
                        return redirect()->back()->with('success', 'Restore completed successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Restore operation failed.');
                    }
                }
            }

            return redirect()->back()->with('error', 'Invalid uploaded file.');
        } 
}