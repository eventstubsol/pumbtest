@extends("layouts.admin")

@section("page_title")
    Create Room
@endsection

@section("title")
    Create Room
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("room.index") }}">Room</a></li>
    <li class="breadcrumb-item active">Room</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("room.store") }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group mb-3">
                        <label for="roomname">Room</label>
                        <input required autofocus type="text" value="{{old('name')}}"  id="roomname" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="example-select">Select Room Type</label>
                        <select name="type" class="form-control  @error('type') is-invalid @enderror"  required id="example-select">
                            <option value="">Select Room</option>
                            @foreach(ROOM_TYPES as $room_type)
                              <option value={{$room_type}}>{{ucfirst($room_type)}}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <input class="btn btn-primary" type="submit" value="Create" />
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
