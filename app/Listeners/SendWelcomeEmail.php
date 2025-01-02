<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Mail\UserWelcomeEmail;
use App\Services\SendMailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserCreatedEvent $event): void
    {
        $user = $event->user;
        SendMailService::sendMailTo($user, new UserWelcomeEmail($user));
    }
}
