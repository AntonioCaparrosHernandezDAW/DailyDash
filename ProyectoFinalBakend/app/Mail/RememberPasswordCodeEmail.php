<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class RememberPasswordCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token_password;

    /**
     * Create a new message instance.
     */
    public function __construct($token)
    {
        $this->token_password = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('DailyDashSupport@gmail.com', 'DailyDash'),
            replyTo: [
                new Address('antonioclasedaw@gmail.com', 'ReplyToNoseQueEsEsto')
            ],
            subject: 'Remember Password Code Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.rememberPassword',
            with: ['token_password' => $this->token_password]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
