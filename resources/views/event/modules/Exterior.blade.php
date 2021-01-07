<div class="page initial" id="home">
    <div class="filler" style="padding-bottom: {{ EXTERNAL_VIDEO_ASSETS_ASPECT }}%"></div>
{{--    <div class="video-containers positioned">--}}
{{--        <video class="full-width-videos" src="{{ assetUrl(getField("entering_video")) }}" id="entering_view" autoplay muted ></video>--}}
{{--    </div>--}}
    <div class="video-containers positioned">
        <video class="full-width-videos" src="{{ assetUrl(getField("external_video")) }}" id="exterior_view" autoplay muted ></video>
{{--        <video class="full-width-videos" src="{{ assetUrl("uploads/Dome%20Exterior%20Fixed.mp4") }}" id="exterior_view" autoplay muted loop ></video>--}}
    </div>
</div>