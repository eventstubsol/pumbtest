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
    <div id="sessions-app">
        Loading
    </div>
@endsection

@section("scripts")
    <script>
        window.config = {
            ...(window.config || {}),
            token: "{{ csrf_token() }}",
            sessionTypes: {!! json_encode(EVENT_SESSION_TYPES) !!},
            sessionRooms: {!! json_encode(EVENT_ROOMS) !!},
            sessionSaveRoute: "{{ route("eventSession.save") }}",
            sessions: {!! json_encode($sessions) !!},
            {{--moderatorUsers: {!! json_encode($moderators) !!},--}}
            speakerUsers: {!! json_encode($speakers) !!},
        };
    </script>
    <script src="{{ asset("js/session-manager/index.js") }}"></script>
@endsection