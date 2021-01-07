<!-- Resources -->
<div class="modal fade theme-modal" id="resources-modal" tabindex="-1" role="dialog" aria-labelledby="resourceslistLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="resourceslistLabel"><span class="image-icon resources"></span> Resources</h4>
                <div class="form-group filters search-box">
                    <label class="search has-icon search" for="resourcesearch">
                        <input type="text" placeholder="Search items ..." name="resourcessearch" id="resourcesearch" data-action="resourcesearch">
                    </label>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            </div>
            <div class="modal-body ">
                <div class="doc-lists resources-list" data-simplebar data-simplebar-auto-hide="false">
                    @foreach($booths as $booth)
                        @foreach($booth->resources as $resource)
                            <div class="doc-item row justify-content-between align-items-center resource r-{{$resource->id}} resource-{{$booth->id}}">
                                <div class="d-inline-flex align-items-center flex-grow-1">
                                    <div class="doc-title flex-grow-1"><span class="image-icon pdf"></span><h4 class="searchresource">{{ $booth->name }} - {{$resource->title}}</h4></div>
                                </div>
                                <div class="d-inline-flex">
                                    <a class="btn theme-btn primary  mr-2 _df_button" title="{{$resource->title}}" source="{{assetUrl($resource->url)}}">View</a>
                                    <button class="btn primary-filled theme-btn text-white add-to-bag add" data-resource="{{ $resource->id }}" type="button" name="button"> + Swagbag</button>
                                    <button class="btn danger theme-btn has-icon delete add-to-bag remove hidden" data-resource="{{ $resource->id }}" type="button" name="button"> Swagbag</button>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Resources -->
