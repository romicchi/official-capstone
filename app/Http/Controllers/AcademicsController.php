<?php
namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class AcademicsController extends Controller
{
    public function index()
    {
        $colleges = College::with('courses')->paginate(5, ['*'], 'college_page');
        $courses = Course::with('college')->paginate(10, ['*'], 'course_page');
        $subjects = Subject::with('course')->paginate(2, ['*'], 'subject_page');
        Paginator::useBootstrap();
    
        return view('academics.index', compact('colleges', 'courses', 'subjects'));
    }

    // College

    public function createCollege()
    {
        return view('academics.create_college');
    }

    public function storeCollege(Request $request)
    {
        $request->validate([
            'collegeName' => 'required',
        ]);

        $college = new College();
        $college->collegeName = $request->input('collegeName');
        $college->save();

        return redirect()->route('academics.createCollege')->with('success', 'Successfully added college.');
    }

    public function editCollege($id)
    {
        $college = College::findOrFail($id);
        return view('academics.edit_college', compact('college'));
    }

    public function updateCollege(Request $request, $id)
    {
        $request->validate([
            'collegeName' => 'required',
        ]);

        $college = College::findOrFail($id);
        $college->collegeName = $request->input('collegeName');
        $college->save();

        return redirect()->route('academics.index')->with('success', 'Successfully updated college.');
    }

    public function destroyCollege($id)
    {
        $college = College::findOrFail($id);
    
        // Get all the courses associated with the college
        $courses = $college->courses;
    
        // Loop through each course and delete its associated subjects
        foreach ($courses as $course) {
            $course->subjects()->delete();
        }
    
        // Delete the courses
        $courses->each->delete();
    
        // Delete the college
        $college->delete();
    
        return redirect()->route('academics.index')->with('success', 'Successfully deleted college, courses, and subjects.');
    }
    


    // Course

    public function createCourse()
    {
        return view('academics.create_course');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'courseName' => 'required',
            'college_id' => 'required',
        ]);

        $course = new Course();
        $course->courseName = $request->input('courseName');
        $course->college_id = $request->input('college_id');
        $course->save();

        return redirect()->route('academics.createCourse')->with('success', 'Successfully added course.');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('academics.edit_course', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'courseName' => 'required',
            'college_id' => 'required',
        ]);

        $course = Course::findOrFail($id);
        $course->courseName = $request->input('courseName');
        $course->college_id = $request->input('college_id');
        $course->save();

        return redirect()->route('academics.index')->with('success', 'Successfully updated course.');
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->subjects()->delete(); // Delete associated subjects
        $course->delete();

        return redirect()->route('academics.index')->with('success', 'Successfully deleted course.');
    }

    // Subject

    public function createSubject()
    {
        $courses = Course::all();
        return view('academics.create_subject', compact('courses'));
    }

    public function storeSubject(Request $request)
    {
        $request->validate([
            'subjectName' => 'required',
            'course_id' => 'required',
        ]);

        $subject = new Subject();
        $subject->subjectName = $request->input('subjectName');
        $subject->course_id = $request->input('course_id');
        $subject->save();

        return redirect()->route('academics.createSubject')->with('success', 'Successfully added subject.');
    }

    public function editSubject($id)
    {
        $subject = Subject::findOrFail($id);
        return view('academics.edit_subject', compact('subject'));
    }

    public function updateSubject(Request $request, $id)
    {
        $request->validate([
            'subjectName' => 'required',
            'course_id' => 'required',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->subjectName = $request->input('subjectName');
        $subject->course_id = $request->input('course_id');
        $subject->save();

        return redirect()->route('academics.index')->with('success', 'Successfully updated subject.');
    }

    public function destroySubject($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('academics.index')->with('success', 'Successfully deleted subject.');
    }


    // Search Functionality
    public function searchCourse(Request $request)
    {
        $searchQuery = $request->input('course_search');

        $courses = Course::where('courseName', 'LIKE', "%$searchQuery%")->paginate(10, ['*'], 'course_page');
        $colleges = College::with('courses')->paginate(5, ['*'], 'college_page');
        $subjects = Subject::with('course')->paginate(5, ['*'], 'subject_page');
        Paginator::useBootstrap();

        return view('academics.index', compact('colleges', 'courses', 'subjects'));
    }

    public function searchSubject(Request $request)
    {
        $searchQuery = $request->input('subject_search');

        $courses = Course::paginate(10, ['*'], 'course_page');
        $colleges = College::paginate(10, ['*'], 'college_page');
        $subjects = Subject::where('subjectName', 'LIKE', "%$searchQuery%")->paginate(2, ['*'], 'subject_page');
        Paginator::useBootstrap();

        return view('academics.index', compact('colleges', 'courses', 'subjects'));
    }
}
