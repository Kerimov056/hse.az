<?php

namespace App\Listeners;

use App\Events\NewContentPublished;
use App\Mail\NewContentPublishedMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class EmailSubscribers
{
    public function handle(NewContentPublished $event): void
    {
        // bütün abunəçilərə BCC ilə göndərək (tək bir maildə)
        $emails = Subscriber::query()->pluck('email')->all();
        if (empty($emails)) return;

        Mail::to(config('mail.from.address'))
            ->bcc($emails)
            ->send(new NewContentPublishedMail($event->type, $event->title, $event->url, $event->excerpt));
    }
}
