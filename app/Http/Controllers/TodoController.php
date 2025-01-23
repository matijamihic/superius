<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Requests\TodoStatusUpdateRequest;

class TodoController extends ApiController
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

            return $this->respondNotFound();
        }
        
        return $this->respondSuccess($todo);
    }

    /**
     * Store a new TODO item.
     */
    public function store(TodoStoreRequest $request)
    {

        // Create the todo item
        $todo = Todo::create($request->validated());

        // Return response
        return $this->respondSuccess($todo);
    }

    /**
     * Update a TODO item.
     */
    public function update(TodoUpdateRequest $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {

            return $this->respondNotFound();
        }

        // Update the todo item with validated data
        $todo->update($request->validated());

        return $this->respondSuccess($todo);
    }

    /**
     * Update only the status of a TODO item.
     */
    public function updateStatus(TodoStatusUpdateRequest $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {

            return $this->respondNotFound();
        }

        // Update the status
        $todo->status = $request->validated()['status'];
        $todo->save();

        return $this->respondSuccess($todo);
    }

    /**
     * Soft delete a TODO item.
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if (!$todo) {

            return $this->respondNotFound();
        }

        $todo->delete(); // Soft delete

        return $this->respondSuccess();
    }
}
