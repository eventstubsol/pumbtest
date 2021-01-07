@extends("layouts.admin")

@section("styles")
    <style>
        .poll-results .progress {
            width: 70%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.175;
            background: #1abc9c;
            border-radius: 0;
            height: 100%;
            transition: width 0.3s ease;
        }

        .poll-results .list-group-item {
            border: 1px solid rgba(0, 0, 0, .25);
        }
    </style>
@endsection

@section("content")
    @php
        $user = Auth::user();
    @endphp
    <script>
        window.config = {
            token: "{{ csrf_token() }}",
            @if($user->type == "teller")
            pollResultRoute: "{{ route("teller.pollResults") }}",
            pollResultViewRoute: "{{ route("teller.pollResultView", ["poll" => $poll->id]) }}",
            @else
            pollResultRoute: "{{ route("eventSession.poll.results") }}",
            pollResultViewRoute: "{{ route("eventSession.poll.resultsView", ["poll" => $poll->id]) }}",
            @endif
            showOnlyResult: true,
            poll: {!! json_encode($poll) !!},
        };
    </script>
    <div class="mb-3 text-right">
            <button class="btn btn-primary" onclick="print()">Export to PDF</button>
    </div>
    <div id="sessions-poll-app">
    </div>
@endsection

@section("scripts")
    <script src="{{ asset("js/session-poll-app/index.js") }}"></script>
@endsection