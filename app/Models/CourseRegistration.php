<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRegistration extends Model
{
    protected $fillable = [
        'course_id',
        'first_name',
        'surname',
        'patronymic',
        'certificate_name',
        'birth_date',
        'gender',
        'id_card_number',
        'business_email',
        'telephone',
        'mobile_phone',
        'postal_code',
        'company',
        'position',
        'requested_product_service',
        'requirements',
        'notes',
        'remember_me',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'remember_me' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
