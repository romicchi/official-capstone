<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\College;
use App\Models\Course;
use App\Models\Subject;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
        view()->share('colleges', $colleges);
        view()->share('courses', $courses);
        view()->share('subjects', $subjects);
        
        $this->middleware('auth')->only(['create', 'store']);

    }
}
