<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
        return view('administrator.adminpage', compact('colleges', 'courses', 'subjects'));
    }


}
