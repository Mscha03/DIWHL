<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueDate extends Model
{
    public $timestamps = false; // غیرفعال کردن timestamps خودکار

    protected $fillable = [
        'task_id',
        'due_at',
        'repeat_days'
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
