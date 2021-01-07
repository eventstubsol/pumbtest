@extends("layouts.admin")

@section('title')
    Manage Polls
@endsection

@section("styles")
    @include("includes.styles.datatables")
@endsection

@section("page_title")
    Manage Polls
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Polls</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div id="message" style="display: none" role="alert" class="alert alert-info mb-1"></div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table datatable table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Questions</th>
                            <th>Created At</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="text-right mr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($polls as $poll)
                        <tr>
                            <td>{{$poll->name}}</td>
                            <td>
                                @switch(checkPollStatus($poll))
                                    @case(0)
                                        Not Started
                                    @break
                                    @case(1)
                                        Ongoing
                                    @break
                                    @case(2)
                                        Completed
                                    @break
                                @endswitch
                            </td>
                            <td>{{$poll->questions_count}}</td>
                            <td>{{$poll->created_at}}</td>
                            <td>{{$poll->start_date}}</td>
                            <td>{{$poll->end_date}}</td>
                            <td class="text-right" >
                                <a href="{{ route("poll.update.get", [
                                        "poll" => $poll->id
                                    ]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fe-edit-2" ></i>
                                </a>
                                <a href="{{ route("poll.results", [
                                        "poll" => $poll->id
                                    ]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Results"><i class="fe-bar-chart" ></i></a>
                                <form class="d-inline" action="{{ route("poll.delete", ["poll" => $poll->id]) }}" method="POST"> @csrf @method("DELETE") <button  data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></form>
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
        function searchToObject() {
            var pairs = window.location.search.substring(1).split("&"),
                obj = {},
                pair,
                i;

            for ( i in pairs ) {
                if ( pairs[i] === "" ) continue;

                pair = pairs[i].split("=");
                obj[ decodeURIComponent( pair[0] ) ] = decodeURIComponent( pair[1] );
            }

            return obj;
        }

    </script>
    <script>
        $(document).ready(function(){
            $("#buttons-container").append('<a class="btn btn-primary" href="{{ route("poll.create.get") }}">Create New</a>')
            let data = searchToObject();
            if(data.message) {
                $("#message").text(data.message)
                $("#message").show()
            }
        });
    </script>
@endsection
