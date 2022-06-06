@component('mail::message')
Hey {{$name}},
Your password: {{$password}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
