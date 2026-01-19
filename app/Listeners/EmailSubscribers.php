<?php

namespace App\Listeners;

use App\Events\NewContentPublished;
use App\Mail\NewContentPublishedMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailSubscribers
{
    public function handle(NewContentPublished $event): void
    {
        $emails = Subscriber::query()
            ->whereNotNull('email')
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($emails)) {
            return;
        }

        // "to" üçün from istifadə etmə. Admin/receiver ayrıca olmalıdır.
        $to = config('mail.admin_to') ?: config('mail.from.address');

        // BCC limitlərinə düşməmək üçün (məs: 50-100 arası safe)
        $chunks = array_chunk($emails, 50);

        foreach ($chunks as $bccEmails) {
            try {
                Mail::to($to)
                    ->bcc($bccEmails)
                    ->send(new NewContentPublishedMail(
                        $event->type,
                        $event->title,
                        $event->url,
                        $event->excerpt
                    ));
            } catch (\Throwable $e) {
                // Prod-da mail fail olsa belə kontent yaradılma prosesi ölməsin
                try {
                    Log::error('Subscriber mail failed', [
                        'message' => $e->getMessage(),
                        'to' => $to,
                        'bcc_count' => count($bccEmails),
                    ]);
                } catch (\Throwable $ignore) {
                    // storage/log permission problem olsa belə yenə də request-i öldürməsin
                }

                // istəyirsənsə continue eləsin, hamısını yoxlasın
                continue;
            }
        }
    }
}
