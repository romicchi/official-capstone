<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function showFavorites()
    {
        $user = auth()->user();
        $resources = $user->favorites()->paginate(10);
        
        return view('favorites', compact('resources', 'user'));
    }
    
}

