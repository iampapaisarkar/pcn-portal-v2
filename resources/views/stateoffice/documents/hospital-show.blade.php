@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Documents Verification', 'route' => 'state-office-documents.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Hospital Pharmacy Registration - Documents Verification</h5>
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
                    <form action="{{route('state-office-documents-hospital-approve')}}" method="POST" id="approveForm">
                    @csrf
                        <input type="hidden" name="registration_id" value="{{$registration->id}}">
                        <input type="hidden" name="user_id" value="{{$registration->user_id}}">
                        <button onclick="submitApprove(event)" type="button" class="btn  btn-success m-1" id="approve" name="approve">Approve Documents Verification</button>
                    </form>
                    <button data-toggle="modal" data-target="#queryModal" type="button" class="btn  btn-danger m-1" id="query" name="query">Query Documents Verification</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form id="quriedForm" class="w-100" method="POST" action="{{route('state-office-documents-hospital-reject')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reason for Query</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="registration_id" value="{{$registration->id}}">
                        <input type="hidden" name="user_id" value="{{$registration->user_id}}">
                        <label for="query1">State Reason</label>
                        <textarea name="query" class="form-control  @error('query') is-invalid @enderror" id="exampleFormControlTextarea1" placeholder="Enter your reason here" rows="3" required></textarea>
                        @error('query')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button onclick="submitReject(event)" type="button" class="btn btn-primary">Submit Query</button>
                    </div>
                    </div>
                    </form>
                </div>
                </div>
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

        function submitReject(event){
            event.preventDefault();

            $.confirm({
                title: 'Queried & Reject',
                content: 'Are you sure want to reject this registration?',
                buttons: {   
                    ok: {
                        text: "YES",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function(){
                            document.getElementById('quriedForm').submit();
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