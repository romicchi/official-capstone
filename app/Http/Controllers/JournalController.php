<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        // Retrieve journals with matching titles
        $matchingJournals = Journal::where('title', 'like', "%$search%");
    
        // Retrieve remaining journals
        $otherJournals = Journal::where('title', 'not like', "%$search%");
    
        // Merge the two sets of journals
        $journals = $matchingJournals->union($otherJournals)->paginate(5);
    
        return view('journals.index', compact('journals', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('journals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'nullable',
        ]);
    
        // Check if the title exceeds the maximum word limit
        if (str_word_count($validatedData['title']) > 100) {
            return redirect()->back()->withErrors(['title' => 'The title exceeds the maximum allowed word limit.']);
        }
    
        // Check if the content exceeds the maximum word limit
        if ($validatedData['content'] !== null && str_word_count($validatedData['content']) > 65535) {
            return redirect()->back()->withErrors(['content' => 'The content exceeds the maximum allowed word limit.']);
        }
    
        $journal = Journal::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => auth()->user()->id,
        ]);
    
        $user = auth()->user();
        $user->journals()->save($journal);
    
        return redirect()->route('journals.show', $journal);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
        
        return view('journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
    
        $validatedData = $request->validate([
            'title' => 'required|max:100', // Set the maximum length as per your requirement
            'content' => 'nullable',
        ]);
    
        // Check if the title exceeds the maximum length
        if (strlen($validatedData['title']) > 100) {
            return redirect()->back()->withErrors(['title' => 'The title exceeds the maximum allowed length.']);
        }
    
        // Check if the content exceeds the maximum length
        if ($validatedData['content'] !== null && strlen($validatedData['content']) > 65535) {
            return redirect()->back()->withErrors(['content' => 'The content exceeds the maximum allowed length.']);
        }
    
        $journal->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);
    
        return redirect()->route('journals.show', $journal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
        }
        
        $journal->delete();

        return redirect()->route('journals.index');
    }

}
