@extends("layouts.admin")

@section("styles")
    @include("includes.styles.datatables")
@endsection

@section("page_title")
    Booths Page
@endsection

@section("title")
    Booths Page
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Booths</li>
@endsection

@section("content")

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
{{--                <div class="float-right d-none d-md-inline-block">--}}
{{--                    <div class="btn-group mb-2">--}}
{{--                        <a class="btn btn-primary" href="{{ route("booth.create") }}">Create New</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <table id="datatable-buttons" class="table datatable table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Admins</th>
                            <th>Room</th>
                            <th class="text-right mr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($booths as $booth)
                        <tr>
                          <td>{{$booth->name ?? ""}}</td>
                          <td>{!!
                            implode("<Br/>",$booth->admins->map(function($user){
                                return $user->name;
                            })->toArray())
                          !!}</td>
                          <td>{{$booth->room->name ?? ""}}</td>
                            <td class="text-right" >
                                <a href="{{ route("booth.edit", [
                                        "booth" => $booth->id
                                    ]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fe-edit-2" ></i></a>
                                        
                                    <button data-toggle="tooltip" data-placement="top" data-id="{{$booth->id}}" title="" data-original-title="Delete" class="btn btn-danger ml-1 delete"  type="submit"><i class="fas fa-trash-alt"></i></button>
                                <a href="{{ route("exhibiter.edit", [
                                        "booth" => $booth->id
                                    ]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Contents"><i class="fe-edit-2" ></i></a>

                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
                        <!-- end row-->
@endsection


@section("scripts")
    @include("includes.scripts.datatables")
    <script>
        $(document).ready(function(){
            $("#buttons-container").append('<button class="btn btn-primary" id="sync-account">Sync with Chat</button>')
            $("#buttons-container").append('<a class="btn btn-primary" href="{{ route("booth.create") }}">Create New</a>')
        $(".delete").on("click",function(e){
                t = $(this);
                let deleteUrl = '{{route("booth.destroy", [ "booth" => ":id" ])}}';
                let id = t.data("id");
                confirmDelete("Are you sure you want to DELETE Prize?","Confirm Prize Delete").then(confirmation=>{
                    if(confirmation){
                        $.ajax({
                            url:deleteUrl.replace(":id", id),
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "DELETE"
                            },
                            method:"POST",
                            success: function(){
                                t.closest("tr").remove();
                                $(".tooltip").removeClass("show");
                            }
                        })
                    }
                });
            });

            $("#sync-account").click(function(){
                $(this).attr("disabled", "true");
                $(this).addClass("disabled");
                $(this).text("Syncing")

                $.ajax({
                    url: '{{ route("sync-groups") }}',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    method: "GET",
                    success() {
                        $("#sync-account").removeAttr("disabled");
                        $("#sync-account").removeClass("disabled");
                        $("#sync-account").text("Done");
                        setTimeout(()=>{
                            $("#sync-account").text("Sync with Chat")
                }, 2000);
                    }
                })
            });
        });
        
    </script>
@endsection
