@extends("layouts.admin")

@section("styles")

@endsection

@section("page_title")
    Manage your Booth
@endsection

@section("title")
    Manage your Booth
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Booths</li>
@endsection

@section("content")
  @php
    $booths = getBooths();
  @endphp
  <div class="row">
  @foreach($booths as $booth)
    <div class="card card-body col-md-5 m-1 ml-5">
        <h5 class="card-title">{{$booth->name}}</h5>
        <p>Created At: {{$booth->created_at}}</p>
        <p>
            <a href="{{ route("exhibiter.edit", ["booth"=> $booth->id] ) }}" class="btn btn-primary mr-2 waves-effect waves-light">Edit Booth</a>
            <a href="{{ route("exhibiter.enquiries", ["booth"=> $booth->id] ) }}" class="btn btn-primary waves-effect waves-light">Enquiries</a>
        </p>
    </div>
  @endforeach
  </div>
@endsection


@section("scripts")

@endsection
