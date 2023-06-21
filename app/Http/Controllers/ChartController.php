<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChartController extends Controller
{
    public function showDashboard()
    {
        $studentsCount = User::where('role_id', 1)->count();
        $teachersCount = User::where('role_id', 2)->count();
        return view('dashboard', compact('studentsCount', 'teachersCount'));
    }
}
