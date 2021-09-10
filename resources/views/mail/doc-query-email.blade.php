@component('mail::message')
# Licence Registration Document Review Query - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</div>
<div>There was an issue found in the documentation you provided for the PPMV Licence Registration.</div>
<div>Kindly log in into you profile to check and make corrections.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent