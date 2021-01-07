@extends("layouts.admin")

@section("page_title")
    CMS Fields Manager
@endsection

@section("title")
    CMS Fields Manager
@endsection

@section("styles")
    @include("includes.styles.fileUploader")
@endsection

@section("content")
    @php
        $fields = getAllFields();
    @endphp
    <div class="progress progress-sm upload mb-2"><div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>
    <form action="{{ route("cms.updateContent") }}" method="POST">
        @csrf
        @foreach(CMS_SECTIONS as $section)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $section }}</h3>
                        </div>
                        <div class="card-body">
                            @foreach($fields as $field)
                                @if($field->section == $section)
                                    <div class="form-group">
                                        <label><b>{{ ucwords(str_replace("_", " ", $field->name)) }}</b></label>
                                        @switch($field->type)
                                            @case("text")
                                            @case("url")
                                            @case("number")
                                            <input class="form-control" name="{{ $field->id }}" type="{{ $field->type }}" value="{{ $field->value }}" />
                                            @break

                                            @case("youtube")
                                            <input class="form-control" name="{{ $field->id }}" type="url" value="{{ $field->value }}" />
                                            @break

                                            @case("textarea")
                                            <textarea class="form-control" name="{{ $field->id }}" rows="10">
                                                {{$field->value}}
                                            </textarea>
                                            @break

                                            @case("image")
                                            @case("video")
                                            <div class="image-uploader">
                                              <input type="hidden" class="upload_input" name="{{ $field->id }}" value="{{ $field->value }}">
                                              <input
                                                  accept="images/*"
                                                  type="file"
                                                  data-name="{{ $field->id }}"
                                                  data-plugins="dropify"
                                                  data-type="{{ $field->type }}"
                                                  @if(!empty(trim($field->value)))
                                                      data-default-file="{{ assetUrl($field->value) }}"
                                                  @endif
                                              />
                                            </div>
                                            @break

                                        @endswitch
                                    </div>
                                @endif
                            @endforeach
                            <div class="text-right"><button class="btn btn-primary w-25 mb-3">Save</button></div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        @endforeach
    </form>
@endsection


@section("scripts")
    @include("includes.scripts.fileUploader")
@endsection
