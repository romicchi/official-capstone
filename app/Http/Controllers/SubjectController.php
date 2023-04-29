<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function getSubjectsByCourse($courseId)
    {
        $subjects = Subject::where('course_id', $courseId)->get();

        return response()->json($subjects);
    }

}
