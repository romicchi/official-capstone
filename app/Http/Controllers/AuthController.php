<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;  
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use App\Models\User;
use Carbon\Carbon;

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
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // If user is not verified then redirect to login
            if (!$user->verified) {
                Auth::logout();
                return redirect(route('login'))->with("error", "Your account is not yet verified. Please wait for the administrator to verify your user credentials. Thank you for your patience.");
            }
            
            // Update user's last activity timestamp
            $user->last_activity = Carbon::now();
            $user->save();
    
            if ($user->role === 'admin') {
                // Redirect to admin page for admin user
                return redirect()->intended(route('adminpage'));
            }
    
            return redirect()->intended(route('dashboard'));
        }
    
        return redirect(route('login'))->with("error", "Account does not exist.");
    }

    function registerPost(Request $request){
        $request->validate([
            'id' => 'required|file|mimes:jpeg,jpg,png|max:8192',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:student,teacher'
        ]);

        $data['firstname'] = $request->firstname; //assign the name from the request variable to data variable
        $data['lastname'] = $request->lastname;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->input('role');
        $data['verified'] = false; // Set the verified field to false
        $user = User::create($data); //this will create the user

        $firebase_storage_path = 'IDs/';
        $file = $request->file('id');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;
        $localPath = storage_path('app/' . $file->storeAs('public', $filename));
                    $uploadedFile = fopen($localPath, 'r');
                    app('firebase.storage')->getBucket()->upload($uploadedFile, [
            'name' => $firebase_storage_path . $filename,
        ]);
        
        $file = $request->file('id');
        $path = $file->store('public');
        $url = Storage::url($path);
        $url = app('firebase.storage')->getBucket()->object($firebase_storage_path . $filename)->signedUrl(new \DateTime('tomorrow'));
        
        $user->url = $url;
        $user->save();

         // update user's role to 'teacher' if the selected role is 'teacher'
        if ($data['role'] === 'teacher') {
            $user->role = 'teacher';
            $user->save();
        }

        if(!$user) {
        return redirect(route('register'))->with("error", "Registration failed, try again."); //with("key", "error message") and inside the route is the name in get
        }
        // redirect to login after successfully registered
        return redirect(route('login'))->with("success", "Registration successful. Please wait for verification."); //with("key", "success message") and inside the route is the name in get
        
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'))->with('logout_message', true);
    }
}

