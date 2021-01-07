@extends("layouts.admin")


@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
@endsection

@section("page_title")
    Create Provisional Group
@endsection

@section("title")
    Create Provisional Group
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("provisional.index") }}">Provisional Groups</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("provisional.store") }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input autofocus type="text" value="{{old('title')}}"  id="title" name="title" class="form-control  @error('title') is-invalid @enderror" required >
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="image-uploader mb-3 col-12">
                            <label for="pdf1">PDF1</label>
                            <input id="pdf1" type="hidden" name="url1" class="upload_input" >
                            <input type="file" data-name="resources" data-plugins="dropify" data-type="/" />
                        </div>
                        <div class="image-uploader mb-3 col-12">
                            <label for="pdf2">PDF2</label>
                            <input id="pdf2" type="hidden" name="url2" class="upload_input" >
                            <input type="file" data-name="resources" data-plugins="dropify" data-type="/" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="video">Video URL</label>
                            <input value="{{old('video')}}" class="form-control  @error('video') is-invalid @enderror" id="video" type="url" name="video">
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
@endsection