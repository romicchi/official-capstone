<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
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
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
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
        $user->verified = true;

        $user->url = $url;
        $user->save();

        $activeTab = 'existing';

        // Redirect the user back to the manage user page with a success message
        return redirect()->route('usermanage', compact('activeTab'))->with('success', 'User created successfully.');
    }    


    //display all users in the database
    public function show(Request $request)
    {
        $pendingUsers = User::with('role')->where('verified', false)->paginate(10, ['*'], 'pending_page');
        $existingUsers = User::with('role')->where('verified', true)->paginate(10, ['*'], 'existing_page');

        $existingUsersQuery = User::with('role')->where('verified', true);

        // Sorting
        $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
        $existingUsersQuery->orderBy('lastname', $sortOrder);
        $existingUsers = $existingUsersQuery->paginate(10);

        $activeTab = 'existing';
        $roles = Role::all();
        
        return view('administrator.usermanage', ['pendingUsers' => $pendingUsers, 'existingUsers' => $existingUsers, 'activeTab' => $activeTab, 'roles' => $roles]);
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
        $userdata->role_id = $req->role;
        $userdata->save();

        $activeTab = 'existing';

        return redirect()->route('usermanage', compact('activeTab'))->with('success', 'User updated successfully.');

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        $existingUsers = User::with('role')
            ->where('verified', true)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('firstname', 'like', '%' . $query . '%')
                    ->orWhere('lastname', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->paginate(10);
    
        $pendingUsers = User::with('role')
            ->where('verified', false)
            ->paginate(10);
    
        // Set the active tab to 'existing' since the search only affects existing users
        $activeTab = 'existing';
        $roles = Role::all();
    
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'activeTab' => $activeTab, //
            'roles' => $roles,
        ]);
    }
    
    public function filterByRole(Request $request)
    {
        $roleFilter = $request->input('role');
        
        $existingUsersQuery = User::with('role')->where('verified', true);
        
        if ($roleFilter != 'all') {
            $existingUsersQuery->where('role_id', $roleFilter);
        }
        
        $existingUsers = $existingUsersQuery->paginate(10);
        
        $pendingUsers = User::with('role')
        ->where('verified', false)
        ->paginate(10);
        
        $roles = Role::all();
        
        $activeTab = 'existing';
        
        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
        ]);
    }
    
    public function filterPendingByRole(Request $request)
    {
        $roleFilter = $request->input('role');

        $pendingUsersQuery = User::with('role')
            ->where('verified', false);

        if ($roleFilter != 'all') {
            $pendingUsersQuery->where('role_id', $roleFilter);
        }

        $pendingUsers = $pendingUsersQuery->paginate(10);

        $existingUsers = User::with('role')
            ->where('verified', true)
            ->paginate(10);

        $roles = Role::all();

        $activeTab = 'pending';

        return view('administrator.usermanage', [
            'pendingUsers' => $pendingUsers,
            'existingUsers' => $existingUsers,
            'roles' => $roles,
            'activeTab' => $activeTab,
        ]);
    }


    public function index()
    {
        $users = User::with('image')->get(); // Retrieve all users with their associated images
        
        return view('users.index', compact('users'));
    }
}
