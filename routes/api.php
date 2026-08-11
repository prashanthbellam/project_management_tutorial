<?php

use App\Http\Controllers\TasksMasterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post(
    'tasks/{task}/subtasks',
    [TasksMasterController::class, 'storeSubtask']
);

Route::get(
    'tasks/{task}/subtasks',
    [TasksMasterController::class, 'subtasks']
);

Route::delete(
    'tasks/{task}/subtasks/{subtask}',
    [TasksMasterController::class, 'destroySubtask']
);

Route::apiResource('tasks', TasksMasterController::class)
    ->parameters([
        'tasks' => 'tasksMaster',
    ]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
