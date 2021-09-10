@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Tiered PPMV Registration - Licence', 'route' => 'ppmv-licence-pending-lists'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>Tiered PPMV Registration Licence - Vendor Details</h4>
        <x-vendor-p-p-m-v-application
        :applicationID="$licence->ppmv_application->id" 
        :vendorID="$licence->vendor_id"
        />

        <div class="custom-separator"></div>

        <h4>Inspection Report Recommendation</h4>

        @if($licence->status == 'recommended')
        <div class="alert alert-card alert-success" role="alert">
        <h3>Inspection Report: Recommended</h3> <a href="{{route('download-ppmv-inspection-report', $licence->id)}}" class="btn btn-rounded btn-success ml-3">Download Inspection Report</a></div>
        </div>
        @else
        <div class="alert alert-card alert-danger" role="alert">
        <h3>Inspection Report: Not Recommended</h3> <a href="{{route('download-ppmv-inspection-report', $licence->id)}}" class="btn btn-rounded btn-danger ml-3">Download Inspection Report</a>
        </div>
        @endif

        <div class="custom-separator"></div>

        <div class="px-3">
        <button onclick="issueLicence(event)" type="button" class="btn btn-primary">LICENCE ISSUE</button>
        <form id="licenceIssueForm" method="post" action="{{route('issue-single-licence', $licence->id)}}">
        @csrf
        </form>
        </div>

        <div class="custom-separator"></div>

        <x-all-activity
        :applicationID="$licence->id" 
        type="ppmv"
        />
    </div>
</div>
</div>
</div>


<script>
    function issueLicence(event){
        event.preventDefault();

        $.confirm({
            title: 'Issue Licence',
            content: 'Are you sure want to issue the licence?',
            buttons: {   
                ok: {
                    text: "YES",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        document.getElementById('licenceIssueForm').submit();
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