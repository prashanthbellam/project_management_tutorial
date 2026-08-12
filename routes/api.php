<?php

use App\Http\Controllers\TimelineMasterController;
use App\Http\Controllers\ProjectMasterController;
use Illuminate\Support\Facades\Route;

Route::apiResource('project-masters', ProjectMasterController::class);
Route::apiResource('timeline-masters', TimelineMasterController::class);
Route::post('timeline-masters/{timeline}/subtimelines', [TimelineMasterController::class, 'storeSubtimeline']);
Route::get('timeline-masters/{timeline}/subtimelines', [TimelineMasterController::class, 'subtimelines']);
Route::delete('timeline-masters/{timeline}/subtimelines/{subtimeline}', [TimelineMasterController::class, 'destroySubtimeline']);
