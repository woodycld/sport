<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'height',
        'current_weight',
        'desired_weight',
        'age',
        'goal',
        'weekly_trainings',
        'fitness_level',
        'activity_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
