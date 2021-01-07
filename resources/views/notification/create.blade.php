@extends("layouts.admin")

@section('title')
    Create Notification
@endsection

@section("styles")
    @include("includes.styles.datatables")
@endsection

@section("page_title")
    Create Notification
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active"><a href="{{ route("notifications.list.get") }}">Notifications</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("notifications.create.post") }}" method="post">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input autofocus maxlength="255" required value="{{ old('title') }}" type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" />
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="message">Message</label>
                        <textarea id="message" required name="message" class="form-control @error('message') is-invalid @enderror" maxlength="255">{{ old('message') }}</textarea>
                        @error('message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="url">URL (<em>Optional</em> )</label>
                        <input id="url" name="url" type="url" class="form-control @error('url') is-invalid @enderror" />
                        @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="user-type">Select Roles</label>
                        <select id="user-type" name="roles[]" multiple="" class="form-control @error('message') is-invalid @enderror">
                            <option selected>All</option>
                            <option>Attendee</option>
                            <option>Delegates</option>
{{--                            <option>Active Users</option>--}}
{{--                            <option>Inactive Users</option>--}}
                        </select>
                        @error('roles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
