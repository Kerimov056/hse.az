<?php

namespace App\Observers;

use App\Models\ResourceItem;
use Illuminate\Support\Facades\Cache;

class ResourceItemObserver
{
    private const NAV_KEY = 'nav.resource_holdings';

    private function bustNavCache(): void
    {
        Cache::forget(self::NAV_KEY);
    }

    public function created(ResourceItem $item): void
    {
        $this->bustNavCache();
    }

    public function updated(ResourceItem $item): void
    {
        $this->bustNavCache();
    }

    public function saved(ResourceItem $item): void
    {
        // Səndə əvvəldən "saved" var idi. Qalsın.
        $this->bustNavCache();
    }

    public function deleted(ResourceItem $item): void
    {
        $this->bustNavCache();
    }

    public function restored(ResourceItem $item): void
    {
        $this->bustNavCache();
    }

    public function forceDeleted(ResourceItem $item): void
    {
        $this->bustNavCache();
    }
}
