@component('mail::message')
Te han enviado una sugerencia desde la App Upa Llanos<br>
Sugerencia:
@component('mail::panel')
    {{ $datos['sugerencia'] }}
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent