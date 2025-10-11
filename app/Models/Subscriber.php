<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['email', 'name', 'verified_at', 'token'];
    protected $casts = ['verified_at' => 'datetime'];
}
