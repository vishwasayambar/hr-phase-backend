<?php

namespace App\Mail;

use App\Http\URLHelper;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $link;

    public function __construct(public User $user)
    {
        $this->link = URLHelper::getNewTenantActivationLink($this->user->id);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . config('constants.app_name') . ' - Set Up Your HR Account',
        );
    }


    public function content(): Content
    {
        return new Content(
            markdown: 'emails.users.user-welcome',
        );
    }
}
