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
        <div class="card-footer mb-4">
            <div class="mc-footer">
                <h4>Upload Inspection Report</h4>
                <form id="RecommendationForm" class="w-100" method="POST" action="{{ route('ppmv-inspection-report-submit', $application->id) }}" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail3" class="ul-form__label">Recommendation:</label>
                            <div class="input-right-icon">
                                <select name="recommendation" class="form-control @error('recommendation') is-invalid @enderror" name="Recommendation">
                                    <option value="">Select Recommendation</option>
                                    @if(old('recommendation'))    
                                    <option hidden selected value="{{old('recommendation') == 'recommended' ? 'recommended' : 'unrecommended'}}">{{old('recommendation') == 'Recommended' ? 'recommended' : 'Not Recommended'}}</option>
                                    @endif
                                    <option value="recommended">Recommended</option>
                                    <option value="unrecommended">Not Recommended</option>
                                </select>
                            </div>
                            @error('recommendation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 d-flex flex-column justify-content-between">
                            <label for="picker1">Inspection Report (PDF):</label>
                            <div class="custom-file">
                                <input name="inspection_report" type="file" name="color_passportsize" class="custom-file-input
                                @error('inspection_report') is-invalid @enderror" accept="application/pdf"
                                    id="inputGroupFile01" accept="image/*">
                                <label class="custom-file-label " for="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon02" id="inputGroupFile01previewLabel">Choose file</label>
                                @error('inspection_report')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button onclick="submitRecommendation(event)" type="button" class="btn btn-primary">Submit Recommendation</button>
                </form>
            </div>
        </div>

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