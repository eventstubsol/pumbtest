@extends("layouts.admin")

@section("styles")
    @include("includes.styles.datatables")
@endsection

@section("page_title")
    Provisional Groups Page
@endsection

@section("title")
    Provisional Groups Page
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Provisional Groups</li>
@endsection

@section("content")

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table datatable table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>provisional Title</th>
                            <th class="text-right mr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($provisionals as $provisional)
                        <tr>
                            <td>{{$provisional->title}}</td>
                            <td class="text-right" >
                                <a href="{{ route("provisional.edit", [
                                        "provisional" => $provisional->id
                                    ]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fe-edit-2" ></i></a>
                                    <button data-toggle="tooltip" data-id="{{$provisional->id}}" data-placement="top" title="" data-original-title="Delete" class="delete btn btn-danger ml-1 "  type="submit"><i class="fas fa-trash-alt"></i></button>
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
            $("#buttons-container").append('<a class="btn btn-primary" href="{{ route("provisional.create") }}">Create New</a>')
           $(".delete").on("click",function(e){
                t = $(this);
                let deleteUrl = '{{route("provisional.destroy", [ "provisional" => ":id" ])}}';
                let id = t.data("id");
                confirmDelete("Are you sure you want to DELETE Provisional Group?","Confirm Provisional Group Delete").then(confirmation=>{
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
        });
    </script>
@endsection
