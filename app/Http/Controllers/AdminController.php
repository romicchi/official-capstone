<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Resource;
use App\Models\Discussion;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Google_Client;
use Google_Service_Drive;
use Google\Cloud\Storage\StorageClient;
use Session;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDriveService;
use Carbon\Carbon;
use PDF;

class AdminController extends Controller
{

    private static function getGoogleDriveAccessToken()
    {
        $jsonKeyFilePath = base_path('resources/credentials/generapp-c64fbc26723c.json'); // Replace with the path to your JSON key file
        $jsonKey = file_get_contents($jsonKeyFilePath);

        $googleClient = new GoogleClient();
        $googleClient->setAuthConfig(json_decode($jsonKey, true));
        $googleClient->setScopes([\Google_Service_Drive::DRIVE]);
        $googleClient->fetchAccessTokenWithAssertion();

        return $googleClient->getAccessToken()['access_token'];
    }
    

    public function dashboard()
    {
        // Retrieve the top 10 most favorite resources
        $mostFavoriteResources = Resource::withCount('favoritedBy') // Use 'favoritedBy' instead of 'favorites'
        ->orderBy('favorited_by_count', 'desc') // Use 'favorited_by_count' instead of 'favorites_count'
        ->take(10) // You can change this number as needed
        ->get();
        
        // Retrieve the top 10 most replied discussion
        $mostRepliedDiscussions = Discussion::withCount('replies')
        ->orderBy('replies_count', 'desc')
        ->take(10)
        ->get();

        // Cards
        $verifiedUsersCount = User::where('verified', true)
        ->whereIn('role_id', [1, 2])
        ->count();        
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

        $totalUsers = $studentCount + $teacherCount + $adminCount;

        $studentsPercentage = $totalUsers > 0 ? ($studentCount / $totalUsers) * 100 : 0;
        $teachersPercentage = $totalUsers > 0 ? ($teacherCount / $totalUsers) * 100 : 0;
        $adminsPercentage = $totalUsers > 0 ? ($adminCount / $totalUsers) * 100 : 0;

        return view('administrator.adminpage', 
        compact(
            'verifiedUsersCount', 
            'totalResourcesCount', 
            'pendingUsersCount', 
            'activeUsersCount', 
            'studentCount', 
            'teacherCount', 
            'adminCount', 
            'mostFavoriteResources',
            'mostRepliedDiscussions', 
            'studentsPercentage', 
            'teachersPercentage', 
            'adminsPercentage'));
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
            $startDate->subDay(7);
            $labels = $this->generateLabelsForInterval('day', 7); // Generate labels for days
        } elseif ($interval === 'week') {
            $startDate->startOfWeek()->subWeek(7);
            $labels = $this->generateLabelsForInterval('week', 7); // Generate labels for weeks
        } elseif ($interval === 'month') {
            $startDate->subMonth(12);
            $labels = $this->generateLabelsForInterval('month', 12); // Generate labels for months
        } elseif ($interval === 'year') {
            $startDate->subYear(12);
            $labels = $this->generateLabelsForInterval('year', 12); // Generate labels for years
        }
    
