<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function store()
    {
        //
    }

    public function showTeacherManage()
    {
        $resources = Resource::all();
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('teacher.teachermanage', compact('resources', 'colleges', 'courses', 'subjects'));
    }

    public function showResourceManage()
    {
        $resources = Resource::all();
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('resourcemanage', compact('resources', 'colleges', 'courses', 'subjects'));
    }

    public function showAdminResourceManage()
    {
        $resources = Resource::all();
        $colleges = College::all();
        $courses = Course::all();
        $subjects = Subject::all();
    
        return view('administrator.adminresourcemanage', compact('resources', 'colleges', 'courses', 'subjects'));
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


}

