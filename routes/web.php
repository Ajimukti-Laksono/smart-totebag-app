<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;

// Halaman Dashboard Utama (Menampilkan Timer & To-Do List bersamaan)
Route::get('/', [TodoController::class, 'index'])->name('dashboard');

// Routing API/Aksi To-Do List
Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
