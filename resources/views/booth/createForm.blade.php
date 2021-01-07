@extends("layouts.admin")


@section("styles")
    @include("includes.styles.select")
@endsection


@section("page_title")
    Create Booth
@endsection

@section("title")
    Create Booth
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("booth.index") }}">Booths</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("booth.store") }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group mb-3">
                        <label for="boothname">Booth Name</label>
                        <input autofocus type="text" value="{{old('name')}}" id="boothname" name="name" class="form-control  @error('name') is-invalid @enderror" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="booth_type">Type</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" id="booth_type" required>
                            <option value="">Select Booth</option>
                            @foreach(BOOTH_TYPES as $booth_type)
                                <option value={{$booth_type}}>{{ucfirst($booth_type)}}</option>
                            @endforeach
                        </select>
                         @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="example-select">Room</label>
                        <select name="room_id" class="form-control @error('room_id') is-invalid @enderror" id="example-select" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                              <option value={{$room->id}}>{{$room->name}}</option>
                             @endforeach
                        </select>
                         @error('room_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="calendly_link">Calendly Link</label>
                        <input type="url" name="calendly_link" class="form-control @error('calendly_link') is-invalid @enderror" id="calendly_link" />
                        @error('room_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <div class="mb-3">
                          <label for="user">Select Exhibitor</label>
                          <select class="form-control select2-multiple @error('userids') is-invalid @enderror" id="user" name="userids[]" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." required>
                              @foreach($users as $user)
                                <option value={{$user->id}}>{{$user->name}} ({{$user->email}}) </option>
                              @endforeach
                          </select>
                           @error('userids')
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

  @section("scripts")
    @include("includes.scripts.select")
  @endsection
@endsection
