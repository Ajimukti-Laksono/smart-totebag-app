<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get todos ordered: incomplete first, then newest first
        $todos = Todo::orderBy('is_completed', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('todos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Todo::create([
            'task' => $validated['task'],
            'is_completed' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        
        // We can either toggle the completion or set it based on request
        $todo->update([
            'is_completed' => $request->boolean('is_completed')
        ]);

        return redirect()->route('dashboard')->with('success', 'Status tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dihapus!');
    }
}
