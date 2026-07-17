<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, string>  $changedFields  Human labels of what changed.
     */
    public function __construct(public User $user, public array $changedFields = [])
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Profile Was Updated',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.profile-updated',
        );
    }
}
