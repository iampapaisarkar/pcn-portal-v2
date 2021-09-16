@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# Facility Inspection Application Licence Issued - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>Your licence issued for PCN HOSPITAL PHARM ACY REGISTRATION AND INSPECTION.</div>
@endif

<div>Kindly log in into you profile to download licence.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent