<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     * (Optional: Laravel automatically assumes 'todos' based on model name)
     */
    protected $table = 'todos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'completion_time',
        'is_recurring',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'completion_time' => 'datetime',
        'status' => 'boolean',
    ];
}

