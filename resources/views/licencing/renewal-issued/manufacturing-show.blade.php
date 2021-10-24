@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Licecne', 'route' => 'licence-pending.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Facility Licecne - Details</h5>

                <x-manufacturing-registration-show
                :registrationID="$registration->registration->id" 
                :userID="$registration->registration->user_id" 
                :type="$registration->registration->type" />

                <div class="custom-separator"></div>
                
                <x-all-activity
                :applicationID="$registration->registration->id" 
                :type="$registration->registration->type"/>
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