<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $activityLog = DB::table('activity_logs')
            ->join('users', 'users.id', '=', 'activity_logs.user_id')
            ->select('users.student_number', 'users.firstname', 'users.lastname', 'users.email', 'activity_logs.activity', 'activity_logs.created_at')
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(25, ['*'], 'indexPage');

            $activityLog->each(function ($log) {
                $log->created_at = Carbon::parse($log->created_at)->format('D, M d, Y h:i A');
            });
            
        return view('administrator.activity-log', compact('activityLog'));
    }

    // filter
    public function filter(Request $request)
    {
        $filter = $request->get('activity_filter');
        // activity logs with student number
        $activityLog = DB::table('activity_logs')
            ->join('users', 'users.id', '=', 'activity_logs.user_id')
            ->select('users.student_number', 'users.firstname', 'users.lastname', 'users.email', 'activity_logs.activity', 'activity_logs.created_at')
            ->where('activity_logs.activity', 'like', '%' . $filter . '%')
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(25, ['*'], 'filterPage'); // Update the number of records per page here (e.g., 25)

        $activityLog->each(function ($log) {
            $log->created_at = Carbon::parse($log->created_at)->format('D, M d, Y h:i A');
        });

        return view('administrator.activity-log', compact('activityLog'));
    }

    // search
    public function search(Request $request)
    {
        $search = $request->get('query');
        $activityLog = DB::table('activity_logs')
            ->join('users', 'users.id', '=', 'activity_logs.user_id')
            ->select('users.student_number', 'users.firstname', 'users.lastname', 'users.email', 'activity_logs.activity', 'activity_logs.created_at')
            ->where('users.student_number', 'like', '%' . $search . '%')
            ->orWhere('users.firstname', 'like', '%' . $search . '%')
            ->orWhere('users.lastname', 'like', '%' . $search . '%')
            ->orWhere('users.email', 'like', '%' . $search . '%')
            ->orWhere('activity_logs.activity', 'like', '%' . $search . '%')
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(25, ['*'], 'searchPage'); // Update the number of records per page here (e.g., 25)

        $activityLog->each(function ($log) {
            $log->created_at = Carbon::parse($log->created_at)->format('D, M d, Y h:i A');
        });

        return view('administrator.activity-log', compact('activityLog'));
    }

}
