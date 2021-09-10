@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Review Pending', 'route' => 'meptp-pending-batches'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>MEPTP Applications - Documents Review Pending</h4>
        <x-vendor-m-e-p-t-p-application 
        :applicationID="$application->id" 
        :vendorID="$application->vendor_id"
        />
        @if(Auth::user()->hasRole(['state_office']))
        <div class="card-footer">
            <div class="mc-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ route('meptp-pending-approve') }}?application_id={{$application->id}}&batch_id={{$application->batch_id}}&school_id={{$application->traing_centre}}&vendor_id={{$application->user->id}}" class="btn  btn-primary m-1" id="save" name="save">Approve</a>
                        <button data-toggle="modal" data-target="#queryModal" type="button" class="btn  btn-danger m-1" id="query" name="query">Query</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="quriedForm" class="w-100" method="POST" action="{{ route('meptp-pending-query') }}" enctype="multipart/form-data">
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
                <input type="hidden" name="batch_id" value="{{$application->batch_id}}">
                <input type="hidden" name="school_id" value="{{$application->traing_centre}}">
                <input type="hidden" name="vendor_id" value="{{$application->vendor_id}}">
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

        <script>
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
        @endif
    </div>
</div>
</div>
</div>
@endsection