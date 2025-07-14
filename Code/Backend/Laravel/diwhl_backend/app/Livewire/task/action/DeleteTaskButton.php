<?php

namespace App\Livewire\Task\Action;

use App\Models\Task;
use Livewire\Component;

class DeleteTaskButton extends Component
{
    public Task $task;

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function destroy()
    {
        $this->task->delete();

        $this->dispatch('taskDeleted', id: $this->task->id);

    }

    public function render()
    {
        return view('livewire.task.action.delete-task-button')->layout('layouts.base');
    }
}
