@if(isOpenForPublic("booths"))
@foreach($booths as $booth)
    <div class="page  booth" data-name="{{ $booth->name }}" id="booth-{{ $booth->id }}">
        <img src="{{ asset("images/BG.jpg") }}" class="positioned booth-bg" alt="">
        <div class="position-relative">
            <div style="padding-bottom: {{ BOOTH_AREA_IMAGE_ASPECT }}%"></div>
            @if(strlen($booth->boothurl)>1)
                <img src="{{ assetUrl($booth->boothurl) }}" class="positioned booth-bg" alt="">
            @else
                <img src="{{ assetUrl(getField($booth->type)) }}" class="positioned booth-bg" alt="">
            @endif

{{--            @if($booth->type == "sponsor_standard")--}}
{{--                <img src="{{ assetUrl('uploads/tXkXLfWEr7LTb0I66WZqH2aZv0QEtrxBLiq2tehd.png') }}" class="positioned booth-bg" style="z-index: 4" alt="">--}}
{{--            @endif--}}
            @if($booth->type == "national_partners")
                <img src="{{ assetUrl('uploads/et9D9LTQDYvysv3EfTUkxMGQuvufLjzUC5tPQ3vy.png') }}" class="positioned booth-bg" style="z-index: 4" alt="">
            @endif
            @php
            $assetDetails = [];
            $corousel = [];
            $link = "";
            if(is_iterable($booth->images)){
                foreach ($booth->images as $image){
                    if($image->title=="corousel"){
                        array_push($corousel,$image->url);
                        $link = $image->link;
                    }else{
                        $assetDetails[$image->title] = [
                            "url" => $image->url,
                            "link" => $image->link,
                            "type" => "image"
                        ];
                    }
                }
                $assetDetails["corousel"] = [
                    "url" =>$corousel,
                    "link"=> $link ?? '',
                    "type"=>"corousel",
                ];
            }
            if(is_iterable($booth->videos)){
                foreach ($booth->videos as $video){
                    if($video->title == "brandvideo"){
                    $assetDetails[$video->title] = [
                        "url" => $video->url,
                        "thumbnail" => $video->thumbnail,
                        "type" => "video"
                    ];
                    }
                }
            }

            @endphp
            @if(isset(BOOTH_IMAGE_AREAS[$booth->type]))
            @foreach(BOOTH_IMAGE_AREAS[$booth->type]['assets'] as $slot => $asset)
                @if($asset['type'] === "link")
                    <a href="{{ $asset['to'] }}" target="_blank" class="positioned"
                       style="{{ areaStyles($asset['area'])}};"> </a>
                @endif
            @endforeach
            @endif
            @if(isset(BOOTH_IMAGE_AREAS[$booth->type]))
                @foreach(BOOTH_IMAGE_AREAS[$booth->type]['assets'] as $slot => $asset)
{{--                    @if($booth->type === "sponsor_standard" && $asset["type"] =="image")--}}
{{--                        @continue--}}
{{--                    @endif--}}
                    @php
                        $value = "";
                        $link = "";
                        $class = "";
                        if(isset($assetDetails[$slot])){
                            $value = $assetDetails[$slot]['url'];
                            if(isset($assetDetails[$slot]['link'])){
                                $link = $assetDetails[$slot]['link'];
                            }
                            if($assetDetails[$slot]["type"]=="video"){
                                $value = $assetDetails[$slot]['thumbnail'];
                                $link =  $assetDetails[$slot]['url'];
                            }
                            if(isset($asset["class"])){
                                $class = $asset['class'];
                            }
                        }
                        if($booth->id === "833ae5a1-8bac-496b-85f8-1256d22a93da"){
                            $asset["area"] = [45,46.55,5.85,5.5];
                        }
                        if(!$value || strlen($value) === 0){
                            continue;
                        }
                    @endphp
                    @if($link)
                    <a href="{{ $link }}" target="_blank"
                    class="positioned @if($asset['type']=='video') video-play   @endif"
                    style="{{ areaStyles($asset['area'])}}; @if($asset['type']== 'image') z-index:3; @endif  @if(isset($asset['classes']) && $asset['classes']=="above_object"  ) z-index:5;  @endif     ">
                    @else
                        <div
                                class="positioned abcd {{$link}} @if($asset['type']=='video') video-play   @endif"
                                style="{{ areaStyles($asset['area'])}}; @if($asset['type']== 'image') z-index:3; @endif   @if(isset($asset['classes']) && $asset['classes']=="above_object")  z-index:5;  @endif"
                        >
                    @endif
                        @if($asset["type"] =="image")
                            @if(strlen($value) > 0)
                                    @if(false)
                                        <img async class="booth-image positioned  {{ $class }}"   src="{{ assetUrl($value) }}" />
                                    @endif
                            @endif
                        @elseif($asset["type"] == "video")
                                    <div class="d-flex h-100">
                                     <i class="mdi mdi-play-circle" style="z-index: 2;font-size: 2vw; margin: auto;"></i>
                                    <img async class="booth-image positioned" src="{{ assetUrl($value) }}" />
                                    </div>
                        @elseif($asset["type"] == "link")
                        @else
                            <div class="carousel slide h-100" data-ride="carousel" data-interval="3000" data-pause="false">
                                <div class="carousel-inner h-100" >
                                    @foreach($value as $id=>$cimage)
                                <div class="carousel-item h-100
                                @if($id==0)
                                                active
                                @endif">
                                            <img class="d-block img-fluid h-100 w-100" style="object-fit:cover;" src="{{assetUrl($cimage)}}" alt="First slide">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @if($link)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
{{--        <div class="container-fluid mt-3">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <div class="float-right d-none d-md-inline-block">--}}
{{--                                    <button class="btn theme-btn primary area text-center" data-link="room-1">Back to Room</button>--}}
{{--                                <div class="btn-group mb-2" style="font-size: 3rem">--}}
{{--                                    <a  data-toggle="modal" data-target="#description-modal-{{$booth->id}}"><i class="mdi mdi-book-information-variant"></i></a>--}}
{{--                                     <a  data-toggle="modal" data-target="#videolist-modal-{{$booth->id}}" ><i class="mdi mdi-play-circle"></i></a>--}}
{{--                             <a  data-toggle="modal" data-target="#resourcelist-modal-{{$booth->id}}" ><i class="mdi mdi-file"></i></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2>--}}
{{--                                {{ $booth->name }}--}}
{{--                            </h2>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
        <div class="modal fade" id="videolist-modal-{{$booth->id}}" tabindex="-1" role="dialog"aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Videos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               @if(count($booth->videos))
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-right">Link</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($booth->videos as $video)
                            @if($video->title != "brandvideo")
                                <tr>
                                <td>{{ $video->title }}</td>
                                <td class="text-right">
                                    <a class="btn theme-btn primary video-play" href="{{ $video->url }}" >View Now</a>
                                </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="description-modal-{{$booth->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Description</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="tab-pane show active">
                    <div id="description-{{ $booth->id }}"></div>
                    @if(strlen($booth->url)>1)
                        <p>Website: <a target="_blank" href="{{ $booth->url  }}">{{ $booth->url }}</a></p>
                    @endif
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="resourcelist-modal-{{$booth->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Resources</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            @if(count($booth->resources))
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-right">Link</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($booth->resources as $resource)
                        <tr>
                            <td>{{ $resource->title }}</td>
                            <td class="text-right resource  r-{{$resource->id}} ">
                                <a class="btn theme-btn plain  mr-2 _df_button theme-btn primary" href="{{ assetUrl($resource->url) }}" title="{{$resource->title}}" source="{{ assetUrl($resource->url)}}" >View Now</a>
                                <button class="btn theme-btn primary add-to-bag add" data-resource="{{ $resource->id }}" type="button" name="button"> + swagbag</button>
                                <button class="btn btn-danger add-to-bag remove hidden" data-resource="{{ $resource->id }}" type="button" name="button"> - swagbag</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    @if($booth->calendly_link)
<div class="modal fade book-a-call-modal" id="book-a-call-modal-{{$booth->id}}" data-name="{{ $booth->name }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="calendly-inline-widget" data-auto-load="false" style="min-width:320px;height:80vh;">
                    <script>
                        Calendly.initInlineWidget({
                            url: '{{ $booth->calendly_link }}?hide_landing_page_details=1',
                            prefill: {
                                name: "{{ $user->name }}",
                                email: "{{ $user->email }}",
                            }
                        });
                    </script>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    @endif
@endforeach
@endif