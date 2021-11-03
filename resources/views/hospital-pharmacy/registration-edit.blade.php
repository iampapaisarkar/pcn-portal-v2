@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Update Registration & Re-submit', 'route' => 'hospital-registration-status'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
            <form method="POST" action="{{ route('hospital-registration-update', $registration->id) }}" enctype="multipart/form-data" novalidate>
            @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <h3>Registration Year: {{ $registration->registration_year }}<h3>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="hospital_name1">Hospital name</label>
                        <input name="hospital_name" class="form-control @error('hospital_name') is-invalid @enderror"
                            id="hospital_name1" type="text" placeholder="Enter your first name"
                            value="{{Auth::user()->hospital_name}}" readonly />
                        @error('hospital_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="hospital_address1">Hospital name</label>
                        <input name="hospital_address" class="form-control @error('hospital_address') is-invalid @enderror"
                            id="hospital_address1" type="text" placeholder="Enter your middle name"
                            value="{{Auth::user()->hospital_address}}" readonly />
                        @error('hospital_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="huser_state">State:</label>
                        <input name="user_state" class="form-control @error('user_state') is-invalid @enderror"
                            value="{{Auth::user()->user_state->name}}" id="user_state" placeholder="user_state"  readonly />
                        @error('user_state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="huser_lga">LGA:</label>
                        <input name="user_lga" class="form-control @error('user_lga') is-invalid @enderror"
                            value="{{Auth::user()->user_lga->name}}" id="user_lga" placeholder="user_lga"  readonly />
                        @error('user_lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="custom-separator"></div>
                <h4>Select Appropriate Bed Capacity</h4>
                <div class="table-responsive @error('bed_capacity') is-invalid @enderror">
                    <table id="" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">Bed Capacity</th>
                                <!--th scope="col">New</th>
                                <th scope="col">Renewal</th-->
                                <th scope="col">Registration Fee</th>
                                <th scope="col">Inspection Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input name="bed_capacity" checked type="radio" value="{{App\Models\ServiceFeeMeta::where('id',  $registration->hospital_pharmacy->bed_capacity)->first()->id}}"></td>
                                <td>{{App\Models\ServiceFeeMeta::where('id',  $registration->hospital_pharmacy->bed_capacity)->first()->description}}</td>
                                <td>NGN {{number_format(App\Models\ServiceFeeMeta::where('id',  $registration->hospital_pharmacy->bed_capacity)->first()->registration_fee)}}</td>
                                <td>NGN {{number_format(App\Models\ServiceFeeMeta::where('id',  $registration->hospital_pharmacy->bed_capacity)->first()->inspection_fee)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @error('bed_capacity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <h6>Every Retention fee must be before January 31st of each year.</h6>


                <div class="custom-separator"></div>

                <div class="custom-separator"></div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Upload Passport Photo of Supritendent Pharmacist:</label>
                        <div class="custom-file mb-3">
                            <input name="passport" type="file" name="color_passportsize" class="custom-file-input
                            @error('passport') is-invalid @enderror" accept="images/*"
                                id="inputGroupFile01">
                            <label class="custom-file-label " for="inputGroupFile01"
                                aria-describedby="inputGroupFileAddon02" id="inputGroupFile01previewLabel">{{ $registration->hospital_pharmacy->passport }}</label>
                            @error('passport')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-center">
                        <img id="inputGroupFile01preview" src="{{ asset('storage/images/' . $registration->hospital_pharmacy->passport) }}" alt="" class="w-100">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Supritendent Pharmacist Name:</label>
                        <input name="pharmacist_name" class="form-control @error('pharmacist_name') is-invalid @enderror"
                        value="{{ $registration->hospital_pharmacy->pharmacist_name }}"
                        id="pharmacist_name" placeholder="Enter Supritendent Pharmacist Name" />
                        @error('pharmacist_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Supritendent Pharmacist Email:</label>
                        <input type="email" name="pharmacist_email" class="form-control @error('pharmacist_email') is-invalid @enderror"
                        value="{{ $registration->hospital_pharmacy->pharmacist_email }}"
                        id="pharmacist_email" placeholder="Enter Pharmacist Email" />
                        @error('pharmacist_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Supritendent Pharmacist Phone:</label>
                        <input name="pharmacist_phone" class="form-control @error('pharmacist_phone') is-invalid @enderror"
                        value="{{ $registration->hospital_pharmacy->pharmacist_phone }}"
                        id="pharmacist_phone" placeholder="Enter Supritendent Pharmacist Phone" />
                        @error('pharmacist_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Year of Qualification.:</label>
                        <select class="form-control @error('qualification_year') is-invalid @enderror" name="qualification_year">
                            <option selected="selected" hidden value="{{ $registration->hospital_pharmacy->qualification_year }}">{{ $registration->hospital_pharmacy->qualification_year }}</option>
                            <option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option>
                        </select>
                        @error('qualification_year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Registration No.:</label>
                        <input name="registration_no" class="form-control @error('registration_no') is-invalid @enderror"
                        value="{{ $registration->hospital_pharmacy->registration_no }}"
                        id="registration_no" placeholder="Enter Registration No" />
                        @error('registration_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Last Year Annual License No.:</label>
                        <input name="last_year_licence_no" class="form-control @error('last_year_licence_no') is-invalid @enderror"
                        value="{{ $registration->hospital_pharmacy->last_year_licence_no }}"
                        id="last_year_licence_no" placeholder="Enter Last Year Annual License No" />
                        @error('last_year_licence_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputEmail3" class="ul-form__label">Residential Address:</label>
                        <input name="residential_address" class="form-control @error('residential_address') is-invalid @enderror"
                        value="{{ $registration->hospital_pharmacy->residential_address }}"
                        id="residential_address" placeholder="Enter Last Year Annual License No" />
                        @error('residential_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn  btn-primary m-1" id="save" name="save">Update Application</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// passport on upload preview 
inputGroupFile01.onchange = evt => {
    const [file] = inputGroupFile01.files
    if (file) {
        $('#inputGroupFile01preview').attr('src', URL.createObjectURL(file));
        $('#inputGroupFile01previewLabel').html(file.name);
    }
}

</script>
@endsection