<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');

// Naya simple update route status badalne ke liye
Route::post('/tasks/{task}/toggle', [TaskController::class, 'update'])->name('tasks.toggle');


Route::resource('tasks', TaskController::class)->except(['create', 'show', 'edit', 'update']);
