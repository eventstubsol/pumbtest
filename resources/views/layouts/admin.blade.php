<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{assetUrl(getField("favicon"))}}">

@yield('styles')

<!-- App css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v=1234" type="text/css">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}" type="text/css">
    <style>

        .right-bar-toggle.chat-bubble{
            position: fixed;
            top: 85vh;
            right: 0;
            z-index: 9999;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #151515;
            transition: border 0.2s;
            border-right: none;
            border-radius: 5px 0 0 5px;
        }
        #chat-unread-count{
            transform: translateX(50%) translateY(-50%);
            position: absolute;
            top: 0;
            right: 0;
        }
        .right-bar-toggle.chat-bubble:hover{
            border-color: #3827c1;
        }
        .chat-loader{
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100vh;
            font-size: 50px;
            color: #3827c1;
        }
        .right-bar#chat-container,#chat-container .page-int-wrapper{
            width: 100%;
            max-width: 750px;
        }
        .right-bar#chat-container{
            right: 0;
            transform: translateX(100%);
        }
        .theme-chat.chat-bubble,.consent-notification{
            opacity: 1;
        }
        .theme-chat.right-bar#chat-container{
            width: 90% !important;
        }
        .cc1-chat-win-header{
            padding-right: 60px !important;
        }
        .hidden{
            display: none;
        }
        .logo-box{
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    @yield("styles_after")
</head>


<body class="loading" data-sidebar-showuser="true">

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            @auth
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light"
                           data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                             @if(isset(Auth::user()->profileImage))
                                <img src="{{assetUrl(Auth::user()->profileImage)}}" class="avatar-sm round-icon">
                            @else
                                <span class="round-icon">
                                    
                                        <i class="fa fa-user"></i>
                                </span>
                            @endif
                            <span class="pro-user-name ml-1">
                                    {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                                </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                             <a href="/event#profile" class="dropdown-item notify-item">
                            <i class="fe-user"></i> <span>My Account</span>
                        </a>
                             <a href="/event" class="dropdown-item notify-item">
                                <i class="fa fa-eye"></i> <span>Visit Event</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Settings</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a class="dropdown-item notify-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>

                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>
                    </li>
                </ul>
            @endauth

            @guest
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light"
                           href="{{ route("login") }}" aria-expanded="false">Login
                        </a>
                    </li>
                </ul>
            @endguest

            <!--̵ LOGO -->
            <div class="logo-box">
                <a href="{{ route("home") }}" class="logo logo-dark text-center">
                    <span class="logo-sm">
                        <img src="{{ assetUrl(getField('admin_logo')) }}" alt="..." height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ assetUrl(getField('admin_logo')) }}" alt="..." height="46">
                    </span>
                </a>

                <a href="{{ route("home") }}" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="{{ assetUrl(getField('admin_logo')) }}" alt="..." height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ assetUrl(getField('admin_logo')) }}" alt="..." height="46">
                    </span>
                </a>
            </div>

            @auth
                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>
            @endauth
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    @auth
        <div class="left-side-menu">

            <div class="h-100" data-simplebar>

                <!-- User box -->
                <div class="user-box text-center">
                    <img src="{{ assetUrl(Auth::user()->profileImage) }}" alt="user-img" title="Mat Helme"
                        class="rounded-circle avatar-md">
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                        data-toggle="dropdown">Geneva Kennedy</a>
                        <div class="dropdown-menu user-pro-dropdown">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user mr-1"></i>
                                <span>My Account</span>
                            </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-log-out mr-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                    <p class="text-muted">Admin Head</p>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul id="side-menu">
                        @yield('navigation')
                        @auth
                            @switch(Auth::user()->type)

                                @case("admin")
                                @include("includes.navigation.admin")
                                @break

                                @case("moderator")
                                @include("includes.navigation.moderator")
                                @break

                                @case("exhibiter")
                                @include("includes.navigation.exhibitor")
                                @break

                                @case("teller")
                                @include("includes.navigation.teller")
                                @break
                            @endswitch
                        @endauth

                    </ul>
                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
    @endauth
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                @auth
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                                        @yield("breadcrumbs")
                                    </ol>
                                </div>
                                <h4 class="page-title">@yield('page_title')</h4>
                            </div>
                        </div>
                    </div>
                @endauth
                <!-- end page title -->
                @yield('content')

            </div> <!-- container -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        {{ date("Y") }} - &copy; GEC Media
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<div id="chat-container" class="right-bar theme-chat"></div>
<a href="javascript:void(0);" id="chat-toggle" class="nav-link right-bar-toggle theme-chat chat-bubble">
    <i class="fe-message-square" />
    <span id="chat-unread-count" class="badge badge-danger font-15  badge-pill hidden" />
</a>
<div class="rightbar-overlay"></div>

<script>
    window.config = {
        ...(window.config || {}),
        cometChat: {
            appID: "{{ env("COMET_CHAT_APP_ID") }}",
            region: "{{ env("COMET_CHAT_REGION") }}",
            authKey: "{{ env("COMET_CHAT_AUTH_KEY") }}",
            supportChatUser: "{{ SUPPORT_USER }}",
        },
        userId: "{{ Auth::user()->id }}",
        userName: "{{ Auth::user()->name }}",
    };
</script>
<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>


<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset("/js/chat/app.js") }}"></script>

<script type="text/javascript">
  function confirmDelete(message = false, title = false, options = {}){
    if(!message){
      message = "Are you sure you want to proceed?";
    }
    return new Promise((resolve) => {
        Swal.fire({
            title: title || "Confirm",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            ...options,
        }).then((result) => resolve(result.value));
    });
  }
  function showMessage(title, type = "info", options = {}){
      Swal({
          type,
          title,
          ...options
      });
  }
  // An Example for usage
  // confirmDelete("Are you sure you want to delete the booth", "Confirm booth deletion!").then(confirmation => {
  //   if(confirmation){
  //     //Proceed with deletion
  //   }
  // })
</script>
@yield('scripts')


</body>
</html>
