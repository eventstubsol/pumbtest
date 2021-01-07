@extends('layouts.auth')

@section('title')
    Enter New Password
@endsection

@section('muted-text')
    Choose your new password
@endsection

@section('form')
<form action="{{ route('password.email') }}" method="post">
    @csrf

    <div class="form-group mb-3">
        <label for="emailaddress">Email address</label>
        <input class="form-control @error('email') is-invalid @enderror" required type="email" id="emailaddress" value="{{ old('email') }}" name="email" placeholder="Enter your email" />
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="password">Enter New Password</label>
        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required placeholder="Enter new password" />
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="password-confirm">Confirm Password</label>
        <input class="form-control" type="password" id="password-confirm" name="password_confirmation" required placeholder="Confirm new password" />
    </div>

    <div class="form-group mb-0 text-center pt-3">
        <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
    </div>
    <div class="clearfix"></div>
</form>
@endsection

@section('name')
    
@endsection

@section('footer-route')
    {{ route('login') }}
@endsection

@section('footer-text')
    Back to <strong class="text-white">Login</strong>
@endsection