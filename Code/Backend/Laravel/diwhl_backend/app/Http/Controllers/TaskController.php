<?php

namespace App\Http\Controllers;

use App\Models\DueDate;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TaskController extends Controller implements HasMiddleware
{
    /**
     * middleware
     */

    public static function middleware()
    {
        return [
            new Middleware('auth', except: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedTaskData = $this->validateTaskData($request);
        $validatedDueDateData = $this->validateDueDateData($request);
        $validatedTaskData['has_due_date'] = $this->validateCheckboxInt($validatedTaskData['has_due_date'] ?? null);

        $task = $this->createTask($validatedTaskData);
        $this->createDueDateIfExists($task, $validatedDueDateData);

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.single', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validatedTaskData = $this->validateTaskData($request);
        $validatedTaskData['has_due_date'] = $this->validateCheckboxInt($validatedTaskData['has_due_date'] ?? null);
        $validatedTaskData['is_completed'] = $this->validateCheckboxInt($validatedTaskData['is_completed'] ?? null);
        $validatedDueDateData = $this->validateDueDateData($request);
        $this->updateTask($task, $validatedTaskData);

        if (isset($task->dueDate)) {
            $this->updateOrDeleteDueDate($task, $validatedDueDateData);
        } else {
            $this->createDueDateIfExists($task, $validatedDueDateData);
        }
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }





    /**
     *  ***** pravate functions *****
     */
    private function createTask(array $validatedData): Task
    {
        return Task::create([
//            'user_id' => 1, //TODO: نیاز به احراز هویت
            'user_id' => auth()->id(),
            ...$validatedData
        ]);
    }

    private function createDueDateIfExists(Task $task, array $validateData): ?DueDate
    {
        if ($task['has_due_date'] === 1) {
            return $this->createDueDate($task, $validateData);
        } else {
            return null;
        }
    }

    private function createDueDate(Task $task, array $validatedData): DueDate
    {
        $validatedData['task_id'] = $task->id;
        return DueDate::create([
            ...$validatedData
        ]);
    }

    private function validateCheckboxInt($value): int
    {
        if (isset($value)) {
            $value = 1;
        } else {
            $value = 0;
        }
        return $value;
    }

    private function validateCheckboxBool($value): bool
    {
        if (isset($value)) {
            $value = true;
        } else {
            $value = false;
        }
        return $value;
    }

    private function validateTaskData(Request $request): array
    {
        return $request->validate([
            'user_id' => 'nullable', //TODO: درست کردن بعد از احراز هویت
            'title' => 'required',
            'description' => 'nullable',
            'is_completed' => 'nullable',
            'has_due_date' => 'nullable',
        ]);
    }

    private function validateDueDateData(Request $request): array
    {
        if (isset($request['has_due_date'])) {
            $validatedData = $request->validate([
                'due_at' => 'required',
                'repeat_days' => 'nullable',
            ]);
        } else {
            $validatedData = [];
        }
        return $validatedData;
    }

    private function updateTask(Task $task, array $validatedData): Task
    {
        $task->update([
            ...$validatedData
        ]);
//        dd($task);
        return $task;
    }

    private function updateOrDeleteDueDate(Task $task, array $validatedData): Task
    {
        if ($task['has_due_date'] === 1) {
            $task->dueDate->update([...$validatedData]);
        } else {
            $task->dueDate->delete();
        }
        return $task;
    }


}

