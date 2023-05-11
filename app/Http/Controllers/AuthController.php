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

    function loginPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            // Update user's last activity timestamp
            $user = Auth::user();
            $user->last_activity = Carbon::now();
            $user->save();
            
            return redirect()->intended(route('dashboard'));
        }
        return redirect(route('login'))->with("error", "login credentials are not valid!"); //with("key", "error message") and inside the route is the name in get
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
        return redirect(route('login'))->with("success", "Registration success, you can now Login."); //with("key", "success message") and inside the route is the name in get
        
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'))->with('logout_message', true);
    }
}

