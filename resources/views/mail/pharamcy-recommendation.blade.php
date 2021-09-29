@component('mail::message')

@if($data['registration_type'] == 'hospital_pharmacy')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'partial_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>PARTIAL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'no_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div>The result of the Inspection carried out on your location was</div>
<div>Recommendation Status: <strong>NO RECOMMENDATION</strong></div>
<div>If you wish to apply again, kindly log in into you profile to submit a fresh application.</div>
<div>Thank you.</div>
@endif
@endif

@if($data['registration_type'] == 'hospital_pharmacy_renewal')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'partial_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>PARTIAL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'no_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div>The result of the Inspection carried out on your location was</div>
<div>Recommendation Status: <strong>NO RECOMMENDATION</strong></div>
<div>If you wish to apply again, kindly log in into you profile to submit a fresh application.</div>
<div>Thank you.</div>
@endif
@endif


@if($data['registration_type'] == 'ppmv')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'no_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div>The result of the Inspection carried out on your location was</div>
<div>Recommendation Status: <strong>NO RECOMMENDATION</strong></div>
<div>If you wish to apply again, kindly log in into you profile to submit a fresh application.</div>
<div>Thank you.</div>
@endif
@endif

@if($data['registration_type'] == 'ppmv_registration')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'no_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div>The result of the Inspection carried out on your location was</div>
<div>Recommendation Status: <strong>NO RECOMMENDATION</strong></div>
<div>If you wish to apply again, kindly log in into you profile to submit a fresh application.</div>
<div>Thank you.</div>
@endif
@endif

@if($data['registration_type'] == 'ppmv_renewal')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Further information concerning the physical inspection will be communicated to you accordingly.</div>
<div>Thank you.</div>
@endif
@if($data['status'] == 'no_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div>The result of the Inspection carried out on your location was</div>
<div>Recommendation Status: <strong>NO RECOMMENDATION</strong></div>
<div>If you wish to apply again, kindly log in into you profile to submit a fresh application.</div>
<div>Thank you.</div>
@endif
@endif

{{ config('app.name') }}
@endcomponent