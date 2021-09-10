@component('mail::message')

@if($data['type'] == 'meptp_training')
# MEPTP Payment Notification - {{env('APP_NAME')}}

<div>Hello {{Auth::user()->firstname}} {{Auth::user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN MANDATORY ENTRY POINT TRAINING PROGRAMME (MEPTP) FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS).
</div>
<div>Kindly log in to the portal to view status and application progress.</div>
<div>Thank you.</div>
@endif


@if($data['type'] == 'ppmv_registration')
# Licence Registration Payment - {{env('APP_NAME')}}

<div>Hello {{Auth::user()->firstname}} {{Auth::user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN LICENCE REGISTRATION FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS) for the year {{$data['year']}}.
</div>

<div>Kindly log in to the portal to view status and application progress.</div>

<div>Thank you.</div>
@endif



@if($data['type'] == 'ppmv_renewal')
# Licence Registration Payment - {{env('APP_NAME')}}

<div>Hello {{Auth::user()->firstname}} {{Auth::user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN LICENCE REGISTRATION FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS) for the year {{$data['year']}}.
</div>

<div>Kindly log in to the portal to view status and application progress.</div>

<div>Thank you.</div>
@endif

{{ config('app.name') }}
@endcomponent