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
        $today = now();
        $endDate = now()->addDays(30);

        // Get all non-recurring todos that fall within the next 30 days
        $todos = Todo::whereBetween('completion_time', [$today, $endDate])
            ->whereNull('is_recurring') // Exclude recurring todos for now
            ->get();

        // Get all recurring todos and generate occurrences within the next 30 days
        $recurringTodos = Todo::whereNotNull('is_recurring') // Get recurring todos
            ->get();

        $recurringTodos = $this->generateRecurringTodos($recurringTodos);

        // Combine non-recurring and recurring todos
        $allTodos = $todos->merge($recurringTodos);

        return $this->respondSuccess($allTodos);
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

    /**
     * Generate recurring todos for the next 30 days based on recurrence type.
     *
     * @param \Illuminate\Support\Collection $todos
     * @return \Illuminate\Support\Collection
     */
    protected function generateRecurringTodos($todos)
    {
        $generatedTodos = [];

        $today = now();
        $endDate = now()->addDays(30);

        // TODO: add funciton that multiplies all todos on daily, weekly and montly basis.
        // response array should be in same format as incoiming data

        return $todos;
    }
}
