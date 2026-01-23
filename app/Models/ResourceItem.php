<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ResourceItem extends Model
{
    // IMPORTANT: səndə cədvəl adı "resources"-dır
    protected $table = 'resources';

    protected $fillable = [
        'resource_type_id',
        'name',
        'holdingName',
        'resourceUrl',
        'year',
        'mime',
        'views',
    ];

    public function type()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function scopeSearch(Builder $q, string $term = ''): Builder
    {
        $term = trim($term);
        if ($term === '') return $q;

        return $q->where(function ($w) use ($term) {
            $w->where('name', 'like', "%{$term}%")
              ->orWhere('holdingName', 'like', "%{$term}%")
              ->orWhere('mime', 'like', "%{$term}%")
              ->orWhere('year', 'like', "%{$term}%");
        });
    }
}
