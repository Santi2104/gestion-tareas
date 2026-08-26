<?php

use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class);
Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');

Route::get('priorities', [PriorityController::class, 'index'])->name('priorities.index');
Route::get('tags', [TagController::class, 'index'])->name('tags.index');
