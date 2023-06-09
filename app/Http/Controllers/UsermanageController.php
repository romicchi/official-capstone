<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsermanageController extends Controller
{

    //show adminadd page
    public function showadminadd() 
    {  
        return view('administrator.adminadd');
    }

    // Method to create a new user
    public function addUser(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:admin,student,teacher,programcoordinator,departmentchair',
        ]);

        // Create the new user
        $user = new User();
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role = $validatedData['role'];
        $user->save();

        // Redirect the user back to the manage user page with a success message
        return redirect()->route('usermanage')->with('success', 'User created successfully.');
    }    


    //display all users in the database
    public function show() 
    {
        $userdata = User::all();
        return view('administrator.usermanage',['users'=>$userdata]);
    }

    function verifyUsers(){
        $users = User::where('verified', false)->get();
    
        return view('administrator.usermanage', ['users' => $users]);
    }
    
    function postVerifyUsers(Request $request){
        $verifiedUserIds = $request->input('verified_users', []);
        $rejectedUserIds = $request->input('rejected_users', []);
    
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
        $userdata->role = $req->role;
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

}
