@extends('layouts.guest')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('admin/dist-assets/images/photo-long-3.jpg')}})">
                    <div class="pl-3 auth-right">
                        <div class="auth-logo text-center mt-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">Existing Users</h1>
                            <h2 class="mb-3 text-14">If you have created a profile on this portal before now, please login</h2>
                        <div class="flex-grow-1"></div>
                        <div class="w-100 mb-4">
                        
                        <a class="btn btn-outline-primary btn-block btn-icon-text btn" href="{{ route('login') }}"><i class="i-Mail-with-At-Sign"></i> Sign in</a>
                        </div>
                        <div class="flex-grow-1"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4">
                        <h1 class="mb-3 text-18">{{ __('Register') }}</h1>
                        <form method="POST" action="{{ route('register') }}">
                        @csrf
                            <div class="form-group">
                                <label for="firstname">{{ __('Firstname') }}</label>
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lastname">{{ __('Lastname') }}</label>
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							<div class="form-group">
                                <label for="picker1">{{ __('User Type') }}</label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type">
                                    <option value="vendor" selected="selected">Tiered Patent Medicine Shop</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" autofocus>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="password-confirm" autofocus>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn mt-3">{{ __('Register') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
