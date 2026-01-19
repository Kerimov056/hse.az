<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroButton extends Model
{
    protected $fillable = ['text', 'url', 'order'];
}
