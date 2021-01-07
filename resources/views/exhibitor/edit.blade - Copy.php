@extends("layouts.admin")

@section("page_title")
    Edit Booth: {{ $booth->name }}
@endsection

@section("styles")
  @include("includes.styles.fileUploader")
  @include("includes.styles.wyswyg")
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="/">Booths</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
@php
  $imagescount = getboothImages();
@endphp
<form action="{{ route("exhibiter.update", [ "booth" => $booth->id ]) }}" method="POST">
  @csrf
<div class="row">
    <div class="col-12">
        <!-- Card 1  -->
        <div class="card ">
            <div class="card-body">
                    <label for="summernote-basic">Description</label>
                    <textarea  id="summernote-basic" name="description">{{$booth->description}}</textarea>
                    <div class="form-group mb-3">
                        <label for="url">Website URL</label>
                        <input type="url"  id="url" name="url" class="form-control" value="{{ $booth->url }}" required>
                      </div>

                    <div>
                        <input class="btn btn-primary" type="submit" value="Save" />
                    </div>
                </div>
            </div>
            <!-- Card 2  -->
            <div class="card">
                <div class="card-body">
                        <h4 class="header-title mb-3">Images</h4>
                        <div class="row ">

                        @for($i=0;$i<$imagescount;$i++)
                        <h6 class="title mb-3 col-md-12">Slot {{$i+1}}</h6>
                        <div class="image-uploader mb-3 col-md-3">
                          <input type="hidden" class="upload_input " name="boothimages[]"
                            @if(!empty($booth->images))
                              @foreach($booth->images as $image)
                                @if($image->title == "Slot ".$i)
                                  value="{{ $image->url }}"
                                  @break
                                @endif
                              @endforeach
                            @endif
                            id="{{$i}}"
                            >
                            <input
                             accept="images/*"
                             type="file"
                             data-name="boothimages"
                             data-plugins="dropify"
                             data-type="image"
                             @foreach($booth->images as $image)
                               @if($image->title == "Slot ".$i)
                                 data-default-file="{{ assetUrl($image->url) }}"
                                 @break
                               @endif
                             @endforeach
                             />
                        </div>
                        <div class="form-group mb-3 col-md-8">
                            <label for="boothlinks">Web Link(Page To open on Image Click)</label>
                            <input type="url"  id="boothlinks" name="boothlinks[]" class="form-control"
                            @foreach($booth->images as $image)
                              @if($image->title == "Slot ".$i)
                                  value="{{ $image->link }}"
                                 @break
                               @endif
                             @endforeach
                                   required>
                          </div>
                           @endfor
                         </div>

                           <div>
                               <button class="btn btn-primary mt-3" >Save</button>
                           </div>
                </div>
              </div>
              <!-- Card 3 Videos  -->

              <div class="card">
                  <div class="card-body">
                      <h4 class="header-title mb-3">Videos</h4>
                      <div class="video-section row">
                      @foreach($booth->videos as $boothvideo)

                       <div class="form-group mb-3 col-12">
                           <label for="boothvideos">URL</label>
                           <input type="url"  id="boothvideos" name="boothvideos[]" class="form-control mb-2"
                                  value="{{ $boothvideo->url }}"
                                  required>
                           <label for="videotitles">Title</label>
                           <input type="text"  id="videotitles" name="videotitles[]" class="form-control"
                                 value="{{ $boothvideo->title }}"
                             required>
                         </div>
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
                      <div class="resource-section row">
                        @foreach($booth->resources as $resource)
                        <div class="image-uploader mb-3 col-md-4">
                          <input type="hidden" name="resources[]" class="upload_input"  value="{{ $resource->url }}">
                          <input type="file" data-name="resources" data-plugins="dropify" data-type="/"   data-default-file="{{assetUrl($resource->url)}}" />
                        </div>
                        <div class="form-group mb-3 col-md-8">
                            <label for="resourcetitles">Title</label>
                            <input type="text"  id="resourcetitles" name="resourcetitles[]" class="form-control"
                                  value="{{ $resource->title }}"
                              required>
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
</form>
@endsection

@section("scripts")
  @include("includes.scripts.fileUploader")
  @include("includes.scripts.wyswyg")
  <script>
      function addvideo(e){
        e.preventDefault();
        $(".video-section").append(`
             <div class="form-group mb-3 col-12">
               <label for="boothvideos">URL</label>
               <input type="url"  id="boothvideos" name="boothvideos[]" class="form-control mb-2">
              <label for="videotitles">Title</label>
              <input type="text"  id="videotitles" name="videotitles[]" class="form-control" required>
            </div>
          `);
        initializeFileUploads();
      }
      function addresource(e){
        e.preventDefault();
        $(".resource-section").append(`
          <div class="image-uploader mb-3 col-md-4">
            <input type="hidden" name="resources[]" class="upload_input">
            <input type="file" data-name="resources" data-plugins="dropify" data-type="/" />
          </div>
          <div class="form-group mb-3 col-md-8">
              <label for="resourcetitles">Title</label>
              <input type="text"  id="resourcetitles" name="resourcetitles[]" class="form-control" required>
            </div>

          `);
        initializeFileUploads();
      }
      $(document).ready(function(){
        $("#add-video").on("click", addvideo);
        $("#add-resource").on("click", addresource);
      })
  </script>
@endsection
