<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskIndex extends Component
{
    public $tasks;


    public function mount()
    {
        $this->tasks = Task::all()->where('user_id', auth()->id());
    }
    public function render()
    {
        return view('livewire.task-index', [])->layout('layouts.base');
    }
}
