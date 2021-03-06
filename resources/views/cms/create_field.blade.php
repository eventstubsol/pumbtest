@extends("layouts.admin")

@section("page_title")
    Create CMS Field
@endsection

@section("title")
    Create CMS Field
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Create Field</li>
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("cmsField.store") }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input autofocus type="text" required id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="type">Type</label>
                            <select name="type" id="type" required class="form-control">
                                @foreach(CMS_FIELD_TYPES as $type)
                                    <option value="{{ $type }}">{{ucwords($type)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="section">Section</label>
                            <select name="section" id="section" required class="form-control">
                                @foreach(CMS_SECTIONS as $s)
                                    <option value="{{ $s }}" @if($s == $section) selected @endif>{{ucwords($s)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input class="btn btn-primary" type="submit" value="Create" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection