@component('mail::message')
# MEPTP - Examination Result - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</div>
<div>This is to notify you that your Examination Result for just concluded PCN MANDATORY ENTRY POINT TRAINING PROGRAMME (MEPTP) FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS) has been uploaded.</div>
<div>Kindly log in into the portal with your profile details to view and print.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent