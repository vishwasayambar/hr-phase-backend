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

class TenantRegisterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $link;

    public string $loginLink;

    public function __construct(Public $user)
    {
        $this->link = URLHelper::getNewTenantActivationLink($this->user->id);
        $this->loginLink = config('constants.frontend_base_url');
        info('Account Activation URL:' . $this->link);
    }

    public function build(): self
    {
        return $this->markdown('emails.tenants.tenant-registered')
            ->subject('Activate your BytePhase account');
    }

}
