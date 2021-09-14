@component('mail::message')
# PPMV Licence Application Query - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</div>
<div>The result of the Inspection carried out on your location was</div>
<h2>NOT RECOMMENDED</h2>
<div>If you wish to apply again, kindly log in into you profile to submit a fresh application.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent