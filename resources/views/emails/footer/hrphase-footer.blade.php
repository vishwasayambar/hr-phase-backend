@slot('subcopy')
    <div class="footer-content">
        <h1 class="trouble">Troubles?</h1>
        <h1 class="footer-help-you">We are here to help you</h1>
        <p class="footer-contact-paragraph">Email: <a href="mailto:{{config('constants.support_email')}}">{{config('constants.support_email')}}</a></p>
        <p class="footer-contact-mobile">Call: <a href="tel::{{config('constants.support_phone_number')}}">{{config('constants.support_phone_number')}}</a></p>
    </div>
@endslot
