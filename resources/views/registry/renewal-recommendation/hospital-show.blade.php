@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Renewal Inspection', 'route' => 'registry-renewal-recommendation.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Renewal Inspection</h5>

                <x-hospital-pharmacy-preview
                :registrationID="$registration->registration->id" 
                :userID="$registration->user_id" 
                type="hospital_pharmacy" />

                <div class="custom-separator"></div>
                

                <div class="row">
                    <form action="{{route('registry-renewal-recommendation-approve')}}" method="POST" id="approveForm">
                    @csrf
                        <input type="hidden" name="registration_id" value="{{$registration->registration->id}}">
                        <input type="hidden" name="hospital_registration_id" value="{{$registration->hospital_pharmacy->id}}">
                        <input type="hidden" name="renewal_id" value="{{$registration->id}}">
                        <input type="hidden" name="user_id" value="{{$registration->user_id}}">
                        <button onclick="submitApprove(event)" type="button" class="btn  btn-primary m-1" id="approve" name="approve">APPROVE FOR FACILITY INSPECTION</button>
                    </form>
                </div>
                <div class="custom-separator"></div>
                <x-all-activity
                :applicationID="$registration->registration->id" 
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