@extends('layouts.guest')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">{{ __('Confirm Password') }}</h1>
                        {{ __('Please confirm your password before continuing.') }}
                        <form  method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                            <div class="form-group">
                                <label for="email">Password</label>
                                <input name="password" class="form-control @error('password') is-invalid @enderror" id="password" type="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn mt-3">Confirm Password</button>
                        </form>
                        <div class="mt-3 text-center"><a class="text-muted" href="{{route('login')}}">
                                <u>Sign in</u></a></div>
                    </div>
                </div>
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('admin/dist-assets/images/photo-long-3.jpg')}})">
                    <div class="pr-3 auth-right">
                    <a class="btn btn btn-outline-primary btn-outline-email btn-block btn-icon-text" href="{{ route('register') }}"><i class="i-Mail-with-At-Sign"></i> Register Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
