<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueDate extends Model
{
    protected $fillable = [
        'due_at',
        'repeat_days'
    ];
}
