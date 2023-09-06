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

    public function generateReport()
    {
        // Fetch the data you want to include in the report
        $verifiedUsersCount = User::where('verified', true)->count();
        $totalResourcesCount = Resource::count();
        $pendingUsersCount = User::where('verified', false)->count();
        $activeUsersCount = User::where('last_activity', '>=', now()->subDays(3))
            ->whereNotIn('role_id', [3, 4])
            ->count();
    
        // Create a PDF using the data and your report template
        $pdf = PDF::loadView('administrator.generate_report', [
            'verifiedUsersCount' => $verifiedUsersCount,
            'totalResourcesCount' => $totalResourcesCount,
            'pendingUsersCount' => $pendingUsersCount,
            'activeUsersCount' => $activeUsersCount,
        ]);
    
        // Return the PDF as a downloadable file
        return $pdf->download('admin_report.pdf');
    }

}
