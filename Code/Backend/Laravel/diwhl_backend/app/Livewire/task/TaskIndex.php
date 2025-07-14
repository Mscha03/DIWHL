<?php

namespace App\Livewire\task;

use App\Models\Task;
use Livewire\Component;

class TaskIndex extends Component
{
    public $tasks;


    public function mount()
    {
        $this->tasks = Task::all()->where('user_id', auth()->id());
    }

    protected $listeners = ['taskDeleted' => 'removeFromList'];

    public function removeFromList($id): void
    {
        $this->tasks = $this->tasks->where('id', '!=', $id);
    }

    public function render()
    {
        return view('livewire.task.index')->layout('layouts.base');
    }

}
