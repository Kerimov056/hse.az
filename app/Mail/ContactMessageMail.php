<?php

// app/Mail/ContactMessageMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $subject = 'New Contact Message: '.($this->data['topic'] ?: 'No topic');

        return $this->subject($subject)
                    // ->from(config('mail.from.address'), config('mail.from.name')) // istəsən aç
                    ->markdown('emails.contact');
    }
}