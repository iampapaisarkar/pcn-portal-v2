@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Approval Inspection', 'route' => 'state-office-registration.index'])
<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body">
                <h5>Facility Approval Inspection - Details</h5>

                <x-ppmv-registration-preview
                :applicationID="$application->id" 
                :userID="$application->user_id" 
                type="ppmv" />

                <div class="custom-separator"></div>
                
                <h4>Upload Inspection Report</h4>
                <div class="row">
                    <form action="{{route('state-office-registration-ppmv-inspection-update')}}" method="POST" id="approveForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="application_id" value="{{$application->id}}">
                    <input type="hidden" name="user_id" value="{{$application->user_id}}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail3" class="ul-form__label">Recommendation:</label>
                                <select class="form-control @error('recommendation') is-invalid @enderror" name="recommendation">
                                    <option value="">Select Recommendation</option>
                                    <option value="facility_no_recommendation">NO RECOMMENDATION</option>
                                    <!-- <option value="partial_recommendation">PARTIAL RECOMMENDATION</option> -->
                                    <option value="facility_full_recommendation">FULL RECOMMENDATION</option>
                                </select>
                                @error('recommendation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="picker1" class="ul-form__label">Inspection Report (PDF)</label>
                                <div class="custom-file mb-3">
                                    <input name="report" type="file" class="custom-file-input
                                    @error('report') is-invalid @enderror" accept="application/pdf"
                                        id="inputGroupFile01">
                                    <label class="custom-file-label " for="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon02" id="inputGroupFile01previewLabel">Choose file</label>
                                    @error('report')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button onclick="submitApprove(event)" type="button" class="btn  btn-primary m-1" id="approve" name="approve">Submit Recommendation</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="custom-separator"></div>
                <x-all-activity
                :applicationID="$application->id" 
                type="ppmv" />
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