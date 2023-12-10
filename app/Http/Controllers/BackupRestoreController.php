<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Backup\BackupServiceProvider;
use Spatie\Backup\Tasks\Restore\RestoreJob;
use ZipArchive;


class BackupRestoreController extends Controller
{
    public function showLoginForm()
    {
        return view('administrator.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            // Check if the authenticated user has the super-admin role
            if (Auth::user()->role_id == 4) {
                return redirect()->route('administrator.dashboard');
            } else {
                return redirect()->back()->with('error', 'You do not have the required privileges.');
            }
        }

        return redirect()->back()->with('error', 'Invalid login credentials.');
    }

    public function dashboard()
    {
        return view('administrator.dashboard');
    }

    public function backup()
    {
        $artisanPath = base_path('artisan');
        $exitCode = null;
        $output = null;
        
        exec("php \"$artisanPath\" backup:run", $output, $exitCode);
        
        if ($exitCode === 0) {
            return redirect()->route('administrator.dashboard')->with('success', 'Backup completed successfully.');
        } else {
            return redirect()->back()->with('error', 'Backup operation failed.');
        }
    }

    public function restore(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'backup_file' => 'required|file',
        ]);
    
        // Store the uploaded backup file in a temporary directory
        $backupFile = $request->file('backup_file');
        $temporaryPath = $backupFile->storeAs('temp', 'backup');
        // Path to the temporary backup file
        $temporaryBackupPath = storage_path('app/' . $temporaryPath);
        // Check the file extension to determine the type
        $extension = $backupFile->getClientOriginalExtension();
    
        if ($extension === 'zip') {
            // Handle ZIP file restoration
            // Create a new directory for extraction if it doesn't exist
            $extractionPath = storage_path('app/temp/extracted_backup');
            Storage::makeDirectory($extractionPath);
    
            // Extract the ZIP file to the extraction directory
            $zip = new ZipArchive;
            if ($zip->open($temporaryBackupPath) === TRUE) {
                $zip->extractTo($extractionPath);
                $zip->close();
            } else {
                // Handle extraction failure
                Storage::delete($temporaryPath);
                return redirect()->back()->with('error', 'Failed to extract backup file.');
            }
    
            // Path to the extracted SQL backup file
            $sqlBackupFile = $extractionPath . '/db-dumps/mysql-laravel_auth.sql';
    
            // Check if the SQL backup file exists
            if (!file_exists($sqlBackupFile)) {
                // Handle the case where the backup SQL file is not found
                Storage::delete($temporaryPath);
                Storage::deleteDirectory($extractionPath);
                return redirect()->back()->with('error', 'The specified SQL backup file is missing.');
            }
    
            // Read the SQL backup file content
            $sqlContent = file_get_contents($sqlBackupFile);
    
            // Attempt to repair the 'global_priv' table
            try {
                DB::statement('REPAIR TABLE global_priv');
            } catch (\Exception $e) {
                // Handle any repair errors
                Storage::delete($temporaryPath);
                Storage::deleteDirectory($extractionPath);
                return redirect()->back()->with('error', 'Failed to repair the database table: ' . $e->getMessage());
            }
    
            // Execute the SQL queries to restore the database
            DB::unprepared($sqlContent);
    
            // Clean up: Delete the temporary backup file and the extraction directory
            Storage::delete($temporaryPath);
            Storage::deleteDirectory($extractionPath);
    
            // Redirect with a success message
            return redirect()->back()->with('success', 'Database has been restored successfully!');
        } else if ($extension === 'sql') {
            // Handle SQL file restoration
            $sqlContent = file_get_contents($temporaryBackupPath);
    
            // Attempt to repair the 'global_priv' table
            try {
                DB::statement('REPAIR TABLE global_priv');
            } catch (\Exception $e) {
                // Handle any repair errors
                Storage::delete($temporaryPath);
                return redirect()->back()->with('error', 'Failed to repair the database table: ' . $e->getMessage());
            }
    
            // Execute the SQL queries to restore the database
            DB::unprepared($sqlContent);
    
            // Clean up: Delete the temporary SQL backup file
            Storage::delete($temporaryPath);
    
            // Redirect with a success message
            return redirect()->back()->with('success', 'Database has been restored successfully!');
        } else {
            // Handle unsupported file type
            Storage::delete($temporaryPath);
            return redirect()->back()->with('error', 'Unsupported file type. Only ZIP and SQL files are allowed.');
        }
    }
    
}