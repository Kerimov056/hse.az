<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceItem extends Model
{
    protected $table = 'resources';

    protected $fillable = [
        'resource_type_id',
        'name',
        'resourceUrl',
        'year',
        'mime',
        'views',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    // filter helper (axtarış + type)
    public function scopeSearch($q, string $term = null)
    {
        if ($term !== null && trim($term) !== '') {
            $term = trim($term);
            $q->where(function ($qq) use ($term) {
                $qq->where('name', 'like', "%{$term}%")
                   ->orWhere('mime', 'like', "%{$term}%")
                   ->orWhere('year', 'like', "%{$term}%");
            });
        }
        return $q;
    }
}
