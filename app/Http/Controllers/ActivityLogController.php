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
        $activityLog = $this->queryActivityLogs()
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(15, ['*'], 'indexPage')
            ->onEachSide(1);

        $this->formatTimestamps($activityLog);

        return view('administrator.activity-log', compact('activityLog'));
    }

    public function filter(Request $request)
    {
        $filter = $request->get('activity_filter');

        $activityLog = $this->queryActivityLogs()
            ->where('activity_logs.activity', 'like', '%' . $filter . '%')
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(15, ['*'], 'filterPage')
            ->onEachSide(1);

        $this->formatTimestamps($activityLog);

        return view('administrator.activity-log', compact('activityLog'));
    }

    public function search(Request $request)
    {
        $search = $request->get('query');

        $activityLog = $this->queryActivityLogs()
            ->where(function ($query) use ($search) {
                $query->where('users.student_number', 'like', '%' . $search . '%')
                    ->orWhere('users.firstname', 'like', '%' . $search . '%')
                    ->orWhere('users.lastname', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('activity_logs.activity', 'like', '%' . $search . '%');
            })
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(15, ['*'], 'searchPage')
            ->onEachSide(1);

        $this->formatTimestamps($activityLog);

        return view('administrator.activity-log', compact('activityLog'));
    }

    private function queryActivityLogs()
    {
        return DB::table('activity_logs')
            ->join('users', 'users.id', '=', 'activity_logs.user_id')
            ->select('users.student_number', 'users.firstname', 'users.lastname', 'users.email', 'activity_logs.activity', 'activity_logs.created_at');
    }

    private function formatTimestamps($activityLog)
    {
        $activityLog->each(function ($log) {
            $log->created_at = Carbon::parse($log->created_at)->format('D, M d, Y h:i A');
        });
    }
}
