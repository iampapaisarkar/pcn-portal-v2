@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Report', 'route' => 'generate-payment-reports'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <form method="POST" action="{{ route('generate-pay-reports') }}" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-md-4 col-12 form-group mb-3">
                    @php
                    $states = app('App\Http\Services\BasicInformation')->states();
                    @endphp
                    <label for="picker1">State</label>
                    <select id="stateField" required name="state"
                    class="form-control @error('state') is-invalid @enderror">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 col-12 form-group mb-3">
                    <label for="picker1">Facility Category</label>
                    <select id="categoryField" required name="category"
                    class="form-control @error('category') is-invalid @enderror">
                        <option value="">Select Category</option>
                        <option value="all">All</option>
                        <option value="hospital_pharmacy">Hospital Pharmacy</option>		
                        <option value="community_pharmacy">Community Pharmacy</option>
                        <option value="distribution_premises">Distribution Premises</option>
                        <option value="manufacturing_premises">Manufacturing Premises</option>
                        <option value="ppmv">PPMV</option>
                    </select>
                    @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 col-12 form-group mb-3">
                    <label for="picker1">Activity Type</label>
                    <select id="activityField" required name="activity"
                    class="form-control @error('activity') is-invalid @enderror">
                        <option value="">Select Activity</option>
                        <option value="all">All</option>
                        <option value="document_review">Document Review</option>		
                        <option value="location_inspection">Location Inspection</option>
                        <option value="location_approval_banner">Location Approval Banner</option>
                        <option value="facility_inspection">Facility Inspection</option>
                        <option value="renewal_inspection">Renewal Inspection</option>
                    </select>
                    @error('activity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 col-12 form-group mb-3">
                    <label for="picker1">Status</label>
                    <select id="statusField" required name="status"
                    class="form-control @error('status') is-invalid @enderror">
                        <option value="">Select Status</option>
                        <option value="all">All</option>
                        <option value="pending">Pending</option>		
                        <option value="approved">Approved</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 col-12 form-group mb-3">
                    <label for="picker1">Date From</label>
                    <input name="date_from" class="form-control @error('date_from') is-invalid @enderror"
                        id="date_from1" type="date"/>
                    @error('date_from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 col-12 form-group mb-3">
                    <label for="picker1">Date To</label>
                    <input name="date_to" class="form-control @error('date_to') is-invalid @enderror"
                        id="date_to1" type="date"/>
                    @error('date_to')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Export to Excel</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<style>
    .toggle-on{
        color: white!important;
    }
    .toggle-off{
        color: white!important;
    }
</style>
@endsection