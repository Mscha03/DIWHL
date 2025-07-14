<?php

namespace App\Livewire\task;

use App\Models\Task;
use Livewire\Component;

class TaskSingle extends Component
{
    public Task $task;

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function render()
    {
        $task = $this->task;
        return view('livewire.task.single')->layout('layouts.base');
    }
}
