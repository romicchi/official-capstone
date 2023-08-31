<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;  
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmail;
use Google\Client as GoogleClient;

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

    // Method to create a new user
    public function addUser(Request $request)
    {
        // Validate the form data
        $request->validate([
            'id' => 'required|file|mimes:jpeg,jpg,png|max:8192',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:1,2'
        ]);

        $data['firstname'] = $request->firstname;
        $data['lastname'] = $request->lastname;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = $request->input('role');
        $data['verified'] = false;

        // Create the user record in the database
        $user = User::create($data);

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
        $user->save();
        
        function getGoogleDriveAccessToken()
        {
            return 'your_access_token';
        }

        if(!$user) {
        return redirect(route('register'))->with("error", "Registration failed, try again."); //with("key", "error message") and inside the route is the name in get
        }
        // redirect to login after successfully registered
        return redirect()->route('usermanage')->with('success', 'User created successfully.');
    }

    //display all users in the database
    public function show()
    {
        $pendingUsers = User::with('role')->where('verified', false)->paginate(10, ['*'], 'pending_page');
        $existingUsers = User::with('role')->where('verified', true)->paginate(10, ['*'], 'existing_page');
    
        return view('administrator.usermanage', ['pendingUsers' => $pendingUsers, 'existingUsers' => $existingUsers]);
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
    
        return redirect()->route('usermanage')->with('success', 'Users verified successfully.');
    }

    //delete user function
    public function delete($id) 
    {  
        $userdata = User::findOrFail($id);
        $userdata->delete();
        return redirect()->route('usermanage');
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
        $userdata->role_id = $req->role;
        $userdata->save();
        return redirect()->route('usermanage');
    }

    //search user function
    public function search(Request $request)
    {
        $search = $request->input('query');
        $users = User::where('firstname', 'like', '%' . $search . '%')
            ->orWhere('lastname', 'like', '%' . $search . '%')
            ->get();
            
        return view('administrator.usermanage', ['users' => $users]);
    }

    public function index()
    {
        $users = User::with('image')->get(); // Retrieve all users with their associated images
        
        return view('users.index', compact('users'));
    }
}
