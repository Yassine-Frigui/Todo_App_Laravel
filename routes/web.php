<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
// Redirige / vers la liste des tâches
Route::get('/', fn() => redirect()->route('tasks.index'));
// Génère automatiquement les 7 routes CRUD
Route::resource('tasks', TaskController::class);
