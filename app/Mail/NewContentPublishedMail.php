<?php
// app/Mail/NewContentPublishedMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContentPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $type,
        public string $title,
        public string $url,
        public ?string $excerpt = null
    ) {}

    public function build()
    {
        return $this->subject("New {$this->pretty($this->type)}: {$this->title}")
            ->markdown('emails.new-content');
    }

    private function pretty(string $t): string
    {
        return match ($t) {
            'service' => 'Service',
            'topic' => 'Topic',
            'vacancy' => 'Vacancy',
            'resource' => 'Resource',
            default => 'Course',
        };
    }
}
