@component('mail::message')
# Verify Your Email

Thank you for registering for FSTconference 2024. Please click the button below to verify your email address:

@component('mail::button', ['url' => url('/verify-email/'.$user->verification_token)])
Verify My Email
@endcomponent

If you did not create an account, no further action is required.

Best regards,<br>
The FSTconference Team
@endcomponent
