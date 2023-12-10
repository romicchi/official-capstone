<?php
namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AcademicsController extends Controller
{
    public function index()
    {
        $allCourses = Course::paginate(14);
        $colleges = College::with('courses')->paginate(10, ['*'], 'college_page');
        $courses = Course::with('college')->paginate(10, ['*'], 'course_page');
        $disciplines = Discipline::with('college')->paginate(10, ['*'], 'discipline_page');
        Paginator::useBootstrap();
    
        return view('academics.index', compact('colleges', 'allCourses', 'courses', 'disciplines'));
    }

    // College
    public function createCollege()
    {
        return view('academics.create_college');
    }

    public function storeCollege(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collegeName' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $college = new College();
        $college->collegeName = $request->input('collegeName');
        $college->save();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Added college',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('academics.index')->with('success', 'Successfully added college.');
    }

    public function editCollege($id)
    {
        $college = College::findOrFail($id);
        return view('academics.edit_college', compact('college'));
    }

    public function updateCollege(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'collegeName' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $college = College::findOrFail($id);
        $college->collegeName = $request->input('collegeName');
        $college->save();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Updated college',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('academics.index')->with('success', 'Successfully updated college.');
    }

    public function destroyCollege($id)
    {
        $college = College::findOrFail($id);

        // Set college_id to NULL for all users associated with the college
        foreach ($college->users as $user) {
            $user->college_id = null;
            $user->save();
        }    
    
        // Delete the college
        $college->delete();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Deleted college',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('academics.index')->with('success', 'Successfully deleted college, courses, and disciplines.');
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

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Added course',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Set active tab to "courses"
        $activeTab = 'courses';

        return redirect()->route('academics.index', compact('activeTab'))->with('success', 'Successfully added course.');
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

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Updated course',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $activeTab = 'courses';

        return redirect()->route('academics.index', compact('activeTab'))->with('success', 'Successfully updated course.');
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Deleted course',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Set active tab to "courses"
        $activeTab = 'courses';

        return redirect()->route('academics.index', compact('activeTab'))->with('success', 'Successfully deleted course.');
    }

    public function filterCourses(Request $request)
    {
        $collegeId = $request->input('college_filter');
        $colleges = College::with('courses')->paginate(10, ['*'], 'college_page');
        $allCourses = Course::paginate(10, ['*'], 'course_page');
        
        if ($collegeId) {
            $courses = Course::where('college_id', $collegeId)->paginate(10, ['*'], 'course_page');
        } else {
            $courses = Course::with('college')->paginate(10, ['*'], 'course_page');
        }
        
        $disciplines = Discipline::with('college')->paginate(10, ['*'], 'discipline_page');
        
        // Append the college_filter parameter to pagination
        $courses->appends(['college_filter' => $collegeId]);
        $disciplines->appends(['college_filter' => $collegeId]);
        
        Paginator::useBootstrap();
        
        $activeTab = 'courses';
        
        return view('academics.index', compact('colleges', 'courses', 'allCourses', 'activeTab', 'disciplines'));        
    }

    public function filterDisciplines(Request $request) 
    {
        $collegeId = $request->input('college_filter');
    
        $colleges = College::with('courses')->paginate(10, ['*'], 'college_page');
        $allCourses = Course::paginate(10, ['*'], 'course_page');
        $courses = Course::with('college')->paginate(10, ['*'], 'course_page');
        
        if ($collegeId) {
            $disciplines = Discipline::where('college_id', $collegeId)->paginate(10, ['*'], 'discipline_page');
        } else {
            $disciplines = Discipline::with('college')->paginate(10, ['*'], 'discipline_page');
        }
        
        // Append the college_filter parameter to pagination
        $disciplines->appends(['college_filter' => $collegeId]);
        
        Paginator::useBootstrap();
    
        $activeTab = 'disciplines';
        
        return view('academics.index', compact('colleges', 'courses', 'allCourses', 'activeTab', 'disciplines'));
    }


    
    // Disciplines
    public function createDiscipline()
    {
        return view('academics.create_disciplines');
    }

    public function storeDiscipline(Request $request)
    {
        $request->validate([
            'discipline_Name' => 'required',
            'college_id' => 'required',
        ]);

        $discipline = new Discipline();
        $discipline->disciplineName = $request->input('discipline_Name');
        $discipline->college_id = $request->input('college_id');

        $discipline->save();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Added discipline',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $activeTab = 'disciplines';

        return redirect()->route('academics.index', compact('activeTab'))->with('success', 'Successfully added discipline.');
    }

    public function editDiscipline($id)
    {
        $discipline = Discipline::findOrFail($id);
        return view('academics.edit_disciplines', compact('discipline'));
    }

    public function updateDiscipline(Request $request, $id)
    {
        $request->validate([
            'disciplineName' => 'required',
            'college_id' => 'required',
        ]);

        $discipline = Discipline::findOrFail($id);
        $discipline->disciplineName = $request->input('disciplineName');
        $discipline->college_id = $request->input('college_id');
        $discipline->save();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Updated discipline',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $activeTab = 'disciplines';

        return redirect()->route('academics.index', compact('activeTab'))->with('success', 'Successfully updated discipline.');
    }

    public function destroyDiscipline($id)
    {
        $discipline = Discipline::findOrFail($id);
        $discipline->delete();

        // log
        \DB::table('activity_logs')->insert([
            'user_id' => Auth::user()->id,
            'activity' => 'Deleted discipline',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $activeTab = 'disciplines';

        return redirect()->route('academics.index', compact('activeTab'))->with('success', 'Successfully deleted discipline.');
    }

    // Search Functionality
    public function searchCourse(Request $request)
    {
        $searchQuery = $request->input('course_search');

        $courses = Course::where('courseName', 'LIKE', "%$searchQuery%")->paginate(10, ['*'], 'course_page');
        $allCourses = Course::paginate(10, ['*'], 'course_page');
        $colleges = College::with('courses')->paginate(10, ['*'], 'college_page');
        $disciplines = Discipline::paginate(10, ['*'], 'discipline_page');
        Paginator::useBootstrap();

        $activeTab = 'courses';

        return view('academics.index', compact('colleges', 'courses', 'allCourses', 'activeTab', 'disciplines'));
    }

    public function searchDiscipline(Request $request)
    {
        $searchQuery = $request->input('discipline_search');

        $disciplines = Discipline::where('disciplineName', 'LIKE', "%$searchQuery%")->paginate(10, ['*'], 'discipline_page');
        $colleges = College::with('courses')->paginate(10, ['*'], 'college_page');
        $courses = Course::with('college')->paginate(10, ['*'], 'course_page');
        $allCourses = Course::paginate(10, ['*'], 'course_page');
        Paginator::useBootstrap();

        $activeTab = 'disciplines';

        return view('academics.index', compact('colleges', 'courses', 'allCourses', 'disciplines', 'activeTab'));
    }
}
