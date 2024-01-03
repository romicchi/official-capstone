<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Resource;

class HistoryController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user's history records
        $user = auth()->user();
        $history = $user->history;

        // Extract the resource IDs from the history records
        $resourceIds = $history->pluck('resource_id');

        // Retrieve the actual resources based on the extracted IDs
        $resources = Resource::whereIn('id', $resourceIds)->paginate(10);

        return view('history.index', compact('resources'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Get the currently authenticated user's history records
        $user = auth()->user();
        $history = $user->history;

        // Extract the resource IDs from the history records
        $resourceIds = $history->pluck('resource_id');

        // Retrieve the actual resources based on the extracted IDs
        $resources = Resource::whereIn('id', $resourceIds)
            ->where('title', 'LIKE', "%$query%")
            ->paginate(10);

        // If the request is AJAX, return the resources as JSON
        if ($request->ajax()) {
            return view('history.list', compact('resources'));
        }

        return view('history.index', compact('resources'));
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $history = $user->history()->where('resource_id', $id)->first();
        $history->delete();

        return redirect()->route('history.index')->with('success', 'History deleted successfully');
    }

    public function clear()
    {
        $user = auth()->user();
        $history = $user->history;
        $history->each->delete();

        return redirect()->route('history.index')->with('success', 'History cleared successfully');
    }
}
