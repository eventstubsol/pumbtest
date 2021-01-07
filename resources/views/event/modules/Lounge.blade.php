<div class="page" id="lounge-page">
    <div style="position: relative;">
        <div style="padding-bottom: 56.25%"></div>
        <img src="{{ assetUrl(getField("networking_lounge")) }}" class="positioned booth-bg" alt="" />
        @foreach(LOUNGE_AREAS as $area)
            <div
                    title="{{ $area['title'] }}"
                    class="positioned area"
                    data-link="{{ $area['link'] }}"
                    style="{{ areaStyles($area["area"]) }}"></div>
        @endforeach
        {!! getScavengerItems("lounge") !!}
    </div>
</div>