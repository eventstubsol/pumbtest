@extends("layouts.admin")

@section("page_title")
    Edit Booth: {{ $booth->name }}
@endsection

@section("title")
    Edit Booth: {{ $booth->name }}
@endsection

@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
    <link rel="stylesheet" href="{{ asset("event-assets/css/app.css") }}">
    <style>
        .positioned .dropify-wrapper {
            height: 100%;
        }
    </style>
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="/">Booths</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
    @php
        $assetDetails = [];
        $corousel = [];
        $link = "";
        if(is_iterable($booth->images) && isset($booth->images[0])){
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
            if(isset($link)){
            $assetDetails["corousel"] = [
            "url" =>$corousel,
            "link"=> $link,
            "type"=>"corousel",
            ];
        }
        }
        if(is_iterable($booth->videos) && isset($booth->videos[0])){

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

    <form action="{{ route("exhibiter.update", [ "booth" => $booth->id ]) }}" method="POST">
        @csrf
        <div class="position-relative">
            <div style="padding-bottom: {{ BOOTH_AREA_IMAGE_ASPECT }}%"></div>
            <img src="{{ assetUrl(getField($booth->type)) }}" class="positioned booth-bg" alt="">

            @if(isset(BOOTH_IMAGE_AREAS[$booth->type]))
                @foreach(BOOTH_IMAGE_AREAS[$booth->type]['assets'] as $slot => $asset)
                    @php
                        $value = "";
                        $link = "";
                        if(isset($assetDetails[$slot])){
                            $value = $assetDetails[$slot]['url'];
                            if(isset($assetDetails[$slot]['link'])){
                                $link = $assetDetails[$slot]['link'];
                            }
                            if($assetDetails[$slot]["type"]=="video"){
                                $value = $assetDetails[$slot]['thumbnail'];
                                $link =  $assetDetails[$slot]['url'];
                            }
                        }
                    @endphp
                <div
                        class="positioned image-uploader abc"
                        style="{{ areaStyles($asset['area']) }};
                        @if($asset['type'] == "image")
                            z-index:3;
                            @endif"
                >
                @if($asset["type"] != "corousel")
                    <input type="hidden"
                           class="upload_input "
                           @if($asset['type'] == "image")
                               name="boothimages[]"
                           @else
                               name="brandvideothumbnails[]"

                           @endif
                           value="{{ $value }}"
                    >
                    <input
                            accept="images/*"
                            type="file"
                            @if($asset['type'] == "image")
                            data-name="boothimages"
                            @else
                            data-name="brandvideothumbnails"
                            @endif
                            data-plugins="dropify"
                            data-type="image"
                            data-default-file="{{ assetUrl($value) }}"
                    />
                    @else
                    <div style="width: 100%;height: 100%;" class="corousel-uploader" data-toggle="modal" data-target="#img-uploader" >
                        @if(!isset($value[0]))
                            <span style="cursor: pointer;background: white" class="p-1f h-100 d-flex w-100 align-content-center align-items-center">
                            Click To Upload image
                            </span>
                            @else
                                <div class="carousel slide h-100" data-ride="carousel">
                                    <div class="carousel-inner h-100" >
                                        @if(is_iterable($value))
                                        @foreach($value as $id=>$cimage)
                                        <div class="carousel-item h-100
                                        @if($id==0)
                                        active
                                        @endif">
                                            <img class="d-block img-fluid h-100 w-100"  style="object-fit:cover;" src="{{assetUrl($cimage)}}" alt="First slide">
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                        @endif
                    </div>
                    @endif
                    <input class="form-control urltooltip"
                           @if($asset['type'] == "image")
                           name="boothlinks[]"
                           @elseif($asset['type'] == "video")
                           name="brandvideos[]"
                           @else
                           name="corousellink"
                           @endif
                           type="url"
                           value="{{ $link }}"
                           style="width: 100%;"
                           placeholder="URL"/>
                </div>
                @endforeach
            @endif
     </div>
        <div class="row">
            <div class="col-12">
                <!-- Card 1  -->
                <div class="card ">
                    <div class="card-body">
                        <label for="summernote-basic">Description</label>
                        <textarea id="summernote-basic" name="description">{{$booth->description}}</textarea>
                        <div class="form-group mb-3">
                            <label for="url">Website URL</label>
                            <input type="url" id="url" name="url" class="form-control" value="{{ $booth->url }}">
                        </div>

                        <div>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>

                <!-- Card 3 Videos  -->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Videos</h4>
                        <div class="video-sections row">
                            @foreach($booth->videos as $boothvideo)
                                @if($boothvideo->title != "brandvideo")
                                <div class="form-group mb-3 col-12">
                                    <label for="boothvideos">URL</label>
                                    <input type="url" id="boothvideos" name="boothvideos[]" class="form-control mb-2"
                                           value="{{ $boothvideo->url }}"
                                    >
                                    <label for="videotitles">Title</label>
                                    <input type="text" id="videotitles" name="videotitles[]" class="form-control mb-2"
                                           value="{{ $boothvideo->title }}"
                                    >
                                    <button class="btn btn-danger mb-2 remove-video">Remove</button>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div>
                            <button class="btn btn-primary">Save</button>
                            <button class="btn btn-primary" id="add-video">Add Video</button>
                        </div>
                    </div>
                </div>
                <!-- Card 4 Resources  -->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Resources</h4>
                        <div class="resource-section">
                            @foreach($booth->resources as $resource)
                                <div class="row">
                                    <div class="image-uploader mb-3 col-md-4">
                                        <input type="hidden" name="resources[]" class="upload_input"
                                               value="{{ $resource->url }}">
                                        <input type="file" data-name="resources" data-plugins="dropify" data-type="/"
                                               data-default-file="{{assetUrl($resource->url)}}"/>
                                    </div>
                                    <div class="form-group mb-3 col-md-8">
                                        <label for="resourcetitles">Title</label>
                                        <input type="text" id="resourcetitles" name="resourcetitles[]" class="form-control"
                                               value="{{ $resource->title }}"
                                               >
                                        <button class="btn btn-danger mt-2 remove-resource">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <button class="btn btn-primary">Save</button>
                            <button class="btn btn-primary" id="add-resource">Add Resources</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="img-uploader" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-full-width modal-c">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title pdf-title d-block " id="myLargeModalLabel">Corousal Image Uploader</h4>
                        <h7 class="modal-title">(Upload 1 Image To Keep the Corousel Static)</h7>
                        (Maximum Images To be Uploaded: 3)<br/>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body ">
                        <div class="corousel-section row">
                            @foreach($booth->images as $image)
                                @if($image->title=="corousel")

                                    <div class="image-uploader mb-3 col-md-4">
                                        <input type="hidden"
                                               class="upload_input c-image"
                                               name="corouselimages[]"
                                               value="{{$image->url}}"
                                        >
                                        <input
                                                accept="images/*"
                                                type="file"
                                                data-name="corouselimages"
                                                data-plugins="dropify"
                                                data-type="image"
                                                data-default-file="{{assetUrl($image->url)}}"
                                        />
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <button class="btn btn-primary" id="corousel-img">Add Image</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("scripts")
    @include("includes.scripts.fileUploader")
    @include("includes.scripts.wyswyg")
    <script>
        function addvideo(e) {
            e.preventDefault();
            $(".video-sections").append(`
             <div class="form-group mb-3 col-12">
               <label for="boothvideos">URL</label>
               <input type="url"  id="boothvideos" name="boothvideos[]" class="form-control mb-2">
              <label for="videotitles">Title</label>
              <input type="text"  id="videotitles" name="videotitles[]" class="form-control mb-2">
                <button class="btn btn-danger mb-2 remove-video">Remove</button>
            </div>
          `);
            initializeFileUploads();
            bindRemoveButton();
        }
        function addimage(e) {
            e.preventDefault();
            if($(".c-image").length<3)
            {
            $(".corousel-section").append(`
             <div class="image-uploader mb-3 col-md-4">
              <input type="hidden"
                    class="upload_input c-image"
                    name="corouselimages[]"
                />
                    <input
                        accept="images/*"
                        type="file"
                        data-name="corouselimages"
                        data-plugins="dropify"
                        data-type="image"
                    />
                </div>`);
            initializeFileUploads();
            }else {
                $("#corousel-img").attr("disabled", true);
            }
        }

        function addresource(e) {
            e.preventDefault();
            $(".resource-section").append(`
                <div class="row">
                  <div class="image-uploader mb-3 col-md-4">
                    <input type="hidden" name="resources[]" class="upload_input">
                    <input type="file" data-name="resources" data-plugins="dropify" data-type="/" />
                  </div>
                  <div class="form-group mb-3 col-md-8">
                      <label for="resourcetitles">Title</label>
                      <input type="text"  id="resourcetitles" name="resourcetitles[]" class="form-control" >
                        <button class="btn btn-danger remove-resource mt-2">Remove</button>
                  </div>
                </div>
          `);
            bindRemoveButton();
            initializeFileUploads();
        }

        function removevideo(e){
            e.preventDefault();
            confirmDelete("Are you sure you want to delete the Video", "Confirm Video deletion!").then(confirmation => {
              if(confirmation){
                  $(this).closest(".form-group").remove();
              }
            })

        }

        function removeresource(e) {
            e.preventDefault();
            confirmDelete("Are you sure you want to delete the Resource", "Confirm Resource deletion!").then(confirmation => {
                if(confirmation){
                    $(this).closest(".row").remove();
                }
            })
        }

        function bindRemoveButton(){
            $(".remove-video").unbind().on("click",removevideo);
            $(".remove-resource").unbind().on("click",removeresource);
        }

        $(document).ready(function () {
            $("#add-video").on("click", addvideo);
            $("#add-resource").on("click", addresource);
            $("#corousel-img").on("click",addimage);
            $(".carousel").carousel("cycle");
            $('.carousel').carousel({
                interval: 100
            });
            bindRemoveButton();
        })
    </script>
@endsection
