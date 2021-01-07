@php
    $user = Auth::user();
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ getField("title", "Event") }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
    <link href={{ asset("assets/libs/select2/css/select2.min.css" )}} rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset("event-assets/YouTubePopUp/YouTubePopUp.css")}}">
{{--    App favicon--}}
    <link rel="shortcut icon" href="{{assetUrl(getField("favicon"))}}">
    <!-- Icons -->
    <link href={{asset("assets/css/icons.min.css")}} rel="stylesheet" type="text/css" />
    <script>
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        if (msie > 0) // If Internet Explorer, return version number
        {
            alert("For an immersive experience on our platform please use some modern browser like Chrome, Safari or Firefox.");
        }
    </script>
    <!-- Onesignal -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset("event-assets/css/app.css") }}">
    <link href={{asset("assets/css/custom.css")}} rel="stylesheet" type="text/css" />
    <style>
        #faq{
            display: block;
        }
    </style>
</head>
<body>
<div class="navbar-custom navs theme-nav">
    <div class="container-fluid row">
        <div class="col-md-12">
            <a href="{{ route("attendee_login") }}" class="btn btn-block">Login</a>
            <a href="{{ route("attendee_register") }}" class="btn btn-block">Register</a>
        </div>
    </div>
</div>
</body>
</html>
