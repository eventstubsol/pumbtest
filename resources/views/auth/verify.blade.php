@extends('layouts.auth')

@section('title')
    Verify Your Email Address
@endsection

@section('muted-text')
    Verify Your Email Address
@endsection

@section('form')
    <h3 class="mb-2">Verify Your Email Address</h3>
    <p>
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif
    </p>
    <p> {{ __('Before proceeding, please check your email for a verification link.') }} {{ __('If you did not receive the email request another by clicking below') }} </p>
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <div class="form-group input-group">
            <button type="submit" class="theme-btn btn primary-filled mb-1 mt-2">{{ __('Resend Request') }}</button>
        </div>
    </form>
    <form class="d-inline" id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <div class="input-group input-footer mb-2">
            <p class="text mb-0">Click here to <a style="color:#F44336" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></p>
        </div>
    </form>
@endsection
