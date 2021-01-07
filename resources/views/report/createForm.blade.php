@extends("layouts.admin")


@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
    @include("includes.styles.select")
@endsection

@section("page_title")
    Create Report
@endsection

@section("title")
    Create Report
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("report.index") }}">Reports</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("report.store") }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input autofocus type="text"  value="{{old('title')}}"  id="title" name="title" class="form-control  @error('title') is-invalid @enderror" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="image-uploader mb-3 col-12">
                            <label for="pdf1">PDF 1</label>
                            <input id="pdf1" type="hidden" name="url1" class="upload_input"  value="{{old('url1')}}"  >
                            <input type="file" data-name="resources" data-plugins="dropify" data-type="/"   />
                        </div>


                        <div class="image-uploader mb-3 col-12">
                            <label for="pdf2">PDF 2</label>
                            <input id="pdf2" type="hidden" name="url2" class="upload_input"  value="{{old('url2')}}"  >
                            <input type="file" data-name="resources" data-plugins="dropify" data-type="/"   />
                        </div>

                        <div class="video-sections row">
                            <div class="form-group mb-3 col-12">
                                        <label for="videos">Video URL</label>
                                        <input type="url" value="{{old('video')}}"  id="videos" name="video" class="form-control mb-2" >
                            </div>

                       </div>

                        <div>
                            <button class="btn btn-primary">Create</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section("scripts")
    @include("includes.scripts.fileUploader")
    @include("includes.scripts.wyswyg")
    @include("includes.scripts.select")
@endsection