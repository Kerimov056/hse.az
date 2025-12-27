<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    // Əgər fillable istifadə edirsənsə
    protected $fillable = [
        'type',
        'name',
        'courseUrl',
        'description',
        'info',       // YENİ SƏTİR
        'imageUrl',
        'views',
        // digər sütunların...
    ];

    public const TYPE_COURSE = 'course';
    public const TYPE_SERVICE = 'service';
    public const TYPE_TOPIC = 'topic';
    public const TYPE_VACANCY = 'vacancy';
    public const TYPE_NEWS = 'news';

    public const TYPES = [
        self::TYPE_COURSE,
        self::TYPE_SERVICE,
        self::TYPE_TOPIC,
        self::TYPE_VACANCY,
        self::TYPE_NEWS,
    ];

    /** scope: müəyyən type üçün filtrlə */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // Sosial link əlaqəsi (course_id xarici açarı ilə)
    public function socialLink(): HasOne
    {
        return $this->hasOne(SocialLink::class, 'course_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(\App\Models\CourseRegistration::class, 'course_id');
    }
}
