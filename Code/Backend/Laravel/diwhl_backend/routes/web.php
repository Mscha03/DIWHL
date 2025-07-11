<?php

use App\Http\Controllers\TaskController;
use \App\Models\Task;
use \App\Models\SubTask;
use \App\Models\DueDate;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//tasks
Route::prefix('tasks')->name('tasks')->group(function () {
    Route::get  ('/',               [TaskController::class, 'showAllTasks'])->  name('.index');
    Route::get  ('/create',         [TaskController::class, 'showCreatePage'])->name('.create');
    Route::post ('/store',          [TaskController::class, 'storeTask'] )->    name('.store');
    Route::get  ('/edit/{task}',    [TaskController::class, 'showEditPage'])->  name('.getedit');
    Route::put  ('/edit/{task}',    [TaskController::class, 'editTask'])->      name('.putedit');
    Route::delete('/delete/{task}', [TaskController::class, 'deleteTask'])->    name('.delete');
    Route::get  ('/{task}',         [TaskController::class, 'showSingleTask'])->name('.single');
});





//subtasks TODO:
Route::prefix('subtasks')->name('subtasks')->group(function () {


    //get all subtasks
    Route::get('/', function () {
        $subtasks = SubTask::all();
        return view('subtasks.index', compact('subtasks'));
    })->name('.index');


    //get a subtask
    Route::get('/{subtask}', function (SubTask $subTask) {
        return view('subtasks.index.single', compact('subTask'));
    })->name('.index.single');


    //create new task page
    Route::get('/create', function () {
        return view('subTasks.create');
    })->name('.create');

    //create new tasks
    Route::post('/create', function (Request $request) {
        $validatedData = $request->validate([
            'task_id' => 'required',
            'title' => 'required',
        ]);

        Task::create([
            ...$validatedData
        ]);

    })->name('.create');


    //edit a subtask page
    Route::get('/edit/{subtask}', function (SubTask $subtask) {
        return view('subTasks.edit', compact('subtask'));
    })->name('.edit');

    //edit a subTask
    Route::put('/edit/{subTask}', function (Request $request, SubTask $subtask) {
        $validatedData = $request->validate([
            'task_id' => 'required',
            'title' => 'required',
        ]);

        $subtask->update($validatedData);
    })->name('.edit');


    //delete a task page
    Route::get('/delete/{subtask}', function (SubTask $subtask) {
        return view('subtask.delete', compact('subtask'));
    })->name('.delete');

    //delete a task
    Route::delete('/delete/{subtask}', function (SubTask $subtask) {
        $subtask->delete();
    })->name('.delete');
});
