@extends("layouts.admin")

@section("page_title")
    CMS Fields Manager
@endsection
@section("title")
    CMS Fields Manager
@endsection
@section("content")
    @php
        $fields = getAllFields();
    @endphp
    @foreach(CMS_SECTIONS as $section)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-right d-none d-md-inline-block">
                        <div class="btn-group mb-2">
                            <a class="btn btn-primary" href="{{ route("cmsField.create", [ "section" => $section ]) }}">Create New</a>
                        </div>
                    </div>
                    <h3>{{ $section }}</h3>
                </div>
                <div class="card-body">
                    <table id="datatable-buttons" class="table datatable table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-right mr-2">Type</th>
                            <th class="text-right mr-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($fields as $field)
                                @if($field->section == $section)
                                <tr>
                                    <td>{{ $field->name }}</td>
                                    <td>{{ ucwords($field->type) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route("cmsField.edit", [ "field" => $field->id ]) }}" class="btn btn-primary mr-2">Edit</a>
                                        <form method="POST" action="{{ route("cmsField.delete", [ "field" => $field->id ]) }}" class="d-inline">
                                            @csrf
                                            <input class="btn btn-danger" type="submit" value="Delete" />
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    @endforeach
@endsection


@section("scripts")

@endsection