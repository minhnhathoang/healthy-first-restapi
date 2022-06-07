@component('mail::message')
        # Reset Password
        Your six-digit PIN is {{$pin}}
        Please do not share your One Time Pin With Anyone.
        You made a request to reset your password. Please discard if this wasn't you.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
