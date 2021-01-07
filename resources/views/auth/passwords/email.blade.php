@extends('layouts.auth')

@section('title')
    Reset Password
@endsection

@section('title-text')
    Password Reset
@endsection


@section('subtitle-text')
    Enter your email address and we'll send you an email with instructions to reset your password.
@endsection

@section('form')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('password.email') }}" method="post">
    @csrf

    <div class="input-group">
        <label for="emailaddress">Email address</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" id="emailaddress" name="email" placeholder="Enter your email" />
        @error('email')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="input-group input-footer">
        <div class="text">
            Back to Login?<a href="{{ route('login') }}"> Click here</a>
        </div>
        <button class="theme-btn btn primary-filled" type="submit">Reset Password</button>
    </div>
</form>
@endsection