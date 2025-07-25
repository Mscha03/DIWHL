<?php

namespace App\Livewire\task;

use App\Models\DueDate;
use App\Models\Task;
use Livewire\Component;

class TaskEdit extends Component
{

    public Task $task;

    public $user_id;
    public $title;
    public $description;
    public $has_due_date = false;
    public $due_at;
    public $repeat_days;
    public $is_completed = false;


    public function mount(Task $task)
    {

        $this->task = $task;

        $this->user_id = $task->user_id;

        // پر کردن فرم با مقادیر قبلی
        $this->title = $task->title;
        $this->description = $task->description;
        $this->has_due_date = $task->has_due_date;
        $this->is_completed = $task->is_completed;

        if ($task->dueDate) {
            $this->due_at = $task->dueDate->due_at;
            $this->repeat_days = $task->dueDate->repeat_days;
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        $validatedTaskData = $this->validateTaskData();
        $validatedTaskData['has_due_date'] = $this->validateCheckboxInt($validatedTaskData['has_due_date'] ?? null);
        $validatedTaskData['is_completed'] = $this->validateCheckboxInt($validatedTaskData['is_completed'] ?? null);
        $validatedDueDateData = $this->validateDueDateData();
        $this->updateTask($this->task, $validatedTaskData);

        if ($this->task->dueDate) {
            $this->updateOrDeleteDueDate($this->task, $validatedDueDateData);
        } else {
            $this->createDueDateIfExists($this->task, $validatedDueDateData);
        }
        return redirect('/tasks');
    }

    protected $listeners = ['taskDeleted' => 'removeFromList'];

    public function removeFromList($id): void
    {
        $this->tasks = $this->tasks->where('id', '!=', $id);
    }

    public function render()
    {
        $task = $this->task;
        return view('livewire.task.edit', compact('task'));
    }

    /**
     * private functions
     */

    private function validateTaskData(): array
    {
        return $this->validate([
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'is_completed' => 'nullable',
            'has_due_date' => 'nullable',
        ]);
    }
    private function validateCheckboxInt($value): int
    {
        if ($value) {
            $value = 1;
        } else {
            $value = 0;
        }
        return $value;
    }
    private function validateDueDateData( ): array
    {
        if ($this->has_due_date) {
            $validatedData = $this->validate([
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

}
