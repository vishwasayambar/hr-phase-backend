@component('mail::message')

Dear {{$user->name}},

Welcome to the {{ config('constants.app_name') }} family! We are excited to have you on board.

As part of your onboarding process, we’ve set up your profile in our Human Resource Management System. This platform will allow you to manage your details, access company updates, and collaborate with your team seamlessly.

To get started, please create your account password:

@component('mail::button', ['url' => $link])
    Set Your Password Now
@endcomponent

This link is secure and will expire in 1 day. If the link expires, you can request a new one by contacting {{ config('constants.support_email') }}.

Once your password is created, log in to the portal at {{config('constants.frontend_base_url')}} to explore the platform and update your profile information.

We’re thrilled to have you join us and look forward to working together. If you have any questions or need help, feel free to contact us.

Best regards,<br>

{{ config('constants.app_name') }}
@component('emails.footer.hrphase-footer')
@endcomponent
@endcomponent
