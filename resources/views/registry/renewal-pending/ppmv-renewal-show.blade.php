@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Licecne ', 'route' => 'licence-pending.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Facility Licecne - Details</h5>

                <x-ppmv-registration-preview
                :applicationID="$registration->registration->id" 
                :userID="$registration->user_id" 
                type="ppmv" />

                <div class="custom-separator"></div>

                <div class="row">
                    <form action="{{route('registry-renewal-pending-ppmv-approve')}}" method="POST" id="approveForm">
                    @csrf

                        <input type="hidden" name="registration_id" value="{{$registration->registration->id}}">
                        <input type="hidden" name="ppmv_registration_id" value="{{$registration->ppmv->id}}">
                        <input type="hidden" name="renewal_id" value="{{$registration->id}}">
                        <input type="hidden" name="user_id" value="{{$registration->user_id}}">

                        <button onclick="submitApprove(event)" type="button" class="btn  btn-primary m-1" id="approve" name="approve">APPROVE FOR FACILITY INSPECTION</button>
                    </form>
                </div>
                <div class="custom-separator"></div>
                <x-all-activity
                :applicationID="$registration->registration->id" 
                type="ppmv" />
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