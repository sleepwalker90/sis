@component('mail::message')
# Activate Your Account

Click the button below to activate your account and set your password.

@component('mail::button', ['url' => $url])
Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
