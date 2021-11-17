@component('mail::message')

@if($data['registration_type'] == 'community_pharmacy')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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


@if($data['registration_type'] == 'community_pharmacy_registration')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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

@if($data['registration_type'] == 'community_pharmacy_renewal')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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

@if($data['registration_type'] == 'distribution_premises')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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


@if($data['registration_type'] == 'distribution_premises_registration')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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

@if($data['registration_type'] == 'distribution_premises_renewal')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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



@if($data['registration_type'] == 'manufacturing_premises_registration')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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

@if($data['registration_type'] == 'manufacturing_premises_renewal')
@if($data['status'] == 'full_recommendation')  
# Facility Inspection Application Approval - {{env('APP_NAME')}}
<div>Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}},</div>
<div><strong>CONGRATULATIONS</strong></div>
<div>There is to inform you that your application for the FACILITY INSPECTION at the {{$data['user']['firstname']}} {{$data['user']['lastname']}} has been approved.</div>
<div>Recommendation Status: <strong>FULL RECOMMENDATION</strong></div>
<div>Kindly login into your profile to begin the Registration process</div>
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