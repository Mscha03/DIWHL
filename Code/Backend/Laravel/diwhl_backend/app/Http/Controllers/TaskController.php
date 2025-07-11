<?php

namespace App\Http\Controllers;

use App\Models\DueDate;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private function createTask(array $validatedData): Task
    {
        return Task::create([
            'user_id' => 1, //TODO: نیاز به احراز هویت
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
        }else {
            $validatedData = [];
        }
        return $validatedData;
    }
    private function updateTask(Task $task, array $validatedData): Task
    {
        $task->update([
            'user_id' => 1, //TODO احراز هویت
            ...$validatedData
        ]);
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
    public function showAllTasks()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }
    public function showCreatePage()
    {
        return view('tasks.create');
    }
    public function storeTask(Request $request)
    {
        $validatedTaskData = $this->validateTaskData($request);
        $validatedDueDateData = $this->validateDueDateData($request);
        $validatedTaskData['has_due_date'] = $this->validateCheckboxInt($validatedTaskData['has_due_date']??null);

        $task = $this->createTask($validatedTaskData);
        $this->createDueDateIfExists($task, $validatedDueDateData);

        return redirect('/tasks');
    }
    public function showEditPage(Task $task){
        return view('tasks.edit', compact('task'));
    }
    public function editTask(Task $task, Request $request)
    {
        $validatedTaskData = $this->validateTaskData($request);
        $validatedTaskData['has_due_date'] = $this->validateCheckboxInt($validatedTaskData['has_due_date']);
        if(isset($task->dueDate)){
            $this->updateOrDeleteDueDate($task, $validatedTaskData);
        }else {
            $this->createDueDateIfExists($task, $validatedTaskData);
        }

        $this->updateTask($task, $validatedTaskData);
        return redirect('/tasks');
    }
    public function deleteTask(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
    public function showSingleTask(Task $task){
        return view('tasks.single', compact('task'));
    }


}
