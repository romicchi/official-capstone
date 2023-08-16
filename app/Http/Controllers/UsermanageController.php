<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;  
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
            'role' => 'required|in:1,2,3',
        ]);

        
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
    

        // Create the new user
        $user = new User();
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role_id = $validatedData['role'];

        $user->url = $url;
        $user->save();

        // Redirect the user back to the manage user page with a success message
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
