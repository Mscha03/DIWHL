<?php

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

    //get all tasks
    Route::get('/', function () {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    })->name('.index');


    //create new task page
    Route::get('/create', function () {
        return view('tasks.create');
    })->name('.create');
    //create new tasks
    Route::post('/store', function (Request $request) {

        $validatedTaskData = $request->validate([
            'user_id' => 'nullable',
            'title' => 'required',
            'description' => 'nullable',
            'has_due_date' => 'nullable',
        ]);


        if (isset($validatedTaskData['has_due_date'])) {
            $validatedTaskData['has_due_date'] = 1;
        } else {
            $validatedTaskData['has_due_date'] = 0;
        }

        $task = Task::create([
            'user_id' => 3,
            ...$validatedTaskData
        ]);


        if ($validatedTaskData['has_due_date'] === 1) {

            $validatedDueDateData = $request->validate([
                'due_at' => 'required',
                'repeat_days' => 'nullable',
            ]);

            $validatedDueDateData['task_id'] = $task->id;

            createDueDate($validatedDueDateData);
        }


        return redirect('/tasks');

    })->name('.store');



    //edit a task page
    Route::get('/edit/{task}', function (Task $task) {
        return view('tasks.edit', compact('task'));
    })->name('.getedit');
    //edit a task
    Route::put('/edit/{task}', function (Request $request, Task $task) {
        $validatedTaskData = $request->validate([
            'user_id' => 'nullable',
            'title' => 'required',
            'description' => 'nullable',
            'has_due_date' => 'nullable',
        ]);

        $dueDate = new DueDate;

        if (isset($validatedTaskData['has_due_date'])) {
            $validatedTaskData['has_due_date'] = 1;
            if (isset($task->dueDate)) {
                updateDueDate($task->dueDate, $validatedTaskData);
            } else {
                $validatedDueDateData = $request->validate([
                    'due_at' => 'required',
                    'repeat_days' => 'nullable',
                ]);

                $validatedDueDateData['task_id'] = $task->id;

                createDueDate($validatedDueDateData);
            }
        } else {
            $validatedTaskData['has_due_date'] = 0;
            if (isset($task->dueDate)) {
                deleteDueDate($task->dueDate);
            }
        }

        $task->update([
            'user_id' => 3,
            ...$validatedTaskData
        ]);



        return redirect('/tasks');

    })->name('.putedit');


    //delete a task
    Route::delete('/delete/{task}', function (Task $task) {
        $task->delete();

        return redirect('/tasks');
    })->name('.delete');



    //get a task
    Route::get('/{task}', function (Task $task) {
        return view('tasks.single', compact('task'));
    })->name('.single');


});

//duedate
function createDueDate($subtask)
{
    DueDate::create([
        ...$subtask
    ]);
}
function updateDueDate(DueDate $subtask, $validateData){

    $subtask->update([
        ...$validateData
    ]);
}

function deleteDueDate($subtask){
    $subtask->delete();
}




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


//duedate TODO:
Route::prefix('duedate')->name('duedate')->group(function () {

    //get all duedates
    Route::get('/', function () {
        $duedates = DueDate::all();
        return view('duedates.index', compact('duedates'));
    })->name('.index');


    //get a duedate
    Route::get('/{duedate}', function (DueDate $dueTate) {
        return view('duedates.index.single', compact('dueTate'));
    })->name('.index.single');


    //create new task page
    Route::get('/create', function () {
        return view('dueTates.create');
    })->name('.create');

    //create new duedatetasks
    Route::post('/create', function ($request) {
        $validatedData = $request->validate([
            'task_id' => 'required',
            'due_at' => 'required',
            'repeat_days' => 'nullable',
        ]);

        dd($validatedData);

        Task::create([
            ...$validatedData
        ]);

    })->name('.create');


    //edit a duedate page
    Route::get('/edit/{duedate}', function (DueDate $duedate) {
        return view('dueTates.edit', compact('duedate'));
    })->name('.edit');

    //edit a dueTate
    Route::put('/edit/{dueTate}', function (Request $request, DueDate $duedate) {
        $validatedData = $request->validate([
            'task_id' => 'required',
            'title' => 'required',
        ]);

        $duedate->update($validatedData);
    })->name('.edit');


    //delete a task page
    Route::get('/delete/{duedate}', function (DueDate $duedate) {
        return view('duedate.delete', compact('duedate'));
    })->name('.delete');

    //delete a task
    Route::delete('/delete/{duedate}', function (DueDate $duedate) {
        $duedate->delete();
    })->name('.delete'); });

