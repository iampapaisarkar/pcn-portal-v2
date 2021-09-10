@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Tiered PPMV Registration - Licence Issued', 'route' => 'ppmv-licence-issued-lists'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>Tiered PPMV Registration Licence Issued - Vendor Details</h4>
        <x-vendor-p-p-m-v-application
        :applicationID="$licence->ppmv_application->id" 
        :vendorID="$licence->vendor_id"
        />

        <div class="custom-separator"></div>

        <x-all-activity
        :applicationID="$licence->id" 
        type="ppmv"
        />
    </div>
</div>
</div>
</div>
@endsection