<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        return view('settings', [
            'user' => auth()->user(),
            'success' => session('success'),
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with('password_success', 'Password changed successfully');
        } else {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
    
        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ]);
    
        $user->update($validatedData);
    
        return redirect()->back()->with('profile_success', 'Profile information updated successfully');
    }
    
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
    
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $user->password = Hash::make($request->input('password'));
        $user->save();
    
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
    

}

