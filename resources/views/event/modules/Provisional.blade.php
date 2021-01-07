<div class="page row has-padding padding-large" id="provisionals">
    <div class="col-11 col-lg-9 mx-auto">
        <h2 class="w-full mb-4">Provisional Groups</h2>
        @foreach($provisionals as $provisional)
        @if(isset($provisional->resource))
            <div class="card provisionals">
                <div class="card-header d-flex justify-content-between ">
                    <h5 class="text-dark ribbon-title d-inline float-left">
                        {{$provisional->title}}
                    </h5>
                    <div class="text-blue float-right r-{{$provisional->id}} resource no-filter d-inline">
                        <a class="btn primary theme-btn video-play mr-2" href="{{ $provisional->video->url }}" >Play Video</a>
                        <a class="btn primary theme-btn mr-2  _df_button" title="{{$provisional->resource[0]->title}}" source="{{assetUrl($provisional->resource[0]->url)}}" type="button" name="button">View PDF</a>
                        <a class="btn primary theme-btn mr-2  _df_button" title="{{$provisional->resource[1]->title}}" source="{{assetUrl($provisional->resource[1]->url)}}" type="button" name="button">View PDF</a>
                        <button class="btn primary theme-btn add-to-bag add" data-resource="{{ $provisional->id }}" type="button" name="button"> + Swagbag</button>
                        <button class="btn danger theme-btn has-icon remove add-to-bag remove hidden delete" data-resource="{{ $provisional->id }}" type="button" name="button"> Swagbag</button>
                    </div>                    
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>