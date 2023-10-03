<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function showDashboard(Request $request)
    {
        $studentsCount = User::where('role_id', 1)->count();
        $teachersCount = User::where('role_id', 2)->count();
    
    return view('dashboard', compact('studentsCount', 'teachersCount'));
    }

    public function getRecommendations(Request $request)
    {
        $query = $request->input('query');
        $resources = Resource::where('topic', 'like', '%' . $query . '%')
            ->orWhere('title', 'like', '%' . $query . '%')
            ->orWhere('keywords', 'like', '%' . $query . '%')
            ->select('url')
            ->paginate(5);

        return view('recommendations', compact('resources'));
    }

}