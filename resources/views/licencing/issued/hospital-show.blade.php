@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Licence Issued', 'route' => 'licence-issued.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Facility Licence Issued - Details</h5>

                <x-hospital-pharmacy-preview
                :registrationID="$registration->id" 
                :userID="$registration->user_id" 
                type="hospital_pharmacy" />

                <div class="custom-separator"></div>
                
                <x-all-activity
                :applicationID="$registration->id" 
                type="hospital_pharmacy" />
            </div>
        </div>
    </div>
@endsection