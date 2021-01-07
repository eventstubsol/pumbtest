@extends("layouts.admin")


@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
@endsection

@section("page_title")
    Create Prize
@endsection

@section("title")
    Create Prize
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("prize.index") }}">Prize</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <form action="{{ route("prize.store") }}" method="post" data-parsley-validate="">
                @csrf
            <div class="card">
                <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input autofocus type="text"  id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old("title") }}" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="summernote-basic">Description</label>
                            <textarea id="summernote-basic"  name="description" class="form-control @error('description') is-invalid @enderror" required>{!! old("description") !!}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="form-group mb-3">
                            <label for="criteria_high">Criteria High</label>
                            <input type="number"  id="criteria_high" name="criteria_high" value="{{ old("criteria_high") }}" class="form-control @error('criteria') is-invalid @enderror @error('criteria_high') is-invalid @enderror" required data-parsley-gte="#criteria_low">
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
                            <input type="number"  id="criteria_low" name="criteria_low" value="{{ old("criteria_low") }}"  class="form-control @error('criteria_low') is-invalid @enderror" required>
                            @error('criteria_low')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                </div>
            </div>
            <!-- Card 2 images  -->

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Images</h4>
                    <div class="image-section row">
                         @for($i = 0; $i < intval(old("imageurl"));$i++)
                            <div class="image-uploader mb-3 col-md-3">
                                <input type="hidden" class="upload_input " name="imageurl[]"  value="{{old("imageurl.".$i)}}">
                                <input
                                        accept="images/*"
                                        type="file"
                                        data-name="imageurl"
                                        data-plugins="dropify"
                                        data-type="image"
                                        data-default-file={{assetUrl(old("imageurl.".$i))}}
                                />
                            </div>
                        @endfor
                    </div>
                    <button class="btn btn-primary" id="add-image">Add Image</button>
                </div>
            </div>

            <div class="card col-12">
                <button class="btn btn-primary m-3 submit">Create</button>
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
        })
    </script>
@endsection