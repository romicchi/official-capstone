<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function store()
    {
        //
    }

    public function showTeacherManage()
    {
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('teachermanage')->with(compact('courses', 'subjects'));
    }

    public function showResourceManage() 
    {
        $userdata = User::all();
        return view('resourcemanage',['resources'=>$resourcedata]);
    }

    public function download($Request ) 
    {
        //
    }




}
