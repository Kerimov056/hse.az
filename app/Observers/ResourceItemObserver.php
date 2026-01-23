<?php

namespace App\Observers;

use App\Models\ResourceItem;
use Illuminate\Support\Facades\Cache;

class ResourceItemObserver
{
    public function saved(ResourceItem $item): void
    {
        Cache::forget('nav.resource_holdings');
    }

    public function deleted(ResourceItem $item): void
    {
        Cache::forget('nav.resource_holdings');
    }
}
