<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::prefix('todos')->group(function () {
    Route::get('/', [TodoController::class, 'index']);         // List all TODOs
    Route::get('{id}', [TodoController::class, 'show']);       // Get a single TODO
    Route::post('/', [TodoController::class, 'store']);        // Create a new TODO
    Route::put('{id}', [TodoController::class, 'update']);     // Edit an existing TODO
    Route::patch('{id}/status', [TodoController::class, 'updateStatus']); // Update status only
    Route::delete('{id}', [TodoController::class, 'destroy']); // Soft delete a TODO
});

