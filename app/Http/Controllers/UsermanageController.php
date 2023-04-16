<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsermanageController extends Controller
{
    //display all users in the database
    public function show() 
    {
        $userdata = User::all();
        return view('administrator.usermanage',['users'=>$userdata]);
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
        $userdata->name = $req->name;
        $userdata->email = $req->email;
        $userdata->password = $req->password;
        $userdata->role = $req->role;
        $userdata->save();
        return redirect()->route('usermanage');
    }

    public function search() 
    {
        $search = $_GET['query'];
        $userdata = User::where('name','like','%'.$search.'%')->get();
        return view('administrator.usermanage',['users'=>$userdata]);
    }

}