        // Fetch the resource counts based on the corrected date range
        $resourceCounts = Resource::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($resource) use ($interval) {
                if ($interval === 'day') {
                    return $resource->created_at->startOfDay()->format('M d');
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedReportType = $request->input('report_type');
        $selectedResourceType = $request->input('selected_resource_type');
        
        // Fetch the data you want to include in the report
        $reportData = [];
        
        // Query the users based on their roles and the selected date range
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedReportType = $request->input('report_type');
        $selectedResourceType = $request->input('selected_resource_type');
        
        // Determine the user's role (student or teacher)
        $userRole = Auth::user()->role->role;
        
        // Fetch the colleges from your database, assuming you have a College model
        $colleges = College::all();

        $data = [];
        
        if ($selectedReportType === 'user') {
        // Calculate totals for each year and all years for students
            $totalFirstYear = User::where('role_id', 1)
                ->where('year_level', 1)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            // totalSecondYear
            $totalSecondYear = User::where('role_id', 1)
                ->where('year_level', 2)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            // totalThirdYear
            $totalThirdYear = User::where('role_id', 1)
                ->where('year_level', 3)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            // totalFourthYear
            $totalFourthYear = User::where('role_id', 1)
                ->where('year_level', 4)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            $totalAllYears = $totalFirstYear + $totalSecondYear + $totalThirdYear + $totalFourthYear;

            // total teachers
            $totalTeachers = User::where('role_id', 2)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();
               
        
            $data = [
                'colleges' => $colleges,
                'totalFirstYear' => $totalFirstYear,
                'totalSecondYear' => $totalSecondYear,
                'totalThirdYear' => $totalThirdYear,
                'totalFourthYear' => $totalFourthYear,
                'totalAllYears' => $totalAllYears,
                'totalTeachers' => $totalTeachers,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];

        } elseif ($selectedReportType === 'resources') {
            // Calculate total resources for each college
            $totalResources = [];
    
            foreach ($colleges as $college) {
                $resources = Resource::where('college_id', $college->id)
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();

                $totalResources[$college->collegeName] = $resources->count();
    
            }
    
            $data = [
                'colleges' => $colleges,
                'totalResources' => $totalResources,
                'startDate' => $startDate, // Pass start date to the view
                'endDate' => $endDate,     // Pass end date to the view
            ];
        } elseif ($selectedReportType === 'resources_specific') {
            $selectedResourceType = $request->input('selected_resource_type'); // Get the selected resource type from the hidden input

            // Initialize the Google Drive service
            $googleClient = new GoogleClient();
            $googleClient->setAccessToken(self::getGoogleDriveAccessToken());
            $googleDrive = new GoogleDriveService($googleClient);
            
            // Fetch resources based on the selected resource type and date range
            $allowedExtensions = [];
    
            // Determine allowed file extensions based on the selected resource type
            if ($selectedResourceType === 'text_based') {
                $allowedExtensions = ['pdf', 'docx', 'pptx'];
            } elseif ($selectedResourceType === 'video_based') {
                $allowedExtensions = ['mp4', 'avi', 'mov', 'webm', 'mkv', 'flv', 'wmv', '3gp', 'm4v', 'ogg'];
            } elseif ($selectedResourceType === 'image_based') {
                $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff', 'webp'];
            }

    // Fetch resources and filter them based on the allowed file extensions
    $resources = Resource::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
        ->get()
        ->filter(function ($resource) use ($allowedExtensions, $googleDrive) {
            $fileUrl = $resource->url;
            $fileId = $this->getFileIdFromUrl($fileUrl);

            // Use the Google Drive API to fetch file metadata
            $fileMetadata = $googleDrive->files->get($fileId, ['fields' => 'fileExtension']);

            if ($fileMetadata && isset($fileMetadata->fileExtension)) {
                $extension = $fileMetadata->fileExtension;

                // Check if the extension is in the allowed list
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    return true;
                }
            }

            return false;
        });

    
            $data = [
                'resources' => $resources,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'selectedResourceType' => $selectedResourceType,
            ];
        }

        
        // Load the appropriate PDF view with the report data
        $pdfView = ($selectedReportType === 'user') ? 'administrator.generate_report_pdf' : ($selectedReportType === 'resources' ? 'administrator.generate_resources_report' : ($selectedReportType === 'resources_specific' ? 'administrator.generate_resources_specific' : 'administrator.generate_resources_specific'));
        
        $pdf = PDF::loadView($pdfView, $data);
        
        // Generate and return the PDF as a download
        if ($selectedReportType === 'user') {
            return $pdf->download('report.pdf');
        } elseif ($selectedReportType === 'resources') {
            return $pdf->download('resources_report.pdf');
        } elseif ($selectedReportType === 'resources_specific') {
            return $pdf->download('resources_specific.pdf');
        }
    }

