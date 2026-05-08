<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // SELECT * FROM tasks ORDER BY created_at DESC
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('tasks.create');
    }

    // INSERT INTO tasks (title, description) VALUES (?, ?)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
        ]);
        $request->merge(['user_id' => $request->user()->id]);
        Task::create($request->only(['user_id', 'title', 'description']));

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche créée !');
    }

    // Afficher le formulaire de modification
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // UPDATE tasks SET title=?, completed=? WHERE id=?
    public function update(Request $request, Task $task)
    {
        $request->validate(['title' => 'required|min:3|max:255']);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->has('completed'),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche modifiée !');
    }

    // DELETE FROM tasks WHERE id = ?
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche supprimée !');
    }
}
