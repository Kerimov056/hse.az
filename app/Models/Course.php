<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'type',
        'name',
        'courseHoldingName', // NEW
        'courseUrl',
        'description',
        'info',
        'imageUrl',
        'views',

        // optional sütunlar
        'duration',
        'instructor',
        'price',
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

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function socialLink(): HasOne
    {
        return $this->hasOne(SocialLink::class, 'course_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(\App\Models\CourseRegistration::class, 'course_id');
    }

    public function courseTopics(): HasMany
    {
        return $this->hasMany(\App\Models\CourseTopic::class, 'course_id')->orderBy('sort_order');
    }
}
