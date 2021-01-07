@extends("layouts.admin")

@section("page_title")
    Edit Prize
@endsection

@section("title")
    Edit Prize
@endsection

@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
@endsection


@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("prize.index") }}">Prizes</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <form action="{{ route("prize.update", [ "prize" => $prize->id ]) }}" method="post">
            @csrf
            @method("PUT")
        <div class="card">
            <div class="card-body">

                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input autofocus type="text"  id="title" name="title" class="form-control @error('title') is-invalid @enderror"" required value="{{$prize->title}}">
                          @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="summernote-basic">Description</label>
                        <textarea id="summernote-basic"  name="description" class="form-control @error('description') is-invalid @enderror" required> {{$prize->description}}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="criteria_high">Criteria High</label>
                        <input type="number"  id="criteria_high" name="criteria_high" class="form-control @error('criteria') is-invalid @enderror @error('criteria_high') is-invalid @enderror" required value="{{$prize->criteria_high}}">
                         @error('criteria')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                          @error('criteria_high')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="criteria_low">Criteria Low</label>
                        <input type="number"  id="criteria_low" name="criteria_low" class="form-control  @error('criteria_low') is-invalid @enderror" required value="{{$prize->criteria_low}}">
                         @error('criteria_low')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>


            </div>
        </div>
            <div class="card">
                <div class="card-body">
                    <div class="image-section row">
                        @foreach($prize->images as $image)
                            <div class="image-uploader mb-3 col-md-3">
                                <input type="hidden" class="upload_input " name="imageurl[]"  value="{{$image->url}}">
                                <input
                                        accept="images/*"
                                        type="file"
                                        data-name="imageurl"
                                        data-plugins="dropify"
                                        data-type="image"
                                        data-default-file={{assetUrl($image->url)}}
                                />
                            </div>
                        @endforeach
                    </div>
                <button class="btn btn-primary" id="add-image">Add Image</button>
                </div>
            </div>


            <div class="card col-12 ">
                <button class="btn btn-primary m-3" >Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section("scripts")
    @include("includes.scripts.fileUploader")
    @include("includes.scripts.wyswyg")
    <script>
        function addimage(e) {
            e.preventDefault();
            $(".image-section").append(`<div class="image-uploader mb-3 col-md-3">
                            <input type="hidden" class="upload_input " name="imageurl[]">
                            <input
                                    accept="images/*"
                                    type="file"
                                    data-name="imageurl"
                                    data-plugins="dropify"
                                    data-type="image"/>
                        </div>`);
            initializeFileUploads();
        }

        $(document).ready(function(){
            $("#add-image").on("click", addimage);
            const high = $("#criteria_high");
            const low = $("#criteria_low");
            $("form").on("submit", function(e){
                if(high.val() < low.val()){
                    e.preventDefault();
                    high.addClass("is-invalid");
                    alert("High value can not be lower than low value!")
                }
            });
        })
    </script>

@endsection