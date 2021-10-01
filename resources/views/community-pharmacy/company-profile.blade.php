@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Company Profile', 'route' => 'company-profile'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
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
                        type="text" placeholder="Enter your middle name" value="" readonly/>
                    @error('category_practise')
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