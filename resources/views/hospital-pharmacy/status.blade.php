@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Registration Status', 'route' => 'hospital-registration-status'])
    <div class="row">
        <div class="col-lg-12 col-md-12">
            @if(app('App\Http\Services\HospitalRegistrationInfo')->status()['success'] == true)
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="alert alert-card alert-{{app('App\Http\Services\HospitalRegistrationInfo')->status()['color']}}" role="alert">
                            REGISTRATION STATUS:  {{app('App\Http\Services\HospitalRegistrationInfo')->status()['message']}}
                            @if(isset(app('App\Http\Services\HospitalRegistrationInfo')->status()['reason']))
                            <br>
                            <br>
                            <div>
                                <strong class="text-danger">REASON:</strong>
                                <br>
                                <p>{{app('App\Http\Services\HospitalRegistrationInfo')->status()['reason']}}</p>
                            </div>
                            <a href="{{app('App\Http\Services\HospitalRegistrationInfo')->status()['link']}}" class="btn btn-danger text-white btn-rounded ">Update & Re-submit Registration</a>
                            @endif
                        </div>
                    </div>
            
                        <!-- <div class="col-md-12">
                            <div class="alert alert-card alert-danger" role="alert">
                                <p>REGISTRATION STATUS: Document Verification Queried</p>
                                <p><strong>REASONS: </strong></p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean feugiat, nulla ut dictum varius, arcu libero interdum quam, vel ullamcorper odio est vitae lacus.</p>
                            </div>
                        </div>
            
                        <div class="col-md-12">
                            <div class="alert alert-card alert-warning" role="alert">REGISTRATION STATUS: Inspection Pending</div>
                        </div>
            
                        <div class="col-md-12">
                            <div class="alert alert-card alert-success" role="alert">REGISTRATION STATUS: Recommended for Licensure</div>
                        </div>
            
                        <div class="col-md-12">
                            <div class="alert alert-card alert-danger" role="alert">REGISTRATION STATUS: Not Recommended for Licensure
                                <button class="btn btn-rounded btn-danger ml-3">RE-APPLY NOW</button>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="alert alert-card alert-success" role="alert">REGISTRATION STATUS: Licence Issued
                                <button class="btn btn-rounded btn-success ml-3">DOWNLOAD LICENCE</button>
                            </div>
                        </div> -->
                </div>

                <x-hospital-pharmacy-preview
                :registrationID="$registration->id" 
                :userID="$registration->user_id" 
                type="hospital_pharmacy" />

                <div class="custom-separator"></div>
            </div>
            @else
                <small>no status found!</small>
            @endif
        </div>
    </div>
@endsection