    public function updateReportTable(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedReportType = $request->input('report_type');
        $selectedResourceType = $request->input('selected_resource_type'); // Get the selected resource type from the hidden input

        // Initialize the Google Drive service
        $googleClient = new GoogleClient();
        $googleClient->setAccessToken(self::getGoogleDriveAccessToken());
        $googleDrive = new GoogleDriveService($googleClient);
        
        // Fetch resources based on the selected resource type and date range
        $allowedExtensions = [];

        // Determine allowed file extensions based on the selected resource type
        if ($selectedResourceType === 'text_based') {
            $allowedExtensions = ['pdf', 'docx', 'pptx'];
        } elseif ($selectedResourceType === 'video_based') {
            $allowedExtensions = ['mp4', 'avi', 'mov', 'webm', 'mkv', 'flv', 'wmv', '3gp', 'm4v', 'ogg'];
        } elseif ($selectedResourceType === 'image_based') {
            $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff', 'webp'];
        }

    // Fetch resources and filter them based on the allowed file extensions
    $resources = Resource::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
        ->get()
        ->filter(function ($resource) use ($allowedExtensions, $googleDrive) {
            $fileUrl = $resource->url;
            $fileId = $this->getFileIdFromUrl($fileUrl);

            // Use the Google Drive API to fetch file metadata
            $fileMetadata = $googleDrive->files->get($fileId, ['fields' => 'fileExtension']);

            if ($fileMetadata && isset($fileMetadata->fileExtension)) {
                $extension = $fileMetadata->fileExtension;

                // Check if the extension is in the allowed list
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    return true;
                }
            }

            return false;
        });


        // Fetch the data based on the selected report type and date range
        $colleges = College::all(); // Fetch colleges from the database

                // Calculate totals for each year and all years for students
                $totalFirstYear = User::where('role_id', 1)
                ->where('year_level', 1)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            // totalSecondYear
            $totalSecondYear = User::where('role_id', 1)
                ->where('year_level', 2)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            // totalThirdYear
            $totalThirdYear = User::where('role_id', 1)
                ->where('year_level', 3)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            // totalFourthYear
            $totalFourthYear = User::where('role_id', 1)
                ->where('year_level', 4)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            $totalAllYears = $totalFirstYear + $totalSecondYear + $totalThirdYear + $totalFourthYear;

            // total teachers
            $totalTeachers = User::where('role_id', 2)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        if ($selectedReportType === 'user') {
            // Load the generate_report_pdf view for the user report
            return view('administrator.generate_report_pdf', [
                'colleges' => $colleges,
                'totalFirstYear' => $totalFirstYear,
                'totalSecondYear' => $totalSecondYear,
                'totalThirdYear' => $totalThirdYear,
                'totalFourthYear' => $totalFourthYear,
                'totalAllYears' => $totalAllYears,
                'totalTeachers' => $totalTeachers,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ])->render();
        } elseif ($selectedReportType === 'resources') {
            // Load the generate_resources_report view for the resource report
            return view('administrator.generate_resources_report', [
                'colleges' => $colleges,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ])->render();            
        } elseif ($selectedReportType === 'resources_specific') {
            // Load the generate_resources_report view for the resource report
            return view('administrator.generate_resources_specific', [
                'resources' => $resources,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'selectedResourceType' => $selectedResourceType,
            ])->render();            
        } else {
            // Handle other report types or show an error message
            return '<center><p>Select a report type.</p></center>';
        }
    }

    // Helper function to extract the file ID from the Google Drive URL
private function getFileIdFromUrl($fileUrl)
{
    $matches = [];
    if (preg_match('/[?&]id=([^&]+)/', $fileUrl, $matches)) {
        return $matches[1];
    }
    return null;
}
    
    
}
