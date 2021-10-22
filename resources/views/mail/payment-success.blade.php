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

@if($data['registration_type'] == 'ppmv')
# PCN - Inspection Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for LOCATION INSPECTION FEES.
@endif

@if($data['registration_type'] == 'ppmv_registration')
# PCN - Registration & Licence Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for VENDOR REGISTRATION & LICENCE FEES.
@endif

@if($data['registration_type'] == 'ppmv_renewal')
# PCN - Inspection Renewal Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for VENDOR RENEWAL & LICENCE FEES.
@endif


@if($data['registration_type'] == 'community_pharmacy')
# PCN - Inspection Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for LOCATION INSPECTION FEES.
@endif

@if($data['registration_type'] == 'community_pharmacy_registration')
# PCN - Registration & Licence Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for VENDOR REGISTRATION & LICENCE FEES.
@endif

@if($data['registration_type'] == 'community_pharmacy_renewal')
# PCN - Inspection Renewal Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for VENDOR RENEWAL & LICENCE FEES.
@endif


@if($data['registration_type'] == 'distribution_premises')
# PCN - Inspection Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for LOCATION INSPECTION FEES.
@endif

@if($data['registration_type'] == 'distribution_premises_registration')
# PCN - Registration & Licence Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for VENDOR REGISTRATION & LICENCE FEES.
@endif

@if($data['registration_type'] == 'distribution_premises_renewal')
# PCN - Inspection Renewal Payment Notification - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for VENDOR RENEWAL & LICENCE FEES.
@endif

</div>
<div>Kindly log in to the portal to view status and application progress.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent