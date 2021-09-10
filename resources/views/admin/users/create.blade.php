@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Add Users', 'route' => 'users.create'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <div class="card-title mb-3">Add New User</div>
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" novalidate>
        @csrf
            <div class="row">
            <div class="col-md-6 form-group mb-3">
                    <label for="firstName1">First name</label>
                    <input value="{{ old('firstname') }}" name="firstname" class="form-control @error('firstname') is-invalid @enderror" id="firstName1" type="text" placeholder="Enter your first name" />
                    @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="middleName1">Last name</label>
                    <input value="{{ old('lastname') }}" name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="middleName1" type="text" placeholder="Enter your last name" />
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" type="email" placeholder="Enter email"/>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> 
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="phone">Phone</label>
                    <input value="{{ old('phone') }}" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter phone"/>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="col-md-6 form-group mb-3">
                    <label for="picker1">User Type</label>
                    <select id="userTypeField" required name="type" class="form-control @error('type') is-invalid @enderror">
                        @foreach($roles as $role)
                            @if(old('type') && old('type') == $role->code)
                            <option hidden selected value="{{$role->code}}">{{$role->role}}</option>
                            @endif
                        <option value="{{$role->code}}">{{$role->role}}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div id="stateColumn" class="col-md-6 form-group mb-3" style="display: none;">
                    @php
                        $states = app('App\Http\Services\BasicInformation')->states();
                    @endphp
                    <label for="picker1">State (State Office)</label>
                    <select value="" required name="state" class="form-control @error('state') is-invalid @enderror">
                        <option  value="">Select State</option>
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
                @if(old('type') == 'state_office')
                <div id="oldStateColumn" class="col-md-6 form-group mb-3">
                    @php
                        $states = app('App\Http\Services\BasicInformation')->states();
                    @endphp
                    <label for="picker1">State (State Office)</label>
                    <select value="" required name="state" class="form-control @error('state') is-invalid @enderror">
                        <option  value="">Select State</option>
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
                @endif
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
$('#userTypeField').on('change', function() {
    var value = this.value;
    if(value && value == 'state_office'){
        $('#stateColumn').show();
        $('#oldStateColumn').hide();
    }else{
        $('#stateColumn').hide();
        $('#oldStateColumn').hide();
    }
});
</script>
@endsection