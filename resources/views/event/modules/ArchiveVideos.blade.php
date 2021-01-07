<div class="page has-padding padding-large" id="sessions-archive">
    <div class="row">
        <div class="col-11 col-lg-9 mx-auto">
            <h2 class="mb-3">Past Session Videos</h2>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3" id="accordion">
                        <div class="doc-lists swagbag-list" id="archive-videos-list" data-simplebar
                             data-simplebar-auto-hide="false">
                            @foreach(getPastSessionVideos() as $id => $video)
                                <div class="doc-item row justify-content-between align-items-center resource r-6de9d8a6-5c0f-43d0-b9a9-98951948a24c">
                                    <div class="d-inline-flex flex-grow-1 align-items-center">
                                        <div class="doc-title flex-grow-1">
                                            <h4>{{ $video->title }}</h4>
                                        </div>
                                    </div>
                                    <div class="d-inline-flex actions">
                                        <a class="btn theme-btn primary video-play" href="https://vimeo.com/{{ $video->video_id }}">View
                                            Now</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div> <!-- end #accordions-->
                </div> <!-- end col -->
            </div>
        </div>
    </div>
</div>