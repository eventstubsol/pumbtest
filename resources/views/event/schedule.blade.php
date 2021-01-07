@extends("layouts.single-outer")

@section("content")
    <div class="page menu-filled" id="faq">
        <div class="page-header col-12">
            <div class="col-11 col-lg-9 mx-auto">
                <h2 class="mb-3 text-white">Event Schedule</h2>
            </div>
        </div>
        <div class="col-11 col-lg-9 mx-auto" id="schedule-list">
            @include("event.modules.Schedule")
        </div>
    </div>
@endsection