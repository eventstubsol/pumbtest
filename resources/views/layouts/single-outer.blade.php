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
        <div class="col-9 col-md-9 fluid-col logo-col">
            <div class="logo-box">
                <a class="logo area"  data-link="caucus-room">
                    <img src="{{ asset('/assets/images/logo-header.png') }}">
                </a>
            </div>
        </div>
        <div class="col-3 col-md-3 fluid-col profile-col">
            <div class="extra">
                @auth
                    <div class="custom-dropdown profile">
                        <a href="javascript:void(0);" class="menu-trigger">
                            <p class="pro-user-name m-0">
                                <span>{{ Auth::user()->name }}</span><i class="mdi mdi-chevron-down mx-1"></i>
                            </p>
                            @if(isset(Auth::user()->profileImage))
                                <img src="{{assetUrl(Auth::user()->profileImage)}}" class="avatar-sm round-icon">
                            @else
                                <span class="round-icon"><i class="fa fa-user"></i></span><i class="mdi mdi-chevron-down mx-1"></i>
                            @endif
                        </a>
                        <div class="custom-dropdown-menu">
                            @if(Auth::user()->type=="admin" || Auth::user()->type=="exhibiter")
                                <a href="{{ url("/") }}" class="dropdown-item notify-item">
                                    <i class="fa fa-cog mr-1"></i> <span>Admin Panel</span>
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>

                            <a data-link="caucus-room" class="dropdown-item notify-item area">
                                <i class="fe-home mr-1"></i> <span>Caucus Room</span>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fe-log-out mr-1"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endauth
                @guest
                    <div class="dropdown notification-list topbar-dropdown">
                        <a class="" href="{{ route("login") }}" aria-expanded="false">Login</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
<!-- end Topbar -->
@yield("content")
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>
</html>
