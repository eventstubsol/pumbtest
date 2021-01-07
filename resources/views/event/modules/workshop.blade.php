<div class="page" id="workshop-room">
    <div class="position-relative">
        <div style="padding-bottom: {{ AUDI_IMAGE_ASPECT }}%"></div>
        <img src="{{ assetUrl(getField("celebration")) }}" class="positioned fill" alt="">
        <div class="positioned" id="play-workshop-btn" style="{{ areaStyles(CAUCUS_SCREEN_AREA) }};display:flex;align-items: center; justify-content: center;background: #fff;cursor: pointer;">
            @include("event.modules.clickToJoin")
        </div>
    </div>
</div>
<div class="modal fade embed-modal" id="workshop-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="modal-body">
                <div class="position-relative">
                    <div style="padding-bottom: {{ AUDI_IMAGE_ASPECT }}%"></div>
                    <div id="workshop-content" class="positioned fill" ></div>
                </div>
            </div>
        </div>
    </div>
</div>
