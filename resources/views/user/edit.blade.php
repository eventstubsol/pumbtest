@extends("layouts.admin")

@section('title')
    Edit User "{{ $user->email }}"
@endsection

@section("page_title")
    Edit User "{{ $user->email }}"
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("user.index") }}">Users</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("user.update", ["user" => $user->id]) }}" method="POST">
                    @csrf
                    @method("PUT")
                    
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input autofocus required value="{{ $user->name }}" type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input id="email" required value="{{ $user->email }}" type="email" name="email" class="form-control @error('email') is-invalid @enderror" />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="user-type">Type of User</label>
                        <select class="form-control" id="user-type" value="{{ $user->type }}" name="type">
                            @foreach(USER_TYPES as $type)
                                <option value="{{ $type }}" @if ($user->type == $type) selected @endif>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (!$user->email_verified_at)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="verify_email" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Verify Email</label>
                    </div>
                    @endif

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="{{ !$user->isCometChatAccountExist ? 'enable_chat' : 'disable_chat' }}" class="custom-control-input" id="customCheck2" >
                        <label class="custom-control-label" for="customCheck2">@if (!$user->isCometChatAccountExist) Enable @else Disable @endif Chat Account (<em>Check this to perform action</em>)</label>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection