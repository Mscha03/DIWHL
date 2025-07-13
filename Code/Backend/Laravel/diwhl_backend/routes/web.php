<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tasks', TaskController::class)->middleware('auth');
//Route::resource('tasks', TaskController::class);


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'show'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login',[ LoginController::class, 'show'])->name('login');
    Route::post('login',[ LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout',[ LoginController::class, 'logout'])->name('logout');
});

Route::get('lite', \App\Livewire\TaskList::class);
