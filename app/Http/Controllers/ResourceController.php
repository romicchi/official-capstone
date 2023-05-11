<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;



class ResourceController extends Controller
{
    public function store()
    {
        //
    }

    //--------------TEACHER-----------------//
    public function showTeacherManage()
    {
        $resources = Resource::paginate(10);
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('teacher.teachermanage', compact('resources', 'colleges', 'courses', 'subjects'));
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

    public function download($Request ) 
    {
        //
    }

    // Store resource function for Teacher
    public function storeResource(Request $request)
    {
    // Validate the form data
    $validatedData = $request->validate([
        'title' => 'required',
        'topic' => 'required',
        'keywords' => 'required',
        'author' => 'required',
        'description' => 'required',
        'college' => 'required',
        'course' => 'required',
        'subject' => 'required',
        'resourceType' => 'required|file',
    ]);

    // Handle file upload
    if ($request->hasFile('resourceType')) {
        $file = $request->file('resourceType');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('resources', $fileName); 
    } else {
        // Handle file not found error
    }

    // Create a new resource instance
    $resource = new Resource();
    $resource->title = $validatedData['title'];
    $resource->topic = $validatedData['topic'];
    $resource->keywords = $validatedData['keywords'];
    $resource->author = $validatedData['author'];
    $resource->description = $validatedData['description'];
    $resource->college_id = $validatedData['college'];
    $resource->course_id = $validatedData['course'];
    $resource->subject_id = $validatedData['subject'];
    $resource->resourceType = $fileName; // Assuming 'file_path' is the column to store the file path
    $resource->save();

    // Redirect or perform additional actions as needed
    return redirect()->back()->with('success', 'Resource added successfully.');
    }

    // Delete resource function
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->back()->with('success', 'Resource deleted successfully.');
    }

    // Edit resource function
    public function edit(Resource $resource)
    {    
        $resources = Resource::all();
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
        return view('teacher.edit', compact('resource', 'colleges', 'courses', 'subjects'));
    }

    // Update resource function
    public function update(Request $request, Resource $resource)
    {
        $resource->update($request->all());

        return redirect()->route('teacher.manage')->with('success', 'Resource updated successfully.');
    }

    //-------DEPARTMENTCHAIR-PROGCOORDINATOR--------------//
    public function showResourceManage(Request $request)
    {
        $resources = Resource::paginate(5);
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('resourcemanage', compact('resources', 'colleges', 'courses', 'subjects'));
    }
    
    public function searchResources(Request $request)
    {
        $query = $request->input('query');
        $resources = Resource::where('resourceStatus', 0)
            ->orWhere('resourceStatus', 1)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('title', 'LIKE', '%' . $query . '%')
                        ->orWhere('author', 'LIKE', '%' . $query . '%')
                        ->orWhere('created_at', 'LIKE', '%' . $query . '%');
                })
                ->orWhereHas('subject', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('subjectName', 'LIKE', '%' . $query . '%');
                });
            })
            ->get();

        return view('resourcemanage', compact('resources'));
    }

    public function approve(Resource $resource)
    {
        $resource->resourceStatus = 1;
        $resource->save();
    
        return redirect()->route('resourcemanage')->with('success', 'Resource has been approved.');
    }

    public function disapprove(Resource $resource)
     {
         $resource->resourceStatus = 0;
         $resource->save();

         return redirect()->route('resourcemanage')->with('success', 'Resource has been disapproved.');
     }

     //--------------ADMIN-----------------//
    public function showAdminResourceManage()
    {
        $resources = Resource::paginate(10);
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('administrator.adminresourcemanage', compact('resources', 'colleges', 'courses', 'subjects'));
    }
    public function adminapprove(Resource $resource)
    {
        $resource->resourceStatus = 1;
        $resource->save();
    
        return redirect()->route('adminresourcemanage')->with('success', 'Resource has been approved.');
    }

    public function admindisapprove(Resource $resource)
     {
         $resource->resourceStatus = 0;
         $resource->save();

         return redirect()->route('adminresourcemanage')->with('success', 'Resource has been disapproved.');
     }
     public function adminsearchResources(Request $request)
     {
         $query = $request->input('query');
         $resources = Resource::where('resourceStatus', 0)
             ->orWhere('resourceStatus', 1)
             ->where(function ($queryBuilder) use ($query) {
                 $queryBuilder->where(function ($queryBuilder) use ($query) {
                     $queryBuilder->where('title', 'LIKE', '%' . $query . '%')
                         ->orWhere('author', 'LIKE', '%' . $query . '%')
                         ->orWhere('created_at', 'LIKE', '%' . $query . '%');
                 })
                 ->orWhereHas('subject', function ($queryBuilder) use ($query) {
                     $queryBuilder->where('subjectName', 'LIKE', '%' . $query . '%');
                 });
             })
             ->paginate(10);
     
         return view('administrator.adminresourcemanage', compact('resources'));
     }
    
     


    //---------Subject Resources----------//
    public function showSubjectResources(Subject $subject)
    {
        $resources = Resource::paginate(10);
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('subjects.quantitative', compact('resources', 'colleges', 'courses', 'subjects'));
    }
}



