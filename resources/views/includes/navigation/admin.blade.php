<li class="menu-title">Administration</li>
<li>
    <a href="#users" data-toggle="collapse">
        <i data-feather="users"></i>
        <span> Users</span>
    </a>
    <div class="collapse" id="users">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("user.index") }}">Manage</a>
            </li>
            <li>
                <a href="{{ route("user.create") }}">Create</a>
            </li>
        </ul>
    </div>
</li>
<li>
    <a href="#notification" data-toggle="collapse">
        <i data-feather="bell"></i>
        <span> Notifications</span>
    </a>
    <div class="collapse" id="notification">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("notifications.list.get") }}">Manage</a>
            </li>
            <li>
                <a href="{{ route("notifications.create.get") }}">Create</a>
            </li>
        </ul>
    </div>
</li>

{{--<li>--}}
{{--    <a href="#polls" data-toggle="collapse">--}}
{{--        <i data-feather="bar-chart-2"></i>--}}
{{--        <span>Polls</span>--}}
{{--    </a>--}}
{{--    <div class="collapse" id="polls">--}}
{{--        <ul class="nav-second-level">--}}
{{--            <li>--}}
{{--                <a href="{{ route("poll.manage") }}">Manage</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route("poll.create.get") }}">Create</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}

<li>
    <a href="{{ route("eventSession.manage") }}">
        <i data-feather="calendar"></i>
        <span>Event Sessions</span>
    </a>
</li>


{{--<li>--}}
{{--    <a href="#sessions" data-toggle="collapse">--}}
{{--        <i data-feather="calendar"></i>--}}
{{--        <span>Event Sessions</span>--}}
{{--    </a>--}}
{{--    <div class="collapse" id="sessions">--}}
{{--        <ul class="nav-second-level">--}}
{{--            <li>--}}
{{--                <a href="{{ route("eventSession.manage") }}">Manage</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route("eventSession.dashboardArchive") }}">Polls Archive</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route("eventSession.videoArchive") }}">Past Videos Archive</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}


<li class="menu-title">Site Content</li>
<li>
    <a href="{{ route("options") }}">
        <i data-feather="file-text"></i>
        <span> General Content</span>
    </a>
</li>
<li>
    <a href="#faqs" data-toggle="collapse">
        <i data-feather="help-circle"></i>
        <span> FAQs</span>
    </a>
    <div class="collapse" id="faqs">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("faq.index") }}">Manage</a>
            </li>
            <li>
                <a href="{{ route("faq.create") }}">Create</a>
            </li>
        </ul>
    </div>
</li>

<li>
    <a href="#rooms" data-toggle="collapse">
        <i data-feather="map"></i>
        <span> Rooms </span>
    </a>
    <div class="collapse" id="rooms">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("room.index") }}">Manage</a>
            </li>
            <li>
                <a href="{{ route("room.create") }}">Create</a>
            </li>
            <li>
                <a href="{{ route("room.sort") }}">Sort</a>
            </li>
        </ul>
    </div>
</li>

<li>
    <a href="#booths" data-toggle="collapse">
        <i data-feather="grid"></i>
        <span> Booths </span>
    </a>
    <div class="collapse" id="booths">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("booth.index") }}">Manage</a>
            </li>
            <li>
                <a href="{{ route("booth.create") }}">Create</a>
            </li>
        </ul>
    </div>
</li>


<li>
    <a href="#report" data-toggle="collapse">
        <i class="mdi mdi-file-multiple"></i>
        <span> Reports </span>
    </a>
    <div class="collapse" id="report">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("reports.general") }}">General</a>
            </li>
            <li>
                <a href="{{ route("reports.leaderboard") }}">Leaderboard</a>
            </li>
            <li>
                <a href="{{ route("reports.auditorium") }}">Auditorium</a>
            </li>
        </ul>
    </div>
</li>

{{--<li>--}}
{{--    <a href="#report" data-toggle="collapse">--}}
{{--        <i class="mdi mdi-file-multiple"></i>--}}
{{--        <span> Reports </span>--}}
{{--    </a>--}}
{{--    <div class="collapse" id="report">--}}
{{--        <ul class="nav-second-level">--}}
{{--            <li>--}}
{{--                <a href="{{ route("report.index") }}">Manage</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route("report.create") }}">Create</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}

{{--<li>--}}
{{--    <a href="#provisional" data-toggle="collapse">--}}
{{--        <i class="mdi mdi-file-multiple"></i>--}}
{{--        <span> Provisional Groups </span>--}}
{{--    </a>--}}
{{--    <div class="collapse" id="provisional">--}}
{{--        <ul class="nav-second-level">--}}
{{--            <li>--}}
{{--                <a href="{{ route("provisional.index") }}">Manage</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route("provisional.create") }}">Create</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}

<li>
    <a href="#prizes" data-toggle="collapse">
        <i class="mdi mdi-gift-outline"></i>
        <span> Prizes </span>
    </a>
    <div class="collapse" id="prizes">
        <ul class="nav-second-level">
            <li>
                <a href="{{ route("prize.index") }}">Manage</a>
            </li>
            <li>
                <a href="{{ route("prize.create") }}">Create</a>
            </li>
        </ul>
    </div>
</li>
