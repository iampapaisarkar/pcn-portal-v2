@extends('layouts.guest')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">{{ __('Login') }}</h1>
                        <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn btn-primary btn-block mt-2">{{ __('Login') }}</button>
                        </form>
                        @if (Route::has('password.request'))
                        <div class="mt-3 text-center"><a class="text-muted" href="{{ route('password.request') }}">
                                <u>{{ __('Forgot Your Password?') }}</u></a></div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('admin/dist-assets/images/photo-long-3.jpg')}})">
                    <div class="pr-3 auth-right">
                    <h1 class="mb-3 text-18">New Users</h1>
                            <h2 class="mb-3 text-14">You need to register a profile to gain access to this portal</h2>
                    <a class="btn  btn-outline-primary btn-outline-email btn-block btn-icon-text" href="{{ route('register') }}"><i class="i-Mail-with-At-Sign"></i> Register Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
