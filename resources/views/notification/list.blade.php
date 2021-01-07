@extends("layouts.admin")

@section('title')
    Manage Notifications
@endsection

@section("styles")
    @include("includes.styles.datatables")
@endsection

@section("page_title")
    Manage Notifications
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item active">Notifications</li>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table datatable table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Message</th>
                            <th>URL</th>
                            <th>Roles</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{{ $notification->title }}</td>
                            <td>{{ $notification->message }}</td>
                            <td>{{ $notification->url ?? 'N/A' }}</td>
                            <td>{{ $notification->roles }}</td>
                            <td>{{ $notification->created_at }}</td>
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
            $("#buttons-container").append('<a class="btn btn-primary" href="{{ route("notifications.create.get") }}">Create New</a>')
        });
    </script>
@endsection