@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Approval Pending', 'route' =>
'meptp-approval-states'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4>MEPTP Application Document Verification- Vendor Details</h4>
                <x-vendor-m-e-p-t-p-application :applicationID="$application->id" :vendorID="$application->vendor_id" />
                <div class="card-footer">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="tierSubmitForm" method="POST" action="{{ route('meptp-select-tier') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="application_id" value="{{$application->id}}">
                                <input type="hidden" name="vendor_id" value="{{$application->vendor_id}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Approval Action</h2>
                                        </div>
                                        <div class="custom-separator"></div>
                                        <div class="col-md-6 form-group mb-3">
                                            @php
                                                $tiers = app('App\Http\Services\BasicInformation')->tiers();
                                            @endphp
                                            <label for="picker1">Select Appropriate Tier</label>
                                            <select id="tierField" required name="tier" class="form-control @error('tier') is-invalid @enderror">
                                                <option selected value="">Select Tier</option>
                                                @foreach($tiers as $tier)
                                                <option value="{{$tier->id}}">{{$tier->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('tier')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button onclick="selectForTier(event)" type="button" class="btn  btn-primary m-1" id="save"
                                                name="save">Approve for Training</button>
                                            <button data-toggle="modal" data-target="#queryModal" type="button" class="btn  btn-danger m-1" id="query" name="query">Query Application</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <form id="quriedForm" class="w-100" method="POST" action="{{ route('meptp-approval-query') }}" enctype="multipart/form-data">
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
        <input type="hidden" name="vendor_id" value="{{$application->vendor_id}}">
        <label for="query1">Pharmacy Reason</label>
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
    function selectForTier(event){
        event.preventDefault();

        $.confirm({
            title: 'Approve and Set Tier',
            content: 'Are you sure want to approve & set tier for this application?',
            buttons: {   
                ok: {
                    text: "YES",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        document.getElementById('tierSubmitForm').submit();
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