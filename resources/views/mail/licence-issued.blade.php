@component('mail::message')


@if($data['registration_type'] == 'hospital_pharmacy')
# Facility Inspection Application Licence Issued - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>Your licence issued for PCN HOSPITAL PHARM ACY REGISTRATION AND INSPECTION.</div>
@endif

@if($data['registration_type'] == 'hospital_pharmacy_renewal')
# Facility Inspection Application Licence Issued - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div>Your licence issued for PCN HOSPITAL PHARM ACY REGISTRATION AND INSPECTION.</div>
@endif

@if($data['registration_type'] == 'ppmv')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'ppmv_renewal')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'community_pharmacy')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'community_pharmacy_renewal')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'distribution_premises')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'distribution_premises_renewal')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'manufacturing_premises')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

@if($data['registration_type'] == 'manufacturing_premises_renewal')
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, <br>
<div><strong>CONGRATULATIONS</strong>.</div>
<div>There is to inform you that your application for the VENDOR REGISTRATION & LICENCING for the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Certification Status: <strong>LICENCED</strong></div>
<!-- <div>Licence Year: state Licence Year</div> -->
@endif

<div>Kindly log in into you profile to download licence.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent