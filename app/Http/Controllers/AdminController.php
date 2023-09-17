<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PDF;

class AdminController extends Controller
{

    public function dashboard()
    {
        // Cards
        $verifiedUsersCount = User::where('verified', true)->count();
        $totalResourcesCount = Resource::count();
        $pendingUsersCount = User::where('verified', false)->count();

        // Calculate the count of active users based on number of days (criteria)
        $activeUsersCount = User::where('last_activity', '>=', now()->subDays(3)) // For example, consider users who logged in within the last 3 days as active
        ->whereNotIn('role_id', [3, 4]) // Exclude users with role_id 3 (admin) and 4 (super-admin)
        ->count();

        // Calculate the count of resources uploaded for each month in the last year
        $resourceCounts = Resource::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month');
        
        // Create an array to hold resource counts for each month of the year
        $resourceData = [];
        for ($month = 1; $month <= 12; $month++) {
            $resourceData[] = $resourceCounts[$month] ?? 0;
        }
        
        // Pie Chart
        $studentCount = User::where('role_id', 1)->count(); // Student Count
        $teacherCount = User::where('role_id', 2)->count(); // Teacher Count
        $adminCount = User::where('role_id', 3)->count(); // Admin Count

        return view('administrator.adminpage', compact('verifiedUsersCount', 'totalResourcesCount', 'pendingUsersCount', 'activeUsersCount', 'studentCount', 'teacherCount', 'adminCount', 'resourceData'));
    }

    public function generateReport(Request $request)
    {
        $period = $request->input('report_period');
        
        // Determine the date range based on the selected period
        $startDate = now();
        $endDate = now();
        
        if ($period === 'month') {
            $startDate->startOfMonth();
            $endDate->endOfMonth();
        } elseif ($period === 'year') {
            $startDate->startOfYear();
            $endDate->endOfYear();
        } else {
            // Default to day
            $startDate->startOfDay();
            $endDate->endOfDay();
        }
        
        // Fetch the data you want to include in the report
        $reportData = [];
        
        // Query the users based on their roles and the selected period
        $roles = ['student', 'teacher', 'admin', 'super-admin'];
        
        foreach ($roles as $role) {
            $userCount = User::where('role_id', function ($query) use ($role) {
                    $query->select('id')->from('roles')->where('role', $role);
                })
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
        
            $reportData[$role] = $userCount;
        }
        
        // Load the view with the report data
        return view('administrator.generate_report', ['reportData' => $reportData]);
    }
    

    public function generatePDFReport(Request $request)
    {
        $period = $request->input('report_period');
        
        // Determine the date range based on the selected period
        $startDate = now();
        $endDate = now();
        
        if ($period === 'month') {
            $startDate->startOfMonth();
            $endDate->endOfMonth();
        } elseif ($period === 'year') {
            $startDate->startOfYear();
            $endDate->endOfYear();
        } else {
            // Default to day
            $startDate->startOfDay();
            $endDate->endOfDay();
        }
        
        // Fetch the data you want to include in the report
        $reportData = [];
        
        // Query the users based on their roles and the selected period
        $roles = ['student', 'teacher', 'admin', 'super-admin'];
        
        foreach ($roles as $role) {
            $userCount = User::where('role_id', function ($query) use ($role) {
                    $query->select('id')->from('roles')->where('role', $role);
                })
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
        
            $reportData[$role] = $userCount;
        }
        
        // Load the PDF view with the report data
        $pdf = PDF::loadView('administrator.generate_report_pdf', ['reportData' => $reportData]);
        
        // Generate and return the PDF as a download
        return $pdf->download('report.pdf');
    }
    
}
