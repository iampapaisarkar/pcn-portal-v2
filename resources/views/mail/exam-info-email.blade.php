@component('mail::message')
# MEPTP - Examination Information - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</div>
<div>This is to notify you that your MEPTP Index Number and Examination Card have been successfully generated.</div>
<div>Kindly log in into the portal with your profile details to print your examination card.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent