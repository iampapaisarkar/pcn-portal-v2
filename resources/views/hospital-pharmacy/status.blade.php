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

                        <div class="form-group col-md-3">
                            <label for="inputEmail1" class="ul-form__label"><strong>Hospital Name:</strong></label>
                            <div>{{Auth::user()->hospital_name}}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail3" class="ul-form__label"><strong>Hospital Address:</strong></label>
                            <div>{{Auth::user()->hospital_address}}</div>
                            
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                            <div>{{Auth::user()->user_state->name}}</div>
                            
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong> </label>
                            <div>{{Auth::user()->user_lga->name}}</div>
                        </div>
                    </div>
                    
                    <div class="custom-separator"></div>
                    <h4>Bed Capacity</h4>
                    <div class="table-responsive">
                        <table id="" class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Bed Capacity</th>
                                    <th scope="col">Registration Fee</th>
                                    <th scope="col">Inspection Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bed = [];
                                    foreach ( config('custom.beds') as $beds ) {
                                    if ( $beds['id'] == $registration->bed_capacity ) {
                                        $bed = $beds;
                                    }
                                }
                                @endphp
                                <tr>
                                    <td>{{$bed['bed_capacity']}}</td>
                                    <td>NGN {{number_format($bed['registration_fee'])}}</td>
                                    <td>NGN {{number_format($bed['inspection_fee'])}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    

                    <div class="custom-separator"></div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label  class="ul-form__label"><strong>Supritendent Pharmacist:</strong></label>
                            <div><img class="w-25" src="{{ Auth::user()->photo ? asset('images/' . Auth::user()->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt=""></div>
                        </div>
                    </div>
                    
                    <div class="form-row">	
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Supritendent Pharmacist Name:</strong></label>
                            <div>{{$registration->pharmacist_name}}</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Supritendent Pharmacist Email:</strong></label>
                            <div>{{$registration->pharmacist_email}}</div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Supritendent Pharmacist Phone:</strong></label>
                            <div>{{$registration->pharmacist_phone}}</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Year of Qualification:</strong></label>
                            <div>{{$registration->qualification_year}}</div>
                        </div>
                        @if($registration->registration_no)
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Registration No.:</strong></label>
                            <div>{{$registration->registration_no}}</div>
                        </div>
                        @endif
                        @if($registration->last_year_licence_no)
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Last Year Annual License No.:</strong></label>
                            <div>{{$registration->last_year_licence_no}}</div>
                        </div>
                        @endif
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Residential Address:</strong></label>
                            <div>{{$registration->residential_address}}</div>
                        </div>
                    </div>
                <div class="custom-separator"></div>
            </div>
            @else
                <small>no status found!</small>
            @endif
        </div>
    </div>
@endsection