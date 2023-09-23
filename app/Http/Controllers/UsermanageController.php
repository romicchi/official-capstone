<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;
use App\Models\ArchiveUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;  
use Google\Cloud\Storage\StorageClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\Mail\RegistrationEmail;
use App\Mail\UserVerifiedEmail;
use App\Rules\ValidEmailDomain;
use Google\Client as GoogleClient;
use Carbon\Carbon;

class UsermanageController extends Controller
{

    //show adminadd page
    public function showadminadd() 
    {  
        return view('administrator.adminadd');
    }
    
    private function getGoogleDriveAccessToken()
    {
        $jsonKeyFilePath = base_path('resources/credentials/generapp-c64fbc26723c.json'); // Replace with the path to your JSON key file
        $jsonKey = file_get_contents($jsonKeyFilePath);

        $googleClient = new GoogleClient();
        $googleClient->setAuthConfig(json_decode($jsonKey, true));
        $googleClient->setScopes([\Google_Service_Drive::DRIVE]);
        $googleClient->fetchAccessTokenWithAssertion();

        return $googleClient->getAccessToken()['access_token'];
    }

    private static function calculateExpiryDate($yearLevel) {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $yearLevelDifference = 5 - $yearLevel;

        $yearDifference = $currentYear + $yearLevelDifference;

        $expiration_date = Carbon::createFromDate($yearDifference, 06, 15);

        return $expiration_date;
    }

