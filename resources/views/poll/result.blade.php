@extends("layouts.admin")


@section('title')
    Poll Results
@endsection

@section("page_title")
    Poll Results
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("poll.manage") }}">Polls</a></li>
    <li class="breadcrumb-item active">Results</li>
@endsection


@section("content")
    <div id="result">
        @include("poll.resultCharts")
    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function(){
            let resultsPanel = $("#result");
            function fetchResult(){
                $.ajax({
                    url:"{{ route("poll.results.api", ["poll"=>$poll->id]) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response){
                        setTimeout(fetchResult, 1500);
                        resultsPanel.html(response);
                    },
                    error: function(err){
                        setTimeout(fetchResult, 1500);
                        console.log("Error while fetching results!");
                    },
                })
            }
            fetchResult();
            // setInterval(fetchResult, 2000);
        });
    </script>
@endsection