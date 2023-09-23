<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
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
        
        // Pie Chart
        $studentCount = User::where('role_id', 1)->count(); // Student Count
        $teacherCount = User::where('role_id', 2)->count(); // Teacher Count
        $adminCount = User::where('role_id', 3)->count(); // Admin Count

        return view('administrator.adminpage', compact('verifiedUsersCount', 'totalResourcesCount', 'pendingUsersCount', 'activeUsersCount', 'studentCount', 'teacherCount', 'adminCount'));
    }

    public function getChartData(Request $request)
    {
        $interval = $request->input('interval');
    
        // Adjust the query based on the selected interval (day, week, month, year)
        $startDate = now();
        $endDate = now();
    
        $labels = []; // Initialize an array for labels
    
        // Corrected method: use sub instead of subInterval
        if ($interval === 'day') {
            $startDate->subDay();
            $labels = $this->generateLabelsForInterval('day', 7); // Generate labels for days
        } elseif ($interval === 'week') {
            $startDate->startOfWeek()->subWeek();
            $labels = $this->generateLabelsForInterval('week', 7); // Generate labels for weeks
        } elseif ($interval === 'month') {
            $startDate->subMonth();
            $labels = $this->generateLabelsForInterval('month', 12); // Generate labels for months
        } elseif ($interval === 'year') {
            $startDate->subYear();
            $labels = $this->generateLabelsForInterval('year', 12); // Generate labels for years
        }
    
        // Fetch the resource counts based on the corrected date range
        $resourceCounts = Resource::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($resource) use ($interval) {
                if ($interval === 'day') {
                    return $resource->created_at->format('M d');
                } elseif ($interval === 'week') {
                    return $resource->created_at->startOfWeek()->format('M d') . ' - ' . $resource->created_at->endOfWeek()->format('M d');
                } elseif ($interval === 'month') {
                    return $resource->created_at->format('M Y');
                } elseif ($interval === 'year') {
                    return $resource->created_at->format('Y');
                }
            })
            ->map(function ($item) {
                return $item->count();
            });
        // Create an array to hold resource counts for the selected interval
        $chartData = [];
    
        // Loop through labels to ensure they match the date range
        foreach ($labels as $label) {
            // If the label exists in the resource counts, add the count to the chart data
            if (isset($resourceCounts[$label])) {
                $chartData[] = $resourceCounts[$label];
            } else {
                // Otherwise, add 0 to the chart data
                $chartData[] = 0;
            }
        }
    
        return response()->json(['labels' => $labels, 'data' => $chartData]);
    }
    
    // Helper function to generate labels for different intervals
    private function generateLabelsForInterval($interval, $count)
    {
        $labels = [];
    
        for ($i = 0; $i < $count; $i++) {
            if ($interval === 'day') {
                $labels[] = now()->subDays($i)->format('M d');
            } elseif ($interval === 'week') {
                $startOfWeek = now()->startOfWeek()->subWeeks($i);
                $endOfWeek = now()->endOfWeek()->subWeeks($i);
                $labels[] = $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d');
            } elseif ($interval === 'month') {
                $labels[] = now()->subMonths($i)->format('M Y');
            } elseif ($interval === 'year') {
                $labels[] = now()->subYears($i)->format('Y');
            }
        }
    
        return array_reverse($labels);
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
