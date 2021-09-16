@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# PCN - Registration & Inspection Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN HOSPITAL PHARM ACY REGISTRATION AND INSPECTION FEES.
@endif

@if($data['registration_type'] == 'hospital_pharmacy_renewal')
# PCN - Renewal & Licence Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN HOSPITAL PHARM ACY RENEWAL AND LICENCE FEES.
@endif

</div>
<div>Kindly log in to the portal to view status and application progress.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent