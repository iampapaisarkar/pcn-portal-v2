@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Licecne Issued', 'route' => 'licence-issued.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Facility Licecne Issued</h5>

                <x-manufacturing-registration-show
                :registrationID="$registration->id" 
                :userID="$registration->user_id" 
                :type="$registration->type" />

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
                title: 'Issue Licence',
                content: 'Are you sure want to issue licence for this registration?',
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