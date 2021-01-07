@extends("layouts.admin")

@section('title')
    Teller Dashboard
@endsection

@section("styles")
    @include("includes.styles.datatables")
@endsection

@section("page_title")
    Teller Dashboard
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Polls</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Questions</th>
                            <th>Start Date</th>
                            <th class="text-right mr-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $polls = getTellerPolls();
                        @endphp
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
                                <td>
                                    <ol>
                                        @foreach($poll->questions as $question)
                                            <li>{{ Str::limit(strip_tags($question->text), 100) }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>{{$poll->start_date}}</td>
                                <td class="text-right" >
                                    <a href="{{ route("teller.pollResultView", ["poll" => $poll->id]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Results"><i class="fe-bar-chart" ></i></a></td>
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
            $("#buttons-container").append('<a class="btn btn-primary" href="{{ route("poll.create.get") }}">Create New</a>')
        });
    </script>
@endsection
