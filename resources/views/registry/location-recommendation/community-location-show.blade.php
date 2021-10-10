@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Location Approval Inspection Report', 'route' => 'registry-location-recommendation.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Location Approval Inspection Report - Details</h5>

                <x-location-registration-show
                :registrationID="$application->id" 
                :userID="$application->user_id" 
                :type="$application->type" />

                <div class="custom-separator"></div>
                <h4>Facility Inspection Report Recommendation</h4>
                <div class="alert alert-card alert-{{$alert['color']}}" role="alert">
                <h3>{{$alert['message']}}</h3>
                <a href="{{$alert['download-link']}}" target="_blank" class="btn btn-rounded btn-{{$alert['color']}} ml-3">Download Inspection Report</a>
                </div>

                <div class="custom-separator"></div>

                <div class="row">
                    <form action="{{route('registry-location-community-recommendation-approve')}}" method="POST" id="approveForm">
                    @csrf
                        <input type="hidden" name="application_id" value="{{$application->id}}">
                        <input type="hidden" name="user_id" value="{{$application->user_id}}">
                        <button onclick="submitApprove(event)" type="button" class="btn  btn-primary m-1" id="approve" name="approve">APPROVE LOCATION INSPECTION RECOMMENDATION</button>
                    </form>
                </div>
                <div class="custom-separator"></div>
                <x-all-activity
                :applicationID="$application->id" 
                :type="$application->type" />
            </div>
        </div>
    </div>

    <script>
        function submitApprove(event){
            event.preventDefault();

            $.confirm({
                title: 'Approve',
                content: 'Are you sure want to approve this application?',
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