<?php

// app/Observers/ResourceItemObserver.php
namespace App\Observers;

use App\Events\NewContentPublished;
use App\Models\ResourceItem;
use Illuminate\Support\Str;

class ResourceItemObserver
{
    public function created(ResourceItem $res): void
    {
        event(new NewContentPublished(
            'resource',
            $res->name,
            route('resources-details', $res->id),
            Str::of(($res->type?->name ?? '').' '.$res->year.' '.$res->mime)->trim()->pipe(fn($s)=>$s ?: null)
        ));
    }
}
