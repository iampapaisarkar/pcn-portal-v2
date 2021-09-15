@component('mail::message')

@if($data['registration_type'] == 'hospital_pharmacy')
# Hospital Pharmacy Registration Not Recommend - {{env('APP_NAME')}}
<div>Your registration for the Hospital Pharmacy not recommend:</div>
<div>If you wish to apply again, kindly log in into you profile to watch out for a new batch in order to apply afresh.</div>
<div>Thank you.</div>
@endif

{{ config('app.name') }}
@endcomponent