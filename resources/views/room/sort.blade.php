@extends("layouts.admin")

@section("styles")
    @include("includes.styles.datatables")
    @include("includes.styles.sweetalert2")
@endsection

@section("page_title")
   Sort Rooms
@endsection

@section("title")
   Sort Rooms
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("room.index") }}">Room</a></li>
    <li class="breadcrumb-item active">Sort Rooms</li>
@endsection

@section("content")

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul id="sortable" class="list-group mb-2">
                  @foreach($rooms as $id => $room)
                    <li id="{{$room->id}}" class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="roomname"> <b>{{ $id + 1 }}</b>. {{$room->name}} </span>
                        <span class="badge badge-primary badge-pill">{{$room->type}}</span>
                    </li>   
                  @endforeach
                </ul>
                <button id="save" class="btn btn-primary">Save</button>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
                        <!-- end row-->
@endsection


@section("scripts")
    @include("includes.scripts.datatables")
    @include("includes.scripts.jqueryui")
    @include("includes.scripts.sweetalert2")

    <script>
         function storesorting(){
                    let sortableEl = $("#sortable").sortable();
                     $.ajax({
                        url: '{{route("room.storesorting")}}',
                        data: {rooms : sortableEl.sortable("toArray")},
                        success:function(response){
                            if(response.success){
                                Swal.fire({
                                    title:  "Saved",
                                    text: "Saved Successfully",
                                    type: "success",
                                });
                            }
                        }
                    });             
                }
        $(document).ready(function(){
            let sortableEl = $("#sortable").sortable();
            $("#save").on("click",storesorting);
            sortableEl.sortable({
                "update": function(event, ui){
                    let rooms = $(".roomname");
                    rooms.each(function(i){
                        $(this).find("b").html(i + 1)
                    });
                }
            })
        });
    </script>
@endsection
