<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

  
    public $first_name;
    public $otp;
    public $verificationLink;
    public function __construct($first_name, $otp, $verificationLink)
    {
        $this->first_name = $first_name;
        $this->otp = $otp;
        $this->verificationLink = $verificationLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'livewire.user.emails.register-email',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
