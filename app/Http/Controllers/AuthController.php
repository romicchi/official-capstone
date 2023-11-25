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
use App\Rules\ValidEmailDomain;
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
            'email_or_student_number' => 'required|email',
            'password' => 'required|min:8'
        ]);
    
        $emailOrStudentNumber = $request->input('email_or_student_number'); // Get the input from the form
        $password = $request->input('password');
        $remember = $request->has('remember'); // Check if "Remember Me" is checkeds

        $credentials = [
            'password' => $password
        ];

        // Check if the input is an email address
        if (filter_var($emailOrStudentNumber, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $emailOrStudentNumber;
        } else {
            // If not an email, assume it's a student number
            $credentials['student_number'] = $emailOrStudentNumber;
        }

        if (Auth::attempt($credentials, $password, $remember)) {
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
                session(['logged_activity' => true]);

                // Redirect to admin page for admin user
                return redirect()->intended(route('adminpage'));
            }
    
            return redirect()->intended(route('dashboard'));
        }
    
        return redirect()->back()->withErrors([
            'password' => 'Invalid password. Please try again.',
        ])->withInput($request->except('password'));
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
            'firstname' => 'required|regex:/^[A-Za-z\s]+$/|min:2',
            'lastname' => 'required|regex:/^[A-Za-z\s]+$/|min:2',
            'suffix' => 'nullable|min:2',
            'email' => ['required', 'email', new ValidEmailDomain, 'unique:users'],
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:1,2',
            'year_level' => 'required_if:role,1|in:1,2,3,4', // Validation for year_level if role is student
            'student_number' => 'required_if:role,1|nullable|unique:users|digits:7', // Validation for student_number
            'college_id' => 'required|exists:college,id',
        ]);
    
        $data['firstname'] = $request->firstname;
        $data['lastname'] = $request->lastname;
        $data['suffix'] = $request->suffix;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = $request->input('role');
        $data['college_id'] = $request->input('college_id');
    
        // Create the user record in the database
        $user = User::create($data);
    
        // Save the year level in the database if the user is a student
        if ($data['role_id'] == 1) {
            $user->year_level = $request->input('year_level');
            $user->expiration_date = Carbon::now()->addYear()->month(6)->day(15);
            $user->student_number = $request->input('student_number');
            $user->save();
        }

        // update user's role to 'teacher' if the selected role is 'teacher'
        if ($data['role_id'] == 2) {
            $user->role_id = 2;
            $user->year_level = null;
            $user->expiration_date = null;
            $user->student_number = null;
            $user->save();
        }

        // Log the 'register' activity before registering
        \DB::table('activity_logs')->insert([
            'user_id' => $user->id,
            'activity' => 'has registered',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
        $user->verified = false;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new RegistrationEmail($user));

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

    private static function calculateExpiryDate($yearLevel) {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $yearLevelDifference = 5 - $yearLevel;

        $yearDifference = $currentYear + $yearLevelDifference;

        $expiration_date = Carbon::createFromDate($yearDifference, 06, 15);

        return $expiration_date;
    }

    function logout(){
        
        // Log the 'logout' activity before logging out
        if (Auth::check()) {
            $user = Auth::user();
            
            \DB::table('activity_logs')->insert([
                'user_id' => $user->id,
                'activity' => 'has logout',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Session::flush();
            Auth::logout();
        }
        
        
        return redirect(route('login'))->with('logout_message', true);
    }
}

