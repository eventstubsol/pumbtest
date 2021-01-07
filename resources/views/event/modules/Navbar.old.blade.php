<div class="navbar-custom">
    <div class="container-fluid">
        @auth
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li>
                    <a href="javascript:void(0);" class="nav-link waves-effect waves-light" data-toggle="modal" data-target="#resources-modal">Resources</a>
                </li>
                <li>
                    <a class="nav-link waves-effect waves-light area" data-link="report">Reports</a>
                </li>
                <li>
                    <a class="nav-link waves-effect waves-light area" data-link="faq">FAQ's</a>
                </li>
                <li>
                    <a class="nav-link waves-effect waves-light area" data-link="provisional">Provisional Groups</a>
                </li>
                <li>
                    <a class="nav-link waves-effect waves-light area" data-link="lounge">Lounge</a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="nav-link waves-effect waves-light" data-toggle="modal" data-target="#swagbag-modal">SwagBag</a>
                </li>
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"
                       role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-bell noti-icon"></i>
                        <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                    <span class="float-right">
                                        <a href="" class="text-dark">
                                            <small>Clear All</small>
                                        </a>
                                    </span>Notification
                            </h5>
                        </div>

                        <div class="noti-scroll" data-simplebar>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                <div class="notify-icon">
                                    <img src="../assets/images/users/user-1.jpg" class="img-fluid rounded-circle"
                                         alt=""/></div>
                                <p class="notify-details">Cristina Pride</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Hi, How are you? What about our next meeting</small>
                                </p>
                            </a>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);"
                           class="dropdown-item text-center text-primary notify-item notify-all">
                            View all
                            <i class="fe-arrow-right"></i>
                        </a>
                    </div>
                </li>
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light"
                       data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="../assets/images/users/user-1.jpg" alt="avatar" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                                {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                            </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome ! {{ Auth::user()->name }}</h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>My Account</span>
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
            <a class="logo logo-dark text-center area" data-link="lobby">
                        <span class="logo-sm">
                            <img src="../assets/images/logo-sm.png" alt="" height="22">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                <span class="logo-lg">
                            <img src="../assets/images/logo-dark.png" alt="" height="20">
                    <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
            </a>

            <a class="logo logo-light text-center area"  data-link="lobby">
                        <span class="logo-sm">
                            <img src="../assets/images/logo-sm.png" alt="" height="22">
                        </span>
                <span class="logo-lg">
                            <img src="../assets/images/logo-light.png" alt="" height="20">
                        </span>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->