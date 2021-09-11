@component('mail::message')

@if($data['type'] == 'hospital_pharmacy')
# Hospital Pharmacy Registration Payment Notification - {{env('APP_NAME')}}

<div>Hello {{Auth::user()->firstname}} {{Auth::user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN MANDATORY ENTRY POINT TRAINING PROGRAMME (MEPTP) FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS).
</div>
<div>Kindly log in to the portal to view status and application progress.</div>
<div>Thank you.</div>
@endif

{{ config('app.name') }}
@endcomponent