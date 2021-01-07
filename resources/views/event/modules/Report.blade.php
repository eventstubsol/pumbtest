<div class="page row has-padding padding-large" id="reports">
    <div class="col-11 col-lg-9 mx-auto">
        <h2>Reports</h2>

        @foreach($reports as $report)
                <div class="card-header d-flex justify-content-between">
                    <h5 class="ribbon-title">{{$report->title}}</h5>
                    <div class="text-blue float-right r-{{$report->id}} resource">
                        @if(isset($report->resources) && count($report->resources))
                            <a class="btn primary theme-btn  _df_button mr-2" title="{{$report->resources[0]->title}}" source="{{assetUrl($report->resources[0]->url)}}" type="button" name="button">PDF 1</a>
                           @if(count($report->resources) > 1)
                                <a class="btn primary theme-btn  _df_button mr-2" title="{{$report->resources[1]->title}}" source="{{assetUrl($report->resources[1]->url)}}" type="button" name="button">PDF 2</a>
                            @endif
                        @endif
                        @if(isset($report->video) && isset($report->video->title))
                            <a class="btn primary theme-btn  video-play mr-2" title="{{$report->video->title}}" href="{{$report->video->url}}" type="button" name="button">Play Video</a>
                        @endif
                        <button class="btn primary-filled theme-btn text-white add-to-bag add" data-resource="{{ $report->id }}" type="button" name="button"> + Swagbag</button>
                        <button class="btn danger theme-btn has-icon delete add-to-bag remove hidden" data-resource="{{ $report->id }}" type="button" name="button"> Swagbag</button>
                    </div>
                </div>
        @endforeach
    </div>
</div>