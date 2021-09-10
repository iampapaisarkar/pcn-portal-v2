@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Tiered PPMV Registration - Inspection', 'route' => 'ppmv-inspection-applications'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>Tiered PPMV Registration Document Verification - Vendor Details</h4>
        <x-vendor-p-p-m-v-application
        :applicationID="$application->ppmv_application->id" 
        :vendorID="$application->vendor_id"
        />

        <div class="custom-separator"></div>

        <h4>Inspection Report Recommendation</h4>

        @if($application->status == 'recommended')
        <div class="alert alert-card alert-success" role="alert">
        <h3>Inspection Report: Recommended</h3> <a href="{{route('download-ppmv-inspection-report', $application->id)}}" class="btn btn-rounded btn-success ml-3">Download Inspection Report</a></div>
        </div>
        @else
        <div class="alert alert-card alert-danger" role="alert">
        <h3>Inspection Report: Not Recommended</h3> <a href="{{route('download-ppmv-inspection-report', $application->id)}}" class="btn btn-rounded btn-danger ml-3">Download Inspection Report</a>
        </div>
        @endif

        <div class="custom-separator"></div>

        <x-all-activity
        :applicationID="$application->id" 
        type="ppmv"
        />
    </div>
</div>
</div>
</div>


<script>
    function submitRecommendation(event){
        event.preventDefault();

        $.confirm({
            title: 'Submit Recommendation',
            content: 'Are you sure want to submit?',
            buttons: {   
                ok: {
                    text: "YES",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        document.getElementById('RecommendationForm').submit();
                    }
                },
                cancel: function(){
                        console.log('the user clicked cancel');
                }
            }
        });

    }

    // Educational Certificate Photo on upload preview 
    inputGroupFile01.onchange = evt => {
        const [file] = inputGroupFile01.files
        if (file) {
            $('#inputGroupFile01preview').attr('src', URL.createObjectURL(file));
            $('#inputGroupFile01previewLabel').html(file.name);
        }
    }
</script>
@endsection