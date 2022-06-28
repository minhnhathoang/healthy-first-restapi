@component('mail::message')

    Hey {{$name}},
    You are logged in Healthy First at {{$time}}


    {{ config('app.name') }}
@endcomponent
