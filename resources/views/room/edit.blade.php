@extends("layouts.admin")

@section("page_title")
    Edit Room
@endsection

@section("title")
    Edit Room
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("room.index") }}">Room</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("room.update", [ "room" => $room->id ]) }}" method="post">
                    {{ csrf_field() }}
                    @method("PUT")
                    <div class="form-group mb-3">
                        <label for="name">Room Name</label>
                        <input required class="form-control  @error('name') is-invalid @enderror" autofocus type="text" name="name" id="name" value="{{ $room->name }}" />
                         @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="example-select">Select Room Type</label>
                        <select name="type" class="form-control  @error('type') is-invalid @enderror" id="example-select" required>
                            <option value="">Select Room</option>
                            @foreach(ROOM_TYPES as $room_type)
                                <option value={{$room_type}}
                                @if($room_type == $room->type)
                                    selected="selected"
                                @endif
                                >{{ucfirst($room_type)}}</option>
                            @endforeach
                        </select>
                         @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <input class="btn btn-primary" type="submit" value="Save" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
