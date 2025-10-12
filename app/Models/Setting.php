<?php
// app/Models/Setting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    protected $casts = [
        'value' => 'array', // JSON <-> array
    ];

    public $timestamps = false; // created_at, updated_at sahələri yoxdur
}
