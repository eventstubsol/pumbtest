<div class="navbar-custom navs hidden theme-nav">
    <div class="container-fluid row">
        <div class="col-5 col-md-2 fluid-col logo-col">
            <div class="logo-box">
                <a class="logo area"  data-link="lobby">
                    <img src="{{ asset('images/logo-header.png') }}" style="max-height: 45px;border-radius: 10px;padding: 0px;">
                </a>
            </div>
        </div>
        <div class="col-2 col-md-8 fluid-col menu-col">
           <ul class="menu">
                <li><a data-link="lobby" class="area"><i class="fe-home"></i>Lobby</a></li>
                <li><a data-link="infodesk" class="area"><i class="fe-info"></i>Information</a></li>
               @if(isOpenForPublic("swagbag"))
                   <li><a data-toggle="modal" data-target="#resources-modal"><i class="fe-folder"></i>Library</a></li>
               @else
                   <li><a disabled><i class="fe-folder"></i>Library</a></li>
               @endif
               <li><a data-toggle="modal" data-target="#schedule-modal"><i class="fe-calendar"></i>Schedule</a></li>
               @if(isOpenForPublic("swagbag"))
                   <li><a data-toggle="modal" data-target="#swagbag-modal"><i class="fe-shopping-bag"></i>Swag Bag</a></li>
               @else
                   <li><a data-toggle="modal" disabled><i class="fe-shopping-bag"></i>Swag Bag</a></li>
               @endif
               @if(isOpenForPublic("leaderboard"))
                   <li><a class="area" data-link="leaderboard"><i class="fe-bar-chart"></i>Leaderboard</a></li>
               @else
                   <li><a class="area" disabled><i class="fe-bar-chart"></i>Leaderboard</a></li>
               @endif
               <li><a href="#by-laws" id="by-laws"><i class="fe-book-open"></i>Survey</a></li>
           </ul>
        </div>
        <div class="col-5 col-md-2 fluid-col profile-col">
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
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fe-log-out mr-1"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <div class="mob-menu ml-2 d-none">
                    <a href="void:javascript(0);">
                        <span class="round-icon">
                            <i class="fa fa-bars"></i>
                        </span>
                    </a >
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