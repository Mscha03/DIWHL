<?php

namespace App\Livewire\task;

use App\Models\DueDate;
use App\Models\Task;
use Livewire\Component;

class TaskCreate extends Component
{

    public $user_id;
    public $title;
    public $description;
    public $is_completed;
    public $has_due_date = false;
    public $due_at;
    public $repeat_days;




    public function mount()
    {
        $this->user_id = auth()->id();
        $this->is_completed = 0;
    }

    public function store()
    {
        $validatedTaskData = $this->validateTaskData();
        $validatedDueDateData = $this->validateDueDateData();
        $validatedTaskData['has_due_date'] = $this->validateCheckboxInt($validatedTaskData['has_due_date'] ?? null);


        $task = $this->createTask($validatedTaskData);
        $this->createDueDateIfExists($task, $validatedDueDateData);

        return redirect('/tasks');
    }

    public function render()
    {
        return view('livewire.task.create');
    }


    /**
     * private functions
    */

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

    private function validateCheckboxInt($value): int
    {
        if ($value) {
            $value = 1;
        } else {
            $value = 0;
        }
        return $value;
    }

    private function createTask(array $validatedData): Task
    {
        return Task::create([
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

    private function validateTaskData(): array
    {
       return $this->validate([
           'user_id' => 'required', //TODO: درست کردن بعد از احراز هویت
           'title' => 'required',
           'description' => 'nullable',
           'is_completed' => 'nullable',
           'has_due_date' => 'nullable',
       ]);
    }


}
