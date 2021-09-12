@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Inspection', 'route' => 'registry-documents.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Facility Inspection</h5>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail1" class="ul-form__label"><strong>Hospital Name:</strong></label>
                        <div>{{$registration->user->hospital_name}}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label"><strong>Hospital Address:</strong></label>
                        <div>{{$registration->user->hospital_address}}</div>
                        
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                        <div>{{$registration->user->user_state->name}}</div>
                        
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong> </label>
                        <div>{{$registration->user->user_lga->name}}</div>
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
                                    if ( $beds['id'] == $registration->hospital_pharmacy->bed_capacity ) {
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
                            <div>{{$registration->hospital_pharmacy->pharmacist_name}}</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Supritendent Pharmacist Email:</strong></label>
                            <div>{{$registration->hospital_pharmacy->pharmacist_email}}</div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Supritendent Pharmacist Phone:</strong></label>
                            <div>{{$registration->hospital_pharmacy->pharmacist_phone}}</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Year of Qualification:</strong></label>
                            <div>{{$registration->hospital_pharmacy->qualification_year}}</div>
                        </div>
                        @if($registration->hospital_pharmacy->registration_no)
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Registration No.:</strong></label>
                            <div>{{$registration->hospital_pharmacy->registration_no}}</div>
                        </div>
                        @endif
                        @if($registration->hospital_pharmacy->last_year_licence_no)
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Last Year Annual License No.:</strong></label>
                            <div>{{$registration->hospital_pharmacy->last_year_licence_no}}</div>
                        </div>
                        @endif
                        <div class="form-group col-md-4">
                            <label for="inputEmail3" class="ul-form__label"><strong>Residential Address:</strong></label>
                            <div>{{$registration->hospital_pharmacy->residential_address}}</div>
                        </div>
                    </div>
                <div class="custom-separator"></div>
                

                <div class="row">
                    <form action="{{route('registry-documents-hospital-approve')}}" method="POST" id="approveForm">
                    @csrf
                        <input type="hidden" name="registration_id" value="{{$registration->id}}">
                        <input type="hidden" name="user_id" value="{{$registration->user_id}}">
                        <button onclick="submitApprove(event)" type="button" class="btn  btn-primary m-1" id="approve" name="approve">APPROVE FOR FACILITY INSPECTION</button>
                    </form>
                </div>
                <div class="custom-separator"></div>
                <x-all-activity
                :applicationID="$registration->id" 
                type="hospital_pharmacy" />
            </div>
        </div>
    </div>

    <script>
        function submitApprove(event){
            event.preventDefault();

            $.confirm({
                title: 'Approve',
                content: 'Are you sure want to approve this registration?',
                buttons: {   
                    ok: {
                        text: "YES",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function(){
                            document.getElementById('approveForm').submit();
                        }
                    },
                    cancel: function(){
                            console.log('the user clicked cancel');
                    }
                }
            });

        }
    </script>
@endsection