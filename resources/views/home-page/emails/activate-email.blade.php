@component('mail::message')
# Welcome {{ $user->name }}

Click here to activate your account

@component('mail::button', ['url' => $url])
Active
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
