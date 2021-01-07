@extends("layouts.admin")

@section("page_title")
    Edit Report
@endsection

@section("title")
    Edit Report
@endsection

@section("styles")
    @include("includes.styles.fileUploader")
    @include("includes.styles.wyswyg")
    @include("includes.styles.select")
@endsection


@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("report.index") }}">Reports</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("report.update", [ "report" => $report->id ]) }}" method="post">
                    {{ csrf_field() }}
                    @method("PUT")
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input autofocus type="text"  id="title" name="title" class="form-control  @error('title') is-invalid @enderror" value="{{$report->title}}" required>
                         @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>


                    <div class="image-uploader mb-3 col-12">
                        <label for="pdf">PDF 1</label>
                        <input id="pdf" type="hidden" name="url1" class="upload_input" value="{{$report->resources[0]->url ?? ""}}" >
                        <input type="file" data-name="resources" data-plugins="dropify" data-type="/" data-default-file="{{($report->resources[0]->url  ?? false) ? assetUrl($report->resources[0]->url) : ""}}"/ >
                    </div>
                   <div class="image-uploader mb-3 col-12">
                        <label for="pdf">PDF 2</label>
                        <input id="pdf" type="hidden" name="url2" class="upload_input" value="{{$report->resources[1]->url ?? ""}}" >
                        <input type="file" data-name="resources" data-plugins="dropify" data-type="/" data-default-file="{{($report->resources[1]->url  ?? false) ? assetUrl($report->resources[1]->url) : ""}}"/ >
                    </div>

                    <div class="video-sections row">
                        <div class="form-group mb-3 col-12">
                            <label for="videos">Video URL</label>
                            <input type="url" value="{{$report->video->url ?? ""}}"  id="videos" name="video" class="form-control mb-2" >
                        </div>
                        @error('video')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
    @include("includes.scripts.select")
@endsection