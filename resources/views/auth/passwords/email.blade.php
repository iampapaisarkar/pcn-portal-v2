@extends('layouts.guest')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h1 class="mb-3 text-18">{{ __('Reset Password') }}</h1>
                        <form method="POST" action="{{ route('password.email') }}">
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
                            <button type="submit" class="btn btn-primary btn-block btn mt-3">{{ __('Send Password Reset Link') }}</button>
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
