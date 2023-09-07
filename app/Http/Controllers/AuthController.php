<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;  
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmail;
use App\Models\User;
use Carbon\Carbon;
use Google\Client as GoogleClient;

class AuthController extends Controller
{
    function login(){
        if (Auth::check()) { // This will check if the user is login, if login then the user will not be able to access loginform
            return redirect(route('dashboard'));
        }
        return view('loginform');
    }

    function registration(){
        if (Auth::check()) { // This will check if the user is login, if login then the user will not be able to access register
            return redirect(route('dashboard'));
        }
        return view('register');
    }

    function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
    
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if "Remember Me" is checked

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            // If user is not verified then redirect to login
            if (!$user->verified) {
                Auth::logout();
                return redirect(route('login'))->with("error", "Your account is not yet verified. Please wait for the administrator to verify your user credentials. Thank you for your patience.");
            }

            // Rotate the remember token if user is logged in and "Remember Me" is checked
            if ($remember && $user instanceof Authenticatable) {
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
            
            // Update user's last activity timestamp
            $user->last_activity = Carbon::now();
            $user->save();
    
            if ($user->role_id == 3 || $user->role_id == 4) {
                // Redirect to admin page for admin user
                return redirect()->intended(route('adminpage'));
            }
    
            return redirect()->intended(route('dashboard'));
        }
    
        return redirect(route('login'))->with("error", "Your email and password do not match. Please try again.");
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

    function registerPost(Request $request)
    {
        $request->validate([
            'id' => 'required|file|mimes:jpeg,jpg,png|max:8192',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:1,2',
            'year_level' => 'required_if:role,1|in:1,2,3,4', // Add validation for year_level if role is student
        ]);
    
        $data['firstname'] = $request->firstname;
        $data['lastname'] = $request->lastname;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = $request->input('role');
        $data['verified'] = false;
    
        // Create the user record in the database
        $user = User::create($data);
    
        // Save the year level in the database if the user is a student
        if ($data['role_id'] == 1) {
            $user->year_level = $request->input('year_level');
            $user->expiry_date = calculateExpiryDate($user->year_level);
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
        $user->save();
        
        // Send verification email
        Mail::to($data['email'])->send(new RegistrationEmail($user));

        // Update user's role to 'teacher' if the selected role is 'teacher'
        if ($data['role_id'] == 2) {
            $user->role_id = 2;
            $user->save();
        }

        // Send verification email
        Mail::to($data['email'])->send(new RegistrationEmail($user));

         // update user's role to 'teacher' if the selected role is 'teacher'
         if ($data['role_id'] == 2) {
            $user->role_id = 2;
            $user->save();
        }

        function getGoogleDriveAccessToken()
        {
            return 'your_access_token';
        }

        if(!$user) {
        return redirect(route('register'))->with("error", "Registration failed, try again."); //with("key", "error message") and inside the route is the name in get
        }
        // redirect to login after successfully registered
        return redirect(route('login'))->with("success", "Registration successful. Check your email and wait for verification."); //with("key", "success message") and inside the route is the name in get
        
    }

    function calculateExpiryDate($yearLevel) {
        // Define the account durations for each year level
        $accountDurations = [
            1 => 4, // 1st year -> 4 years account duration
            2 => 3, // 2nd year -> 3 years account duration
            3 => 2, // 3rd year -> 2 years account duration
            4 => 1, // 4th year -> 1 year account duration
        ];
    
        // Calculate the expiration date based on the current date and year level
        $currentDate = Carbon::now();
        $expiryDate = $currentDate->addYears($accountDurations[$yearLevel]);
    
        return $expiryDate;
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'))->with('logout_message', true);
    }
}

