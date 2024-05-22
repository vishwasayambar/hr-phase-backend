@component('mail::message')
Hello {{$user->name}},

Welcome to HrPhase!

We are thrilled to have you join our growing community of HR professionals who are taking their HR management to the next level. Our goal is to simplify and streamline your HR processes, helping you focus on what truly matters—your people.

Here's what you can expect from HrPhase:

1. Easy Onboarding: Get started quickly with our intuitive setup process and user-friendly interface.

2. Comprehensive Features: From employee data management to payroll processing, attendance tracking, and performance evaluations, HrPhase covers all your HR needs in one place.

3. Customizable Solutions: Tailor our platform to fit your unique business requirements with customizable features and settings.

4. Real-Time Insights: Make informed decisions with access to real-time data and insightful reports.

5. Dedicated Support: Our support team is here to assist you every step of the way. Whether you have a question or need help, don't hesitate to reach out.

To help you get started, we’ve put together a few resources:

Getting Started Guide: [Link to Guide]
Video Tutorials: [Link to Tutorials]
FAQ Section: [Link to FAQ]

Log in to your account and start exploring HrPhase today. If you need any assistance, feel free to contact our support team at support@hrphase.com or 9876543210.

@component('mail::button', ['url' => $loginLink])
    Getting Started
@endcomponent

Thank you for choosing HrPhase. We are excited to support you in achieving seamless HR management.

Thanks,<br>
{{ config('constants.app_name') }}
@component('emails.footer.hrphase-footer')
@endcomponent
@endcomponent
