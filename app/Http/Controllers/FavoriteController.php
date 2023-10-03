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

    public function search(Request $request)
    {
        $search = $request->get('query');
        $user = auth()->user();
        $resources = $user->favorites()
            ->where('title', 'like', '%' . $search . '%')
            ->orWhere('author', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('favorites', compact('resources', 'user'));
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $user->favorites()->detach($id);

        return redirect()->route('favorites');
    }

    public function clear()
    {
        $user = auth()->user();
        $user->favorites()->detach();

        return redirect()->route('favorites');
    }
    
}

