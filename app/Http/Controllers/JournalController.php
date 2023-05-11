<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $journals = $user->journals()->get();

        return view('journals.index', compact('journals'));
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
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'nullable',
        ]);

        $user = auth()->user();
        if ($user->id !== $journal->user_id) {
            abort(403, 'Unauthorized');
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
