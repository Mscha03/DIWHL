<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Livewire\task\TaskCreate;
use App\Livewire\task\TaskEdit;
use App\Livewire\task\TaskIndex;
use App\Livewire\task\TaskSingle;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('tasks', TaskController::class)->middleware('auth');


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'show'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login',[ LoginController::class, 'show'])->name('login');
    Route::post('login',[ LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout',[ LoginController::class, 'logout'])->name('logout');
});

Route::get('tasks', TaskIndex::class)->name('tasks.index');
Route::get('tasks/create', TaskCreate::class)->name('tasks.create');
Route::get('tasks/{task}', TaskSingle::class)->name('tasks.show');
Route::get('tasks/{task}/edit', TaskEdit::class)->name('tasks.edit');
