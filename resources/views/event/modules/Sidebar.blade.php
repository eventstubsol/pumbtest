<div class="sidebar-custom navs hidden theme-nav">
    <div class="scroller" data-simplebar>
        <ul class="menu">
            <li>
                <a href="#" class="area" data-link="lobby" ><i class="icon live"></i>Live Now</a>
                <ul>
                    <li><a href="javascript:void(0);" class="area dropdown-item" data-link="workshop"><i class="fe-corner-down-right mr-2"></i>Workshop</a></li>
                    <li><a href="javascript:void(0);" class="area dropdown-item" data-link="auditorium"><i class="fe-corner-down-right mr-2"></i>Auditorium</a></li>
                    <li><a href="javascript:void(0);" class="area dropdown-item" data-link="caucus-room"><i class="fe-corner-down-right mr-2"></i>Caucus</a></li>
                    <li><a href="javascript:void(0);" class="area dropdown-item" data-link="past-videos"><i class="fe-corner-down-right mr-2"></i>Past Videos</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="area"  data-link="caucus-room not-booth-menu"><i class="icon caucus"></i>Caucus</a>
            </li>
            <li>
                <a class="area" data-link="expo-hall">
                    <i class="icon expo"></i>
                    Expo Hall
                </a>
                <ul>
                    @foreach(EXPO_HALL_ROOMS as $id)
                    <li><a class="area dropdown-item" data-link="room/{{ $id[0] }}"><i class="fe-corner-down-right mr-2"></i>{{ $id[1] }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="#" class="area"  data-link="caucus-room"><i class="icon candidates"></i>Candidates</a>
            </li>
            <li>
                <a href="#" class="area"  data-link="lounge"><i class="icon lounge"></i>Lounge</a>
            </li>
            <li>
                <a href="#" class="area"  data-link="delegates-status"><i class="icon delegates"></i>Delegates</a>
            </li>
        </ul>
    </div>
</div>
<!-- end Topbar -->