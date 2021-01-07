@extends('layouts.auth')

@section('title')
    Admin Login
@endsection

@section('title-text')
    Hello there!
@endsection


@section('subtitle-text')
    Sign in your account
@endsection

@section('form')
<form action="{{ route('login') }}" method="post">
    @csrf
    <div class="input-group">
        <label for="emailaddress">Email address</label>
        <input value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" type="email" id="emailaddress" name="email" placeholder="Enter your email" />
        @error('email')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="input-group">
        <label for="password">Password</label>
        <div class="input-group input-group-merge">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" />
            <div class="input-group-append" data-password="false">
                <div class="input-group-text">
                    <span class="password-eye"></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="input-group input-footer">
        <p class="text">Login directly with Email?<a href="{{ route('attendee_login') }}"> Click here</a></p>
        <button class="theme-btn btn primary-filled" type="submit">Login</button>
    </div>
    <div class="clearfix"></div>
</form>
@endsection

@section('extra')
    <a href="{{ route('password.request') }}">Forgot Password? Recover Now</a>
@endsection