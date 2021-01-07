<div class="page" id="lobby">
    <div class="video-container positioned">
        <video class="full-width-videos" src="{{ assetUrl(getField("main_lobby_video")) }}" id="lobby_view" autoplay muted loop></video>
{{--        <video class="full-width-videos" src="{{ assetUrl("uploads/lobby-1_VYyDUpWH.mp4") }}" id="lobby_view" autoplay muted loop></video>--}}
        @foreach(LOBBY_AREAS as $area)
            @php
                $class = "";
                if(isset($area['class'])){
                    $class = $area['class'];
                }
            @endphp
            <div
                    title="{{ $area['title'] }}"
                    @if(isset($area['link']))
                    class="positioned area {{ $class }}"
                    data-link="{{ $area['link'] }}"
                    @else
                    class="positioned {{ $class }}"
                    @endif
                    style="{{ areaStyles($area["area"]) }}">
                @if(isset($area["videoEmbed"]))
                    <a class="video-play positioned fill" href="{{ $area["videoEmbed"] }}" >
                        <div class="d-flex  positioned h-100 w-100">
                            <i class="mdi mdi-play-circle" style="z-index: 2;font-size: 2vw; margin: auto;"></i>
                        </div>
                    </a>
                @endif
            </div>
        @endforeach
        {!! getScavengerItems("lobby") !!}
    </div>
</div>