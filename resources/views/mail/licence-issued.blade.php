@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# Hospital Pharmacy Licence Issued - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>Your licence issued for Hospital Pharmacy.</div>
@endif

<div>Kindly log in into you profile to download licence.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent