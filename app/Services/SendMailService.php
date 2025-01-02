<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class SendMailService
{
    public static function sendMailTo($to, $mail): void
    {
        Mail::to($to)->send($mail);
    }

    public static function sendMailBcc($to, $mail): void
    {
        Mail::bcc($to)->send($mail);
    }

    public static function sendMailCc($to, $mail): void
    {
        Mail::cc($to)->send($mail);
    }

}