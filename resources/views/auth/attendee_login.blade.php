@extends('layouts.auth')

@section('title')
Event Login
@endsection

@section('title-text')
Hello there!
@endsection

@section('subtitle-text')
{{ $login["text"] }}
@endsection

@section('scripts_before')
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
@endsection

@section('form')
@php
$email = "";
if(Auth::user()){
    $email = Auth::user()->email;
}
@endphp
<form id="form" action="{{ route('attendee_login') }}" method="post">
    @csrf
    <div class="input-group">
        <label for="{{ $login["field"] }}">{{ $login["label"] }}</label>
        <input value="{{ old($login["field"]) ?? $email }}" class="form-control @error($login["field"]) is-invalid @enderror"
            type="{{ $login["field"] == 'email' ? 'email' : 'text' }}" id="" name="{{ $login["field"] }}"
            placeholder="{{ $login["label"] }}" />
        @error($login["field"])
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        @if ($notFound)
        <span class="invalid-feedback" role="alert">Please check your login details</span>
        @endif
        @if ($captchaError)
        <span class="invalid-feedback" role="alert">Unable to verify captcha</span>
        @endif
    </div>

    <div class="input-group">
        <input type="hidden" id="token" name="token">
    </div>

    <div class="input-group input-footer">
        <p class="text">Admin Use Only<a href="{{ route('login') }}"> Click here</a></p>
        <button class="theme-btn btn primary-filled" onclick="onSubmit">Login</button>
    </div>
    <div class="clearfix"></div>
</form>
@endsection

@section('scripts_after')
<script>
    (function onSubmit() {
        grecaptcha.ready(function () {
            grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', {
                action: 'homepage'
            }).then(function (token) {
                document.querySelector("#token").value = token
            });
        });
    })()
</script>
@endsection