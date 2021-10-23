@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Location Approval', 'route' => 'location-approval-form'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        @if(app('App\Http\Services\ManufacturingInfo')->canSubmitRegistration()['success'] == true)
        @php 
            $company = Auth::user()->company()->first();
            $company_state = Auth::user()->company()->first() ? Auth::user()->company()->first()->company_state()->first() : null;
            $company_lga = Auth::user()->company()->first() ? Auth::user()->company()->first()->company_lga()->first() : null;
            $business = Auth::user()->company()->first() ? Auth::user()->company()->first()->business()->first() : null;
            $director = Auth::user()->company()->first() ? Auth::user()->company()->first()->director()->get() : null;
            $other_director = Auth::user()->company()->first() ? Auth::user()->company()->first()->other_director()->get() : null;
        @endphp
        <form method="POST" action="{{route('manufacturing-registration-submit')}}" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Company Details</h3>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="name">Company name</label>
                    <input readonly class="form-control"
                        id="company_name1" type="text" placeholder="Enter your company name"
                        value="{{ $company ? $company->name : old('company_name')}}" />
                </div>
                <div class="col-md-8 form-group mb-3">
                    <label for="copmany_address1">Company Address</label>
                    <input readonly class="form-control" id="copmany_address1"
                        type="text" placeholder="Enter your company address" value="{{ $company ? $company->address : old('company_address')}}" />
                </div>
                <div class="col-md-4 form-group mb-3">
                    @php
                    $states = app('App\Http\Services\BasicInformation')->states();
                    @endphp
                    <label for="picker1">State</label>
                    <select readonly id="stateField" required
                        class="form-control ">
                        @if($company_state)
                        <option hidden selected value="{{$company_state->id}}">
                            {{$company_state->name}}</option>
                        @endif
                        <option {{!$company_state ? 'selected' : ''}} value="">Select State</option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group mb-3">
                    @php
                    $lgas = app('App\Http\Services\BasicInformation')->lgas();
                    @endphp
                    <label for="picker1">LGA</label>
                    <select readonly {{!$company_lga ? 'disabled' : ''}} id="lgaField" required
                        class="form-control">
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
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Category of Practise</label>
                    <input readonly class="form-control" id="category1"
                        type="text" placeholder="Enter your category" value="{{ $company ? $company->category : 'Community Pharmacy' }}" readonly/>
                </div>
            </div>
            <div class="custom-separator"></div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Pharmacist In Control of Business</h3>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="pharmacist_name1">Name of Pharmacist:</label>
                    <input readonly class="form-control"
                        id="pharmacist_name1" type="text" placeholder="Enter your company name"
                        value="{{ $business ? $business->name : old('pharmacist_name')}}" />
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="pharmacist_registration_number1">Full Registration Number:</label>
                    <input readonly class="form-control" id="pharmacist_registration_number1"
                        type="text" placeholder="Enter your company address" value="{{ $business ? $business->registration_number : old('pharmacist_registration_number')}}" />
                </div>


                <div class="col-md-4 form-group mb-3">
                    <label for="picker1">Upload Passport Photo of Pharmacist:</label>
                    <div class="profilePreview">
                        <img id="profile-pic-new-preview" src="" alt="" class="w-25">
                        <img id="profile-pic-old-preview" src="{{ $business ? asset('images/' . $business->passport) : ''}}" alt=""
                            class="w-25">
                    </div>
                </div>
            </div>
            <div class="custom-separator"></div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Pharmacist Directors (as in CAC Form C.O.7)</h3>
                </div>
                
                <div class="col-12" id="directorRow">
                    @foreach($director as $key => $direct)
                    <div class="row directorRow" id="directorID_{{$key}}">
                        <div class="col-md-4 form-group mb-3">
                            <label for="director_name1">Full name</label>
                            <input readonly class="form-control "
                                id="director_name1" type="text" placeholder="Enter full name of director"
                                value="{{ $director ? $director[$key]['name'] : old('director[$key][director_name]')}}" />
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="director_registration_number1">Full Registration Number:</label>
                            <input readonly class="form-control " id="director_registration_number1"
                                type="text" placeholder="Enter full registration number" value="{{ $director ? $director[$key]['registration_number'] : old('director[$key][director_registration_number]')}}" />
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="director_licence_number">Current Annual Licence Number:</label>
                            <input readonly class="form-control " id="director_licence_number1"
                                type="text" placeholder="Enter current annual licence number" value="{{ $director ? $director[$key]['licence_number'] : old('director[$key][director_licence_number]')}}" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="custom-separator"></div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Other Directors (as in CAC Form C.O.7)</h3>
                </div>

                <div class="col-12" id="otherDirectorRow">
                    @foreach($other_director as $key => $other)
                    <div class="row otherDirectorRow" id="otherDirectorID_{{$key}}">
                        <div class="col-md-6 form-group mb-3">
                            <label for="other_director_name1">Full name</label>
                            <input readonly class="form-control"
                            id="other_director_name1" type="text" placeholder="Enter full name of director"
                            value="{{ $other_director ? $other_director[$key]['name'] : old('other_director[$key][other_director_name]')}}" />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="other_director_profession1">Profession:</label>
                            <input readonly class="form-control" id="other_director_profession1"
                            type="text" placeholder="Enter profession"
                            value="{{ $other_director ? $other_director[$key]['profession'] : old('other_director[$key][other_director_profession]')}}" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="custom-separator"></div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <h3>Superintendent Pharmacist</h3>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="firstname1">First name</label>
                    <input name="firstname" class="form-control @error('firstname') is-invalid @enderror"
                        id="firstname1" type="text" placeholder="Enter your first name"/>
                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middlename1">Middle name (Optional)</label>
                    <input name="middlename" class="form-control @error('middlename') is-invalid @enderror" id="middlename1"
                        type="text" placeholder="Enter your middle name" />
                    @error('middlename')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="surname1">Surname</label>
                    <input name="surname" class="form-control @error('surname') is-invalid @enderror" id="surname1"
                        type="text" placeholder="Enter your sur name" />
                    @error('surname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 form-group mb-3">
                    <label for="email1">Email address</label>
                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email1" type="email" placeholder="Enter your email address"/>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="phone1">Phone</label>
                    <input name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone1"
                        type="text" placeholder="Enter your phone" />
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="gender1">Gender</label>
                    <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                        <option selected="" hidden>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4 form-group mb-3">
                    <label for="doq1">Date of Qualification</label>
                    <input name="doq" class="form-control @error('doq') is-invalid @enderror"
                        id="doq1" type="date" placeholder="Enter your date of qualification"/>
                    @error('doq')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="residental_address1">Current Residential Address:</label>
                    <input name="residental_address" class="form-control @error('residental_address') is-invalid @enderror" id="residental_address1"
                        type="text" placeholder="Enter your residental address" />
                    @error('residental_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="annual_licence_no1">Last Annual licence no</label>
                    <input name="annual_licence_no" class="form-control @error('annual_licence_no') is-invalid @enderror" id="annual_licence_no1"
                        type="text" placeholder="Enter your annual licence no" />
                    @error('annual_licence_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="custom-separator"></div>

            <div class="form-row">                   
                <p>Note :</p>
                <div class="form-group col-md-12">
                        <p>(a) The Registrar should be notified immediately of any change in address of permises or any change of pharmacist in person control of the buissness.</p>
                </div>
                <div class="form-group col-md-12">
                        <p>(b)Take notice that the Pharmacists Council of Nigeria (PCN) shall make a claim and recover all cost of litigation incurred by it in defence of any court action instituted against it at the instance of any registred Pharmacist and/or registred Pharmaceutical premises and whereby the suit is struck out , withdrawn or the pharmacist or the pharmaceutical premises loses the case.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit Registration Application</button>
                </div>
            </div>
        </form>
        @else
            <div class="alert alert-card alert-warning" role="alert">
                {{app('App\Http\Services\ManufacturingInfo')->canSubmitRegistration()['message']}}
            </div>
        @endif
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