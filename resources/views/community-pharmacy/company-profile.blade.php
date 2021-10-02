@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Company Profile', 'route' => 'company-profile'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Company Details</h3>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="firstName1">Company name</label>
                    <input name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                        id="company_name1" type="text" placeholder="Enter your company name"
                        value="" />
                    @error('company_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-8 form-group mb-3">
                    <label for="middleName1">Company Address</label>
                    <input name="company_address" class="form-control @error('company_address') is-invalid @enderror" id="company_address1"
                        type="text" placeholder="Enter your company address" value="" />
                    @error('company_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    @php
                    $states = app('App\Http\Services\BasicInformation')->states();
                    @endphp
                    <label for="picker1">State</label>
                    <select id="stateField" required name="state"
                        class="form-control @error('state') is-invalid @enderror">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    @php
                    $lgas = app('App\Http\Services\BasicInformation')->lgas();
                    @endphp
                    <label for="picker1">LGA</label>
                    <select id="lgaField" required name="lga" class="form-control @error('lga') is-invalid @enderror">
                    </select>
                    @error('lga')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Category of Practise</label>
                    <input name="category_practise" class="form-control @error('category_practise') is-invalid @enderror" id="category_practise1"
                        type="text" placeholder="Enter your middle name" value="Community Pharmacy" readonly/>
                    @error('category_practise')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Pharmacist In Control of Business</h3>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="firstName1">Name of Pharmacist:</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name1" type="text" placeholder="Enter your company name"
                        value="" />
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="middleName1">Full Registration Number:</label>
                    <input name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number1"
                        type="text" placeholder="Enter your company address" value="" />
                    @error('registration_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="picker1">Upload Supporting Documents (PDF):</label>
                    <div class="custom-file mb-3">
                        <input name="supporting_document" type="file" name="color_passportsize" class="custom-file-input
                        @error('supporting_document') is-invalid @enderror" accept="application/pdf"
                            id="supporting_document">
                        <label class="custom-file-label " for="supporting_document"
                            aria-describedby="supporting_document" id="supporting_documentpreviewLabel">Choose file</label>
                        @error('supporting_document')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="picker1">Upload Passport Photo of Pharmacist:</label>
                    <div class="custom-file mb-3">
                        <input name="photo" type="file" name="color_passportsize" class="custom-file-input"
                            id="inputGroupFile02" accept="image/*">
                        <label class="custom-file-label " for="inputGroupFile02"
                            aria-describedby="inputGroupFileAddon02">Choose file</label>
                    </div>
                    <div class="profilePreview">
                        <img id="profile-pic-new-preview" src="" alt="" class="w-25">
                        <img id="profile-pic-old-preview" src="{{asset('images/' . Auth::user()->photo)}}" alt=""
                            class="w-25">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Pharmacist Directors (as in CAC Form C.O.7)</h3>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="firstName1">Full name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name1" type="text" placeholder="Enter full name of director"
                        value="" />
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Full Registration Number:</label>
                    <input name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number1"
                        type="text" placeholder="Enter full registration number" value="" />
                    @error('registration_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Current Annual Licence Number:</label>
                    <input name="annual_licence_number" class="form-control @error('annual_licence_number') is-invalid @enderror" id="annual_licence_number1"
                        type="text" placeholder="Enter current annual licence number" value="" />
                    @error('annual_licence_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="firstName1">Full name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name1" type="text" placeholder="Enter full name of director"
                        value="" />
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Full Registration Number:</label>
                    <input name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number1"
                        type="text" placeholder="Enter full registration number" value="" />
                    @error('registration_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Current Annual Licence Number:</label>
                    <input name="annual_licence_number" class="form-control @error('annual_licence_number') is-invalid @enderror" id="annual_licence_number1"
                        type="text" placeholder="Enter current annual licence number" value="" />
                    @error('annual_licence_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="firstName1">Full name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name1" type="text" placeholder="Enter full name of director"
                        value="" />
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Full Registration Number:</label>
                    <input name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number1"
                        type="text" placeholder="Enter full registration number" value="" />
                    @error('registration_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Current Annual Licence Number:</label>
                    <input name="annual_licence_number" class="form-control @error('annual_licence_number') is-invalid @enderror" id="annual_licence_number1"
                        type="text" placeholder="Enter current annual licence number" value="" />
                    @error('annual_licence_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>

$("#datepicker").datepicker({
  dateFormat: 'dd-mm-yy',
  changeMonth: true,
  changeYear: true,
  yearRange: '-99:-18',
  defaultDate: '-18yr', 
});

$('#stateField').on('change', function() {
    var value = this.value;
    if (value && value.length != null) {
        $('#lgaField').removeAttr('disabled');
        var lgas = <?php if(isset($lgas)){echo $lgas;} ?>;
        var optionsHTML = '<option selected value="">Select LGA</option>';
        lgas.forEach(lga => {
            if (lga.state_id == value) {
                optionsHTML += '<option value="' + lga.id + '">' + lga.name + '</option>'
            }
        });
        $('#lgaField').html(optionsHTML);
    } else {
        $('#lgaField').html('<option selected value="">Select LGA</option>');
        $('#lgaField').attr('disabled');
    }
});

// Birth Certificate Photo on upload preview 
supporting_document.onchange = evt => {
    const [file] = supporting_document.files
    if (file) {
        $('#supporting_documentpreviewLabel').html(file.name);
    }
}

// Passport Photo on upload preview 
inputGroupFile02.onchange = evt => {
    const [file] = inputGroupFile02.files
    if (file) {
        $('#profile-pic-old-preview').hide();
        $('#profile-pic-new-preview').attr('src', URL.createObjectURL(file));
    }
}
</script>
<style>
.profilePreview img {
    border-radius: 100%;
}
</style>
@endsection