@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Company Profile', 'route' => 'company-profile'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        @if (session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>
        @endif
        @php 
            $company = Auth::user()->company()->first();
            $company_state = Auth::user()->company()->first() ? Auth::user()->company()->first()->company_state()->first() : null;
            $company_lga = Auth::user()->company()->first() ? Auth::user()->company()->first()->company_lga()->first() : null;
            $business = Auth::user()->company()->first() ? Auth::user()->company()->first()->business()->first() : null;
            $director = Auth::user()->company()->first() ? Auth::user()->company()->first()->director()->get() : null;
            $other_director = Auth::user()->company()->first() ? Auth::user()->company()->first()->other_director()->get() : null;
        @endphp
        <form method="POST" action="{{route('company-profile-update')}}" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Company Details</h3>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="name">Company name</label>
                    <input name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                        id="company_name1" type="text" placeholder="Enter your company name"
                        value="{{ $company ? $company->name : old('company_name')}}" />
                    @error('company_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-8 form-group mb-3">
                    <label for="copmany_address1">Company Address</label>
                    <input name="copmany_address" class="form-control @error('copmany_address') is-invalid @enderror" id="copmany_address1"
                        type="text" placeholder="Enter your company address" value="{{ $company ? $company->address : old('company_address')}}" />
                    @error('copmany_address')
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
                        @if($company_state)
                        <option hidden selected value="{{$company_state->id}}">
                            {{$company_state->name}}</option>
                        @endif
                        <option {{!$company_state ? 'selected' : ''}} value="">Select State</option>
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
                    <select {{!$company_lga ? 'disabled' : ''}} id="lgaField" required name="lga"
                        class="form-control @error('lga') is-invalid @enderror">
                        @if($company_lga)
                        <option hidden selected value="{{$company_lga->id}}">{{$company_lga->name}}
                        </option>
                        @endif
                        <option {{!$company_lga ? 'selected' : ''}} value="">Select LGA</option>
                        @if($company_lga)
                            @foreach($company_state->lga()->get() as $lga)
                            <option value="{{$lga->id}}">{{$lga->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('lga')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Category of Practise</label>
                    <input name="category" class="form-control @error('category') is-invalid @enderror" id="category1"
                        type="text" placeholder="Enter your category" value="{{ $company ? $company->category : 'Community Pharmacy' }}" readonly/>
                    @error('category')
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
                    <label for="pharmacist_name1">Name of Pharmacist:</label>
                    <input name="pharmacist_name" class="form-control @error('pharmacist_name') is-invalid @enderror"
                        id="pharmacist_name1" type="text" placeholder="Enter your company name"
                        value="{{ $business ? $business->name : old('pharmacist_name')}}" />
                    @error('pharmacist_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="pharmacist_registration_number1">Full Registration Number:</label>
                    <input name="pharmacist_registration_number" class="form-control @error('pharmacist_registration_number') is-invalid @enderror" id="pharmacist_registration_number1"
                        type="text" placeholder="Enter your company address" value="{{ $business ? $business->registration_number : old('pharmacist_registration_number')}}" />
                    @error('pharmacist_registration_number')
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
                            aria-describedby="supporting_document" id="supporting_documentpreviewLabel">{{ $business ? $business->supporting_document : 'Choose file'}}</label>
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
                        <input name="passport" type="file" name="color_passportsize" class="custom-file-input"
                            id="inputGroupFile02" accept="image/*">
                        <label class="custom-file-label " for="inputGroupFile02"
                            aria-describedby="inputGroupFileAddon02">Choose file</label>
                    </div>
                    <div class="profilePreview">
                        <img id="profile-pic-new-preview" src="" alt="" class="w-25">
                        <img id="profile-pic-old-preview" src="{{ $business ? asset('images/' . $business->passport) : ''}}" alt=""
                            class="w-25">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <h3>Pharmacist Directors (as in CAC Form C.O.7)</h3>
                </div>
                <div class="col-md-6 form-group mb-3 d-flex justify-content-end">
                    <button type="button" onclick="addDirectorRow()" class="btn btn-primary">Add row</button>
                </div>
                
                <div class="col-12" id="directorRow">
                    @foreach($director as $key => $direct)
                    <div class="row directorRow" id="directorID_{{$key}}">
                        <div class="col-md-3 form-group mb-3">
                            <label for="director_name1">Full name</label>
                            <input name="director[{{$key}}][director_name]" class="form-control @error('director_name') is-invalid @enderror"
                                id="director_name1" type="text" placeholder="Enter full name of director"
                                value="{{ $director ? $director[$key]['name'] : old('director[$key][director_name]')}}" />
                            @error('director_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="director_registration_number1">Full Registration Number:</label>
                            <input name="director[{{$key}}][director_registration_number]" class="form-control @error('director_registration_number') is-invalid @enderror" id="director_registration_number1"
                                type="text" placeholder="Enter full registration number" value="{{ $director ? $director[$key]['registration_number'] : old('director[$key][director_registration_number]')}}" />
                            @error('director_registration_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="director_licence_number">Current Annual Licence Number:</label>
                            <input name="director[{{$key}}][director_licence_number]" class="form-control @error('director_licence_number') is-invalid @enderror" id="director_licence_number1"
                                type="text" placeholder="Enter current annual licence number" value="{{ $director ? $director[$key]['licence_number'] : old('director[$key][director_licence_number]')}}" />
                            @error('director_licence_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group mb-3 d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-secondary mt-3" id="deleteDirectorRow_{{$key}}" onclick="deleteDirectorRow({{$key}})">Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <h3>Other Directors (as in CAC Form C.O.7)</h3>
                </div>
                <div class="col-md-6 form-group mb-3 d-flex justify-content-end">
                    <button type="button" onclick="addOtherDirectorRow()" class="btn btn-primary">Add row</button>
                </div>

                <div class="col-12" id="otherDirectorRow">
                    @foreach($other_director as $key => $other)
                    <div class="row otherDirectorRow" id="otherDirectorID_{{$key}}">
                        <div class="col-md-5 form-group mb-3">
                            <label for="other_director_name1">Full name</label>
                            <input name="other_director[{{$key}}][other_director_name]" class="form-control"
                            id="other_director_name1" type="text" placeholder="Enter full name of director"
                            value="{{ $other_director ? $other_director[$key]['name'] : old('other_director[$key][other_director_name]')}}" />
                        </div>
                        <div class="col-md-5 form-group mb-3">
                            <label for="other_director_profession1">Profession:</label>
                            <input name="other_director[{{$key}}][other_director_profession]" class="form-control" id="other_director_profession1"
                            type="text" placeholder="Enter profession"
                            value="{{ $other_director ? $other_director[$key]['profession'] : old('other_director[$key][other_director_profession]')}}" />
                        </div>
                        <div class="col-md-2 form-group mb-3 d-flex align-items-center">
                           <button type="button" class="btn btn-sm btn-secondary mt-3" id="deleteOtherDirectorRow_{{$key}}" onclick="deleteOtherDirectorRow({{$key}})">Delete</button>
                        </div>
                    </div>
                    @endforeach
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


function addDirectorRow(){
    var rowCount = $('.directorRow').length;

    if(rowCount == 0){
        var formHtml = '<div class="row directorRow" id="directorID_'+rowCount+'">\
                            <div class="col-md-3 form-group mb-3">\
                                <label for="director_name1">Full name</label>\
                                <input name="director['+rowCount+'][director_name]" class="form-control"\
                                id="director_name1" type="text" placeholder="Enter full name of director"\
                                value="" />\
                            </div>\
                            <div class="col-md-3 form-group mb-3">\
                                <label for="director_registration_number1">Full Registration Number:</label>\
                                <input name="director['+rowCount+'][director_registration_number]" class="form-control id="director_registration_number1"\
                                type="text" placeholder="Enter full registration number" value="" />\
                            </div>\
                            <div class="col-md-4 form-group mb-3">\
                                <label for="director_licence_number">Current Annual Licence Number:</label>\
                                <input name="director['+rowCount+'][director_licence_number]" class="form-control @error('director_licence_number') is-invalid @enderror" id="director_licence_number1"\
                                type="text" placeholder="Enter current annual licence number" value="" />\
                            </div>\
                            <div class="col-md-2 form-group mb-3 d-flex align-items-center">\
                                <button type="button" class="btn btn-sm btn-secondary mt-3" id="deleteDirectorRow_'+rowCount+'" onclick="deleteDirectorRow('+rowCount+')">Delete</button>\
                            </div>\
                        </div>';

        $("#directorRow").append(formHtml);
    }else{
        formHtml = '<div class="row directorRow" id="directorID_'+rowCount+'">\
                        <div class="col-md-3 form-group mb-3">\
                            <label for="director_name1">Full name</label>\
                            <input name="director['+rowCount+'][director_name]" class="form-control"\
                            id="director_name1" type="text" placeholder="Enter full name of director"\
                            value="" />\
                        </div>\
                        <div class="col-md-3 form-group mb-3">\
                            <label for="director_registration_number1">Full Registration Number:</label>\
                            <input name="director['+rowCount+'][director_registration_number]" class="form-control id="director_registration_number1"\
                            type="text" placeholder="Enter full registration number" value="" />\
                        </div>\
                        <div class="col-md-4 form-group mb-3">\
                            <label for="director_licence_number">Current Annual Licence Number:</label>\
                            <input name="director['+rowCount+'][director_licence_number]" class="form-control @error('director_licence_number') is-invalid @enderror" id="director_licence_number1"\
                            type="text" placeholder="Enter current annual licence number" value="" />\
                        </div>\
                        <div class="col-md-2 form-group mb-3 d-flex align-items-center">\
                            <button type="button" class="btn btn-sm btn-secondary mt-3" id="deleteDirectorRow_'+rowCount+'" onclick="deleteDirectorRow('+rowCount+')">Delete</button>\
                        </div>\
                    </div>';
        $("#directorRow").append(formHtml);
    }
}

function deleteDirectorRow(id){
    $("#directorID_"+id).remove();
}




function addOtherDirectorRow(){
    var rowCount = $('.otherDirectorRow').length;

    if(rowCount == 0){
        var formHtml = '<div class="row otherDirectorRow" id="otherDirectorID_'+rowCount+'">\
                        <div class="col-md-5 form-group mb-3">\
                            <label for="other_director_name1">Full name</label>\
                            <input name="other_director['+rowCount+'][other_director_name]" class="form-control"\
                            id="other_director_name1" type="text" placeholder="Enter full name of director"\
                            value="" />\
                        </div>\
                        <div class="col-md-5 form-group mb-3">\
                            <label for="other_director_profession1">Profession:</label>\
                            <input name="other_director['+rowCount+'][other_director_profession]" class="form-control id="other_director_profession1"\
                            type="text" placeholder="Enter profession"\
                            value="" />\
                        </div>\
                        <div class="col-md-2 form-group mb-3 d-flex align-items-center">\
                           <button type="button" class="btn btn-sm btn-secondary mt-3" id="deleteOtherDirectorRow_'+rowCount+'" onclick="deleteOtherDirectorRow('+rowCount+')">Delete</button>\
                        </div>\
                    </div>';

        $("#otherDirectorRow").append(formHtml);
    }else{
        formHtml = '<div class="row otherDirectorRow" id="otherDirectorID_'+rowCount+'">\
                        <div class="col-md-5 form-group mb-3">\
                            <label for="other_director_name1">Full name</label>\
                            <input name="other_director['+rowCount+'][other_director_name]" class="form-control"\
                            id="other_director_name1" type="text" placeholder="Enter full name of director"\
                            value="" />\
                        </div>\
                        <div class="col-md-5 form-group mb-3">\
                            <label for="other_director_profession1">Profession:</label>\
                            <input name="other_director['+rowCount+'][other_director_profession]" class="form-control id="other_director_profession1"\
                            type="text" placeholder="Enter profession"\
                            value="" />\
                        </div>\
                        <div class="col-md-2 form-group mb-3 d-flex align-items-center">\
                            <button type="button" class="btn btn-sm btn-secondary mt-3" id="deleteOtherDirectorRow_'+rowCount+'" onclick="deleteOtherDirectorRow('+rowCount+')">Delete</button>\
                        </div>\
                    </div>';
        $("#otherDirectorRow").append(formHtml);
    }
}

function deleteOtherDirectorRow(id){
    $("#otherDirectorID_"+id).remove();
}

</script>
<style>
.profilePreview img {
    border-radius: 100%;
}
</style>
@endsection