    // Method to create a new user
    public function addUser(Request $request)
    {
        // Validate the form data
        $request->validate([
            'id' => 'required|file|mimes:jpeg,jpg,png|max:8192',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => ['required', 'email', new ValidEmailDomain, 'unique:users'],
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:1,2,3',
            'year_level' => 'required_if:role,1|in:1,2,3,4',
            'student_number' => 'required_if:role,1|nullable|unique:users|digits:7',
        ]);

        $data['firstname'] = $request->firstname;
        $data['lastname'] = $request->lastname;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = $request->input('role');

        // Create the user record in the database
        $user = User::create($data);

        // Save the year level in the database if the user is a student
        if ($data['role_id'] == 1) {
            $user->year_level = $request->input('year_level');
            $user->expiration_date = self::calculateExpiryDate($user->year_level); // Use self:: to reference the function
            $user->student_number = $request->input('student_number');
            $user->save();
        }

        // Save the info in the database if the user is a teacher
        if ($data['role_id'] == 2) {
            $user->year_level = null;
            $user->expiration_date = null;
            $user->student_number = null;
            $user->role_id = 2;
            $user->save();
        }

        // Save the info in the database if the user is an admin
        if ($data['role_id'] == 3) {
            $user->year_level = null;
            $user->expiration_date = null;
            $user->student_number = null;
            $user->role_id = 3;
            $user->save();
        }

        // Upload the file to Google Drive
        $file = $request->file('id');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;

        // Create a new Google client
        $googleClient = new GoogleClient();
        $googleClient->setAccessToken($this->getGoogleDriveAccessToken()); // Set access token for the Google client
        $googleDrive = new \Google_Service_Drive($googleClient);

        // Upload the file to Google Drive
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $filename,
            'parents' => ['1ttNLNF6X2fsjgvRr4jFfd4-1_HxRETW6'], // Replace with the folder ID of your Google Drive folder
        ]);

        $uploadedFile = $googleDrive->files->create($fileMetadata, [
            'data' => file_get_contents($file->getPathname()),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink',
        ]);
        
        // Get the file ID and generate the preview link
        $fileId = $uploadedFile->id;
        $previewLink = "http://drive.google.com/uc?export=view&id=$fileId";

        
        $user->url = $previewLink;
        
        $user->verified = true;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();

        // Send a verification email to verified users
        Mail::to($user->email)->send(new UserVerifiedEmail($user));
        
        function getGoogleDriveAccessToken()
        {
            return 'your_access_token';
        }

        $activeTab = 'existing';

        // Redirect the user back to the manage user page with a success message
        return redirect()->route('usermanage', compact('activeTab'))->with('success', 'User created successfully.');
    }    


    //display all users in the database
    public function show(Request $request)
    {
        $pendingUsers = User::with('role')->where('verified', false)->paginate(10, ['*'], 'pending_page');
        $existingUsers = User::with('role')->where('verified', true)->paginate(11, ['*'], 'existing_page');
        $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10, ['*'], 'archive_page');
        $calculateExpiryDate = self::calculateExpiryDate($request->year_level);

        $existingUsersQuery = User::with('role')->where('verified', true);

        // Sorting
        $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
        $existingUsersQuery->orderBy('lastname', $sortOrder);
        $existingUsers = $existingUsersQuery->paginate(11);

        $activeTab = 'existing';
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        
        return view('administrator.usermanage', ['pendingUsers' => $pendingUsers, 'existingUsers' => $existingUsers, 'activeTab' => $activeTab, 'roles' => $roles, 'archiveViewableUsers' => $archiveViewableUsers, 'calculateExpiryDate' => $calculateExpiryDate]);
    }

    function verifyUsers(){
        $users = User::where('verified', false)->get();
    
        return view('administrator.usermanage', ['users' => $users]);
    }
    
    function postVerifyUsers(Request $request){
        $verifiedUserIds = $request->input('verified_users', []);
        $rejectedUserIds = $request->input('rejected_users', []);
        Paginator::useBootstrap();
    
        User::whereIn('id', $verifiedUserIds)->update(['verified' => true]);
        User::whereIn('id', $rejectedUserIds)->delete();

        // Send a verification email to verified users
        $verifiedUsers = User::whereIn('id', $verifiedUserIds)->get();
        foreach ($verifiedUsers as $user) {
            Mail::to($user->email)->send(new UserVerifiedEmail($user));
        }

        $activeTab = 'pending';
    
        return redirect()->route('usermanage', compact('activeTab'))->with('success', 'Users verified successfully.');
    }

    //delete user function
    public function delete($id) 
    {  
        $userdata = User::findOrFail($id);
        $userdata->delete();

        $activeTab = 'existing';

        return redirect()->route('usermanage', compact('activeTab'))->with('success', 'User deleted successfully.');
    }

    //show adminedit user function
    public function showadminedit($id) 
    {  
        $userdata = User::findOrFail($id);
        return view('administrator.adminedit',['users'=>$userdata]);
    }

    //update/edit user function
    public function update(Request $req) 
    {  
        $userdata = User::find($req->id);
        $userdata->firstname = $req->firstname;
        $userdata->lastname = $req->lastname;
        $userdata->email = $req->email;
        $userdata->password = Hash::make($req->password);
        $userdata->role_id = $req->role;
        $userdata->updated_at = now();
        $userdata->expiration_date = null;

        // Check if the role is "Student" and update the student number if provided
        if ($req->role == 1) {
            $req->validate([
                'student_number' => 'required|numeric|digits:7|unique:users,student_number,'.$userdata->id, // Ensure it's unique for the current user
                'year_level' => 'required_if:role,1|in:1,2,3,4', // Add validation for year level

            ]);
            
            $userdata->year_level = $req->input('year_level');
            $userdata->expiration_date = self::calculateExpiryDate($userdata->year_level); // Use self:: to reference the function
            $userdata->student_number = $req->student_number;
        }

        $userdata->save();

        $activeTab = 'existing';

        return redirect()->route('usermanage', compact('activeTab'))->with('success', 'User updated successfully.');

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Get the current page from the query parameters
        $currentPage = $request->query('page', 1);
    
        $existingUsers = User::with('role')
            ->where('verified', true)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('firstname', 'like', '%' . $query . '%')
                    ->orWhere('lastname', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('student_number', 'like', '%' . $query . '%');
            })
            ->paginate(10, ['*'], 'existing_page')->withQueryString();
    
        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->paginate(10);
    
        // Set the active tab to 'existing' since the search only affects existing users
        $activeTab = 'existing';
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10);
    
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'activeTab' => $activeTab,
            'roles' => $roles,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    public function searchPending(Request $request)
    {
        $query = $request->input('query');
        
        // Get the current page from the query parameters
        $currentPage = $request->query('page', 1);

        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('firstname', 'like', '%' . $query . '%')
                    ->orWhere('lastname', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('student_number', 'like', '%' . $query . '%');
            })
            ->paginate(10, ['*'], 'pending_page')->withQueryString();

        $existingUsers = User::with('role')
            ->where('verified', true)
            ->paginate(10, ['*'], 'existing_page');

        $activeTab = 'pending';
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10);

        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'activeTab' => $activeTab,
            'roles' => $roles,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    // Search function for archived users
    public function searchArchive(Request $request)
    {
        $query = $request->input('query');
        $pendingUsers = User::with('role')->where('verified', false)->paginate(10, ['*'], 'pending_page');
        $existingUsers = User::with('role')->where('verified', true)->paginate(10, ['*'], 'existing_page');

        // Query the archived users
        $archiveViewableUsers = ArchiveUser::where('archived', true)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('firstname', 'like', '%' . $query . '%')
                    ->orWhere('lastname', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('student_number', 'like', '%' . $query . '%');
            })
            ->paginate(10);

        // Set the active tab to 'archive'
        $activeTab = 'archive';
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();

        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'archiveViewableUsers' => $archiveViewableUsers,
            'activeTab' => $activeTab,
            'roles' => $roles,
        ]);
    }
    
    public function filterByRole(Request $request)
    {
        $roleFilter = $request->input('role');
        
        // Get the current page from the query parameters
        $currentPage = $request->query('page', 1);

        $existingUsersQuery = User::with('role')->where('verified', true);
        
        if ($roleFilter != 'all') {
            $existingUsersQuery->where('role_id', $roleFilter);
        }
        
        // Paginate the results and pass the current page
        $existingUsers = $existingUsersQuery->paginate(10, ['*'], 'existing_page')->withQueryString();

        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->paginate(10);

        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10);
        
        $activeTab = 'existing';
        
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }
    
    public function filterPendingByRole(Request $request)
    {
        $roleFilter = $request->input('role');

        // Get the current page from the query parameters
        $currentPage = $request->query('page', 1);

        $pendingUsersQuery = User::with('role')
            ->where('verified', false);

        if ($roleFilter != 'all') {
            $pendingUsersQuery->where('role_id', $roleFilter);
        }

        $pendingUsers = $pendingUsersQuery->paginate(10)->withQueryString();

        $existingUsers = User::with('role')
            ->where('verified', true)
            ->paginate(10);

        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10);

        $activeTab = 'pending';

        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    public function filterArchiveByRole(Request $request)
    {
        $roleFilter = $request->input('role');

        // Get the current page from the query parameters
        $currentPage = $request->query('page', 1);

        $archiveViewableUsersQuery = ArchiveUser::where('archived', true);

        if ($roleFilter != 'all') {
            $archiveViewableUsersQuery->where('role_id', $roleFilter);
        }

        $archiveViewableUsers = $archiveViewableUsersQuery->paginate(10)->withQueryString();

        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->paginate(10);

        $existingUsers = User::with('role')
            ->where('verified', true)
            ->paginate(10);

        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();

        $activeTab = 'archive';

        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    public function sortArchive(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
    
        // Query the archiveViewableUsers based on the selected sorting order
        $archiveViewableUsers = ArchiveUser::with('role')
            ->where('archived', true)
            ->orderBy('lastname', $sortOrder) // Sort by created_at column
            ->paginate(10)->withQueryString();
    
        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->paginate(10);
    
        $existingUsers = User::with('role')
            ->where('verified', true)
            ->paginate(10);
    
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
    
        $activeTab = 'archive';
    
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    public function sortExisting(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
    
        // Query the archiveViewableUsers based on the selected sorting order
        $archiveViewableUsers = ArchiveUser::with('role')
            ->where('archived', true)
            ->paginate(10)->withQueryString();
    
        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->paginate(10);
    
        $existingUsers = User::with('role')
            ->where('verified', true)
            ->orderBy('lastname', $sortOrder) // Sort by created_at column
            ->paginate(10);
    
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
    
        $activeTab = 'existing';
    
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    public function sortPending(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
    
        // Query the archiveViewableUsers based on the selected sorting order
        $archiveViewableUsers = ArchiveUser::with('role')
            ->where('archived', true)
            ->paginate(10)->withQueryString();
    
        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->orderBy('lastname', $sortOrder) // Sort by created_at column
            ->paginate(10);
    
        $existingUsers = User::with('role')
            ->where('verified', true)
            ->paginate(10);
    
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
    
        $activeTab = 'pending';
    
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
            'archiveViewableUsers' => $archiveViewableUsers,
        ]);
    }

    public function archiveViewable()
    {
    $archiveViewableUsers = ArchiveUser::where('archived', true)->with('role')->paginate(10);

    return view('administrator.usermanage', ['archiveViewableUsers' => $archiveViewableUsers]);
    }

public function archive($id)
{
    // Retrieve the user to be archived
    $user = User::find($id);

    if ($user) {
   // Create an archive record
   $archiveUser = new ArchiveUser();
   $archiveUser->student_number = $user->student_number;
   $archiveUser->firstname = $user->firstname;
   $archiveUser->lastname = $user->lastname;
   $archiveUser->email = $user->email;
   $archiveUser->user_id = $user->id;
   // Check if the user has the "Student" role (role_id = 1)
   if ($user->role_id === 1) {
       $archiveUser->year_level = $user->year_level; // Add year level
    } else {
        $archiveUser->year_level = null; // Make year_level nullable for other roles
    }
    $archiveUser->role_id = $user->role_id; // Add role ID
   $archiveUser->url = $user->url; // Add URL
   $archiveUser->archived_at = now(); // Add the current date and time
   $archiveUser->save();

    // Delete the original user record
    $user->delete();

    $existingUsers = User::with('role')
        ->where('verified', true)
        ->paginate(10);
    $pendingUsers = User::with('role')
        ->where('verified', false)
        ->paginate(10);
    $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10);
        
    $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        
        $activeTab = 'existing';

        // Redirect back to the archive view
        return redirect()->route('usermanage', compact('pendingUsers', 'existingUsers', 'activeTab', 'roles', 'archiveViewableUsers'))->with('success', 'User Archived successfully.');
    } else {
        // Handle the case where the user doesn't exist
        $activeTab = 'existing';
        return redirect()->route('usermanage', compact('pendingUsers', 'existingUsers', 'activeTab', 'roles', 'archiveViewableUsers'))->with('error', 'User not found.');
    }

}

public function reactivate($id)
{
    // Retrieve the archived user
    $archivedUser = ArchiveUser::find($id);

    if ($archivedUser) {
    // Create a new user record
    $user = new User();
    $user->student_number = $archivedUser->student_number;
    $user->firstname = $archivedUser->firstname;
    $user->lastname = $archivedUser->lastname;
    $user->email = $archivedUser->email;
    $user->year_level = $archivedUser->year_level;
    $user->role_id = $archivedUser->role_id;
    // expiration date after reactivation and based on the yr level
    $user->expiration_date = self::calculateExpiryDate($user->year_level);
    $user->verified = 1; // Assuming users are verified upon reactivation

    // Generate a temporary password and hash it
    $temporaryPassword = 'LNUpass123!';
    $user->password = Hash::make($temporaryPassword);

    // Set the URL and created_at fields
    $user->url = $archivedUser->url;

    $user->save();

    // Delete the archived user
    $archivedUser->delete();

    $existingUsers = User::with('role')
        ->where('verified', true)
        ->paginate(10);
    $pendingUsers = User::with('role')
        ->where('verified', false)
        ->paginate(10);
        $archiveViewableUsers = ArchiveUser::where('archived', true)->paginate(10);
        
        $roles = Role::whereNotIn('role', ['super-admin', 'admin'])->get();
        
        $activeTab = 'archive';

        // Redirect back to the archive view
        return redirect()->route('usermanage', compact('pendingUsers', 'existingUsers', 'activeTab', 'roles', 'archiveViewableUsers'))->with('success', 'User Reactivated successfully.');
    } else {
        // Handle the case where the archived user doesn't exist
        $activeTab = 'archive';
        return redirect()->route('usermanage', compact('pendingUsers', 'existingUsers', 'activeTab', 'roles', 'archiveViewableUsers'))->with('error', 'Archived User not found.');
    }
}

// Delete user function in UsermanageController.php
public function deleteArchive($id) 
{  
    $userdata = ArchiveUser::find($id);

    if ($userdata) {
        // User exists, force delete it
        $userdata->forceDelete();
    }

    $activeTab = 'archive';

    return redirect()->route('usermanage', compact('activeTab'))->with('success', 'User deleted successfully.');
}

    public function index()
    {
        $users = User::with('image')->get(); // Retrieve all users with their associated images
        
        return view('users.index', compact('users'));
    }
}
