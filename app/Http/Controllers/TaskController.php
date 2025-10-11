<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'is_done' => ['nullable','boolean'],
        ]);

        $data['is_done'] = (bool) ($data['is_done'] ?? false);

        Task::create($data);
        return redirect()->route('tasks.index')->with('success','Tapşırıq yaradıldı.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'is_done' => ['nullable','boolean'],
        ]);

        $data['is_done'] = (bool) ($data['is_done'] ?? false);

        $task->update($data);
        return redirect()->route('tasks.index')->with('success','Tapşırıq yeniləndi.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success','Tapşırıq silindi.');
    }
}
