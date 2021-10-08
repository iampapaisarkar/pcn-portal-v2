@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Documents Verification', 'route' => 'state-office-documents.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Distribution Premises Location Approval - Documents Verification</h5>
                <x-location-registration-show
                :registrationID="$application->id" 
                :userID="$application->user_id" 
                :type="$application->type" />

                <div class="custom-separator"></div>

                <div class="row">
                    <form action="{{route('state-office-documents-distribution-approve')}}" method="POST" id="approveForm">
                    @csrf
                        <input type="hidden" name="application_id" value="{{$application->id}}">
                        <input type="hidden" name="user_id" value="{{$application->user_id}}">
                        <button onclick="submitApprove(event)" type="button" class="btn  btn-success m-1" id="approve" name="approve">Approve Documents Verification</button>
                    </form>
                    <button data-toggle="modal" data-target="#queryModal" type="button" class="btn  btn-danger m-1" id="query" name="query">Query Documents Verification</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form id="quriedForm" class="w-100" method="POST" action="{{route('state-office-documents-distribution-reject')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reason for Query</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="application_id" value="{{$application->id}}">
                        <input type="hidden" name="user_id" value="{{$application->user_id}}">
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

        function submitReject(event){
            event.preventDefault();

            $.confirm({
                title: 'Queried & Reject',
                content: 'Are you sure want to reject this application?',
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