<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;     
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:student,teacher'
        ]);

        $data['name'] = $request->name; //assign the name fron the request variable to data variable
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->input('role');
        $data['verified'] = false; // Set the verified field to false
        $user = User::create($data); //this will create the user

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

