<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCoursesByCollege($collegeId)
    {
        $courses = Course::where('college_id', $collegeId)->get();
    
        return response()->json($courses);
    }

}
