@slot('subcopy')
    <div class="footer-content">
        <h1 class="trouble">Troubles?</h1>
        <h1 class="footer-help-you">We are here to help you</h1>
        <p class="footer-contact-paragraph">Email: <a href="mailto:{{config('app.support_email')}}">{{config('app.support_email')}}</a></p>
        <p class="footer-contact-mobile">Call: <a href="tel::{{config('app.support_phone_number')}}">{{config('app.support_phone_number')}}</a></p>
    </div>
@endslot
