@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Registration - Location Inspection', 'route' => 'monitoring-inspection-flt-reports.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Location Inspection report - Details</h5>

                <x-manufacturing-registration-show
                :registrationID="$registration->id" 
                :userID="$registration->user_id" 
                :type="$registration->type" />

                <div class="custom-separator"></div>
                <h4>Facility Inspection Report Recommendation</h4>
                <div class="alert alert-card alert-{{$alert['color']}}" role="alert">
                <h3>{{$alert['message']}}</h3>
                <a href="{{$alert['download-link']}}" target="_blank" class="btn btn-rounded btn-{{$alert['color']}} ml-3">Download Inspection Report</a>
                </div>
                <div class="custom-separator"></div>

                <x-all-activity
                :applicationID="$registration->id" 
                :type="$registration->type" />
            </div>
        </div>
    </div>

    <script>
        function submitApprove(event){
            event.preventDefault();

            $.confirm({
                title: 'Approve',
                content: 'Are you sure want to submit recommendation?',
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

        // report on upload preview 
        inputGroupFile01.onchange = evt => {
            const [file] = inputGroupFile01.files
            if (file) {
                $('#inputGroupFile01preview').attr('src', URL.createObjectURL(file));
                $('#inputGroupFile01previewLabel').html(file.name);
            }
        }

    </script>
@endsection