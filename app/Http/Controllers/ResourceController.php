<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;

class ResourceController extends Controller
{
    public function store()
    {
        //
    }

    public function showTeacherManage()
    {
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('teachermanage')->with(compact('colleges','courses', 'subjects'));
    }

    public function getCoursesByCollege($collegeId)
    {
        $courses = Course::where('college_id', $collegeId)->get();

        return response()->json($courses);
    }

    public function getSubjectsByCourse($courseId)
    {   
        $subjects = Subject::where('course_id', $courseId)->get();  

        return response()->json($subjects);
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
