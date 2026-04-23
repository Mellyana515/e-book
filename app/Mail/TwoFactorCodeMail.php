<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
<<<<<<< HEAD
use Illuminate\Mail\Mailables\Address;
=======
>>>>>>> cc3ad759e8806e459c58525c9146fc5b7d1bfce0
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $code
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
<<<<<<< HEAD
            from: new Address(
                (string) config('mail.from.address'),
                (string) config('mail.from.name', config('app.name'))
            ),
=======
>>>>>>> cc3ad759e8806e459c58525c9146fc5b7d1bfce0
            subject: 'Kode Verifikasi Login Anda'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.two-factor-code'
        );
    }
}
