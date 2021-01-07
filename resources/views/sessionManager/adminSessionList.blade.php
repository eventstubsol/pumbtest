@extends("layouts.admin")

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Select Session for Polls Archive</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($sessions as $s)
                        @if($s->polls_count == 0)
                            @continue
                        @endif
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $s->name }}
                        <a href="{{ route("eventSession.sessionPoll.archive", ["session" => $s->id ]) }}" class="btn btn-primary">View Polls</a>
                    </li>
                    @endforeach
                </ul>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
                        <!-- end row-->
@endsection

@section("scripts")
    @include("includes.scripts.datatables")
@endsection
