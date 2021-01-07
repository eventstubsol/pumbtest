@extends("layouts.admin")

@section("page_title")
    Edit Provisional Group
@endsection

@section("title")
    Edit Provisional Group
@endsection

@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
@endsection


@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("provisional.index") }}">Provisional Groups</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("provisional.update", [ "provisional" => $provisional->id ]) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input autofocus type="text"  id="title" name="title" class="form-control   @error('title') is-invalid @enderror" value="{{$provisional->title}}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="image-uploader mb-3 col-12">
                        <label for="pdf">PDF 1</label>
                        <input id="pdf" type="hidden" name="url1" class="upload_input" value="{{$provisional->resource[0]->url ?? ""}}"  >
                        <input type="file" data-name="resources" data-plugins="dropify" data-type="/" data-default-file="{{($provisional->resource[0]->url  ?? false) ? assetUrl($provisional->resource[0]->url) : ""}}" />
                    </div>

                    <div class="image-uploader mb-3 col-12">
                        <label for="pdf">PDF 2</label>
                        <input id="pdf" type="hidden" name="url2" class="upload_input" value="{{$provisional->resource[1]->url ?? ""}}"  >
                        <input type="file" data-name="resources" data-plugins="dropify" data-type="/" data-default-file="{{($provisional->resource[1]->url  ?? false) ? assetUrl($provisional->resource[1]->url) : ""}}" />
                    </div>

                    <div class="form-group mb-3">
                        <label for="video">Video URL</label>
                        <input class="form-control @error('video') is-invalid @enderror" id="video" type="url" name="video" value="{{$provisional->video->url ?? ""}}">
                    </div>
                    <div>
                        <button class="btn btn-primary">Save</button>
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