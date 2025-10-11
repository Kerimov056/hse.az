<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'imageUrl', 'gender', 'full_name', 'position',
        'description', 'phone', 'email',
        'expertise_title', 'expertise_intro', 'skills',
    ];

    protected $casts = [
        'skills' => 'array', // [{name, percent}, ...]
    ];
}
