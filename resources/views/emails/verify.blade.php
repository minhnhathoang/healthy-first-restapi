@component('mail::message')
    Welcome to Healthy First

    Hi {{$name}},

    You're now a member of Healthy First.

    Verification code: {{$pin}}

    Thanks,
    {{ config('app.name') }}

@endcomponent

