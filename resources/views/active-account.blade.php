@extends('layouts.guest')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">{{ __('Active your account') }}</h1>
                        <form method="POST" action="{{ route('activision-account') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ Request::get('t') }}">
                            <div class="form-group">
                                <label for="email">{{ __('Default login email') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" value="{{ Request::get('e') }}" required autocomplete="email" autofocus readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input class="form-control" name="password_confirmation" id="password-confirm" type="password" required autocomplete="password-confirm">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn mt-3">{{ __('Set Password & Active Account') }}</button>
                        </form>
                    </div>
                </div>
                <!-- <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('admin/dist-assets/images/photo-long-3.jpg')}})">
                    <div class="pr-3 auth-right">
                    <a onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="btn btn btn-outline-primary btn-outline-email btn-block btn-icon-text" href="#"><i class="i-Mail-with-At-Sign"></i>Login with another email</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection