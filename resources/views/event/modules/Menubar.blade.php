<div class="menu-custom navs hidden theme-nav">
    <div class="container-fluid row">
        <ul class="menu">
            <li class="custom-dropdown not-booth-menu">
                <a class="area" data-link="auditorium">
                    <i class="menu-icon live"></i>
                    Live now
                </a>
{{--                <div class="custom-dropdown-menu">--}}
{{--                    <a href="javascript:void(0);" class="area dropdown-item" data-link="auditorium">Auditorium</a>--}}
{{--                    <a href="javascript:void(0);" class="area dropdown-item" data-link="workshop">Workshop</a>--}}
{{--                    @if(isOpenForPublic("caucus"))--}}
{{--                        <a href="javascript:void(0);" class="area dropdown-item" data-link="past-videos">Past Videos</a>--}}
{{--                    @endif--}}
{{--                </div>--}}
            </li>
            <li class="custom-dropdown not-booth-menu">
                <a class="area" data-link="celebrations">
                    <i class="menu-icon live"></i>
                    Celebrations
                </a>
            </li>
            <li class="custom-dropdown not-booth-menu">
                <a  class="area" data-link="room/ca9d92bd-e5a1-4392-9659-b65d9c857310">
                    <i class="menu-icon expo"></i>
                    Expo Hall
                </a>
                <!-- <div class="custom-dropdown-menu">
                    @foreach(EXPO_HALL_ROOMS as $id)
                        <a class="area dropdown-item" data-link="room/{{ $id[0] }}">{{ $id[1] }}</a>
                    @endforeach
                </div> -->
            </li>
            <li class="not-booth-menu">
                @if(isOpenForPublic("lounge"))
                    <a href="javascript:void(0);" class="area" data-link="lounge">
                        <i class="menu-icon lounge"></i>
                        Lounge
                    </a>
                @else
                    <a href="javascript:void(0);" class="area" disabled>
                        <i class="menu-icon lounge"></i>
                        Lounge
                    </a>
                @endif
            </li>
{{--            <li class="not-booth-menu">--}}
{{--                <a href="javascript:void(0);" class="area" data-link="attendees">--}}
{{--                    <i class="menu-icon delegates"></i>--}}
{{--                    Attendees--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="hidden" id="notbooth_menu_toggle" >
                <a href="javascript:void(0);" style="font-size: 22px">
                    <i class="mdi mdi-chevron-left-circle"></i>
                </a>
            </li>
            <li class="booth-menu hidden">
                <a href="javascript:void(0);" data-modal="description-modal-" class="modal-toggle booth_description">
                    <i class="mdi mdi-note-text" style="font-size: 22px;"></i>
                    Description
                </a>
            </li>
            <li class="booth-menu hidden">
                <a href="javascript:void(0);" data-modal="videolist-modal-" class="modal-toggle booth_videos">
                    <i class="mdi mdi-play" style="font-size: 22px;"></i>
                    Videos
                </a>
            </li>
            <li class="booth-menu hidden">
                <a href="javascript:void(0);" data-modal="resourcelist-modal-" class="modal-toggle booth_resources">
                    <i class="mdi mdi-file-pdf" style="font-size: 22px;"></i>
                    Resources
                </a>
            </li>
            <li class="booth-menu hidden">
                <a href="javascript:void(0);" class="show-interest">
                    <i class="mdi mdi-file-pdf" style="font-size: 22px;"></i>
                    Show Interest
                </a>
            </li>
            <li class="booth-menu hidden">
                <a href="javascript:void(0);"  data-modal="book-a-call-modal-" class="modal-toggle booth_call_booking">
                    <i class="mdi mdi-calendar" style="font-size: 22px;"></i>
                    Book a Call
                </a>
            </li>
            @foreach($booths as $booth)
                @if($booth->type == "candidate_standard")
                    @foreach($booth->resources as $resource)
                        <li class="hidden candidatemenus resourcelist-{{$booth->id}}">

                            <a class="mr-2 _df_button" style="border: none; background: none;"
                               href="{{ assetUrl($resource->url) }}" title="{{$resource->title}}"
                               source="{{ assetUrl($resource->url)}}" > <i class="mdi mdi-file-pdf" style="font-size: 22px;"></i> {{$resource->title}}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>
</div>
<!-- end Topbar -->