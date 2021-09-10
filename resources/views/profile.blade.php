@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Profile', 'route' => 'profile'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        @if (session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('profile-update') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label for="firstName1">First name</label>
                    <input name="firstname" class="form-control @error('firstname') is-invalid @enderror"
                        id="firstName1" type="text" placeholder="Enter your first name"
                        value="{{Auth::user()->firstname}}" readonly />
                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Last name</label>
                    <input name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="middleName1"
                        type="text" placeholder="Enter your middle name" value="{{Auth::user()->lastname}}" readonly />
                    @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                        id="exampleInputEmail1" type="email" placeholder="Enter email" value="{{Auth::user()->email}}"
                        readonly />
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="phone">Phone</label>
                    <input name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        placeholder="Enter phone" value="{{Auth::user()->phone}}" readonly />
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="credit1">Profile Type</label>
                    <input name="type" class="form-control @error('phone') is-invalid @enderror" id="credit1"
                        placeholder="Card" value="{{Auth::user()->role->role}}" readonly />
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @can('isVendor')
                <div class="col-md-4 form-group mb-3">
                    <label for="haddress">Address:</label>
                    <input name="address" class="form-control @error('address') is-invalid @enderror"
                        value="{{Auth::user()->address}}" id="address" placeholder="Address" required />
                    @error('address')
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
                        @if(Auth::user()->state)
                        <option hidden selected value="{{Auth::user()->user_state->id}}">
                            {{Auth::user()->user_state->name}}</option>
                        @endif
                        <option {{!Auth::user()->state ? 'selected' : ''}} value="">Select State</option>
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
                    <select {{!Auth::user()->lga ? 'disabled' : ''}} id="lgaField" required name="lga"
                        class="form-control @error('lga') is-invalid @enderror">
                        @if(Auth::user()->lga)
                        <option hidden selected value="{{Auth::user()->user_lga->id}}">{{Auth::user()->user_lga->name}}
                        </option>
                        @endif
                        <option {{!Auth::user()->lga ? 'selected' : ''}} value="">Select LGA</option>
                        @if(Auth::user()->lga)
                        @foreach(Auth::user()->user_state->lga as $lga)
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
                    <label for="datepicker">Date of Birth</label>
                    <input readonly name="dob" class="form-control @error('dob') is-invalid @enderror" id="datepicker"
                        value="{{Auth::user()->dob}}" placeholder="dd-mm-yyyy" name="dp" required />
                    @error('dob')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="picker1">Passport Photo</label>
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
                        <!-- @if(Auth::user()->photo)
                            <a href="#">Remove photo</a>
                        @endif -->
                    </div>
                </div>
                @endcan
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

        <form class="mt-5" method="POST" action="{{ route('profile-password-update') }}" enctype="multipart/form-data">
            @csrf
            <h5>Update Password</h5>
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label for="old_password1">Old Password</label>
                    <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" />
                    @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="password1">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" />
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="password_confirmation1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" />
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
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