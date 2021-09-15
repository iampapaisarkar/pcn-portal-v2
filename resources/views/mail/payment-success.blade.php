@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# Hospital Pharmacy Registration Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN HOSPITAL REGISTRATION).
@endif

@if($data['registration_type'] == 'hospital_pharmacy_renewal')
# Hospital Pharmacy Renewal Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN HOSPITAL RENEWAL).
@endif


</div>
<div>Kindly log in to the portal to view status and application progress.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent