<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    // Yalnız id və image sütunu (üstəlik timestamps)
    protected $fillable = [
        'image', // burada URL saxlanacaq
    ];
}
