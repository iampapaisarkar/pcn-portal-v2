@component('mail::message')
# PPMV Licence Approval - {{env('APP_NAME')}}

<div>Hello {{$vendor['firstname']}} {{$vendor['lastname']}},</div>
<div>There is to notify you that your Licence for the year {{$data['renewal_year']}} has been approved.</div>
<div>Attached with this email is a copy of your licence or log in into you profile to download.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent