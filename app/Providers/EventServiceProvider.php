<?php
// app/Providers/EventServiceProvider.php
namespace App\Providers;

use App\Events\NewContentPublished;
use App\Listeners\EmailSubscribers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewContentPublished::class => [ EmailSubscribers::class ],
    ];
}
