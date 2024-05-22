<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TenantWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $loginLink;

    public function __construct(public User $user)
    {
        $this->loginLink = config('constants.frontend_base_url');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to HrPhase💜 - Your Complete HRMS Solution! 🚀',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tenants.tenant-welcome',
        );
    }

}
