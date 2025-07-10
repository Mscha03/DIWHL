<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_completed',
        'has_due_date',
    ];

    public function dueDate(){
        return $this->hasOne(DueDate::class);
    }
}
