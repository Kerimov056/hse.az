<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id','twitterurl','facebookurl','linkedinurl','emailurl','whatsappurl',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
