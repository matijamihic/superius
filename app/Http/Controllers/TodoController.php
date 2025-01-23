<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Requests\TodoStatusUpdateRequest;

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

    /**
     * Store a new TODO item.
     */
    public function store(TodoStoreRequest $request)
    {
        // Validation is already handled by TodoStoreRequest

        // Create the todo item
        $todo = Todo::create($request->validated());

        // Return response
        return response()->json([
            'message' => 'Todo created successfully',
            'todo' => $todo
        ], 201);
    }

    /**
     * Update a TODO item.
     */
    public function update(TodoUpdateRequest $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        // Update the todo item with validated data
        $todo->update($request->validated());

        return response()->json($todo);
    }

    /**
     * Update only the status of a TODO item.
     */
    public function updateStatus(TodoStatusUpdateRequest $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        // Update the status
        $todo->status = $request->validated()['status'];
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
