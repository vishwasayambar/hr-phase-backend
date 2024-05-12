<?php
@component('mail::message')
Hello {{$user->name}},


Thank you for registering with HrPhase. We look forward to getting you started on this new journey.


You will find your HrPhase login details below:


**Username:** {{$user->email}} or {{$user->mobile_number}}


**Login URL:** {{$loginLink}}


Click on the "Activate" button below to activate your HrPhase account:
@component('mail::button', ['url' => $link])
    Activate
@endcomponent


Thanks,<br>
{{ config('constants.app_name') }}
@component('emails.footer.hrphase-footer')
@endcomponent
@endcomponent
