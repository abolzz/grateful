@component('mail::message')
# Paldies par pirkumu!

Jūsu pirkuma kods: {{app('request')->input('purchase_key')}}

Lai labi garšo,<br>
{{ config('app.name') }}
@endcomponent
