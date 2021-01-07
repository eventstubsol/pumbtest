<div class="navbar-custom navs hidden theme-nav">
    <div class="container-fluid row">
        <div class="col-5 col-md-2 fluid-col logo-col">
            <div class="logo-box">
                <a class="logo area"  data-link="caucus-room">
                    <img src="{{ asset('/assets/images/logo-header.png') }}" style="max-height: 45px;border-radius: 10px;padding: 0px;">
                </a>
            </div>
        </div>
        <div class="col-2 col-md-8 fluid-col menu-col">
           
        </div>
        <div class="col-5 col-md-2 fluid-col profile-col">
            <div class="extra">
                <!-- <div class="dropdown notification-list topbar-dropdown">
                    <a class="dropdown-item notify-item" href="/faq">
                    <i class="fe-info mr-1"></i>
                    <span>FAQ</span>
                </a> -->
                @auth
                <div class="dropdown notification-list topbar-dropdown">
                    <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fe-log-out mr-1"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
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