@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# Facility Inspection Application Document Review Query - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>There was an issue found in the documentation you provided for the FACILITY INSPECTION APPLICATION. </div>
<div>REASON: {{$data['query']}}</div>
@endif

@if($data['registration_type'] == 'ppmv')
# Facility Inspection Application Document Review Query - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>There was an issue found in the documentation you provided for the FACILITY LOCATON INSPECTION APPLICATION. </div>
<div>REASON: {{$data['query']}}</div>
@endif

@if($data['registration_type'] == 'community_pharmacy')
# Facility Inspection Application Document Review Query - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>There was an issue found in the documentation you provided for the FACILITY LOCATON INSPECTION APPLICATION. </div>
<div>REASON: {{$data['query']}}</div>
@endif

@if($data['registration_type'] == 'distribution_premises')
# Facility Inspection Application Document Review Query - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>There was an issue found in the documentation you provided for the FACILITY LOCATON INSPECTION APPLICATION. </div>
<div>REASON: {{$data['query']}}</div>
@endif

<div>Kindly log in into you profile to check and make corrections.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent