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
        return view('administrator.adminpage');
    }


}
