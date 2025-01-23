<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * List all TODOs.
     */
    public function index()
    {
        return response()->json(Todo::all());
    }

    /**
     * Show a single TODO item.
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }
        return response()->json($todo);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completion_time' => 'required|date',
            'is_recurring' => 'nullable|string|in:daily,weekly,monthly',
            'status' => 'boolean',
        ]);

        // Create the todo item
        $todo = Todo::create($validated);

        // Return response
        return response()->json([
            'message' => 'Todo created successfully',
            'todo' => $todo
        ], 201);
    }

    /**
     * Update a TODO item (edit title, description, completion_time, and status).
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'completion_time' => 'date',
            'is_recurring' => 'nullable|string|in:daily,weekly,monthly',
            'status' => 'boolean',
        ]);

        $todo->update($validated);

        return response()->json($todo);
    }

    /**
     * Update only the status of a TODO item.
     */
    public function updateStatus(Request $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $todo->status = $validated['status'];
        $todo->save();

        return response()->json(['message' => 'Status updated successfully', 'todo' => $todo]);
    }

    /**
     * Soft delete a TODO item.
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $todo->delete(); // Soft delete

        return response()->json(['message' => 'Todo deleted successfully']);
    }
}
