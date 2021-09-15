@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# Hospital Pharmacy Registration Queried - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>There was an issue found in the documentation you provided for the application submitted.</div>

@endif

<div>Kindly log in into you profile to check and make corrections.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent