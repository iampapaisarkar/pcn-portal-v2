@component('mail::message')
# MEPTP Application Declined - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</div>
<div>Your application for the MEPTP Training has been declined with the following reason:</div>
<div>- {{$data['application']['query']}}</div>
<div>If you wish to apply again, kindly log in into you profile to watch out for a new batch in order to apply afresh.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent