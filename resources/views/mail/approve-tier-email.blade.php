@component('mail::message')
# MEPTP Application Approval - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}, <br>
CONGRATULATIONS.
</div>

<div>There is to inform you that your application for the MEPTP at the {{$data['application']['school']['name']}} has been approved</div>
<div>Vendor Name: {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}</div>
<div>Batch: {{$data['application']['batch']['batch_no']}}/{{$data['application']['batch']['year']}}</div>
<div>Tier: {{$data['application']['tier']['name']}}</div>
<div>Further information will be communicated to you according.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent