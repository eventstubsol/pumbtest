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
    <script>
        window.config = {
            token: "{{ csrf_token() }}",
            session: {!! json_encode($session) !!},
            pollCreateRoute: "{{ route("eventSession.poll.create", [ "session" => $session->id ]) }}",
            pollListRoute: "{{ route("eventSession.poll.get", [ "session" => $session->id ]) }}",
            pollManageRoute: "{{ route("eventSession.poll.manage", [ "session" => $session->id ]) }}",
            pollResultRoute: "{{ route("eventSession.poll.results") }}",
            pollResultViewRoute: "{{ route("eventSession.poll.resultsView", ["poll" => "pollIdReplacement"]) }}",
            pollStopRoute: "{{ route("eventSession.poll.stop") }}",
        };
    </script>
    <div id="sessions-poll-app"></div>
@endsection

@section("scripts")
    <script src="{{ asset("js/session-poll-app/index.js") }}"></script>
@endsection