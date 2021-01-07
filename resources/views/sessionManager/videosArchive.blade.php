@extends("layouts.admin")

@section('title')
    Manage Session Videos Archive
@endsection

@section("page_title")
    Manage Session Videos Archive
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route("eventSession.saveVideoArchive") }}" method="POST">
            @csrf
            <div class="row" id="videos-list">
                @foreach($videos as $video)
                    <div class="col-md-12 mr-1 single-video">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="id[]">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title[]" value="{{ $video->title }}" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Vimeo Video ID</label>
                                    <input type="text" name="video_id[]" value="{{ $video->video_id }}" class="form-control" />
                                </div>
                                <button class="btn btn-danger delete-btn"><i class="fe-trash mr-1"></i> Remove</button>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body  d-flex justify-content-between">
                            <button class="btn btn-primary"><i class="fe-save mr-1"></i> Save</button>
                            <button class="btn btn-primary mr-2" id="add-new"><i class="fe-plus mr-1"></i> Add New</button>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div>
            </div>
        </form>
    </div><!-- end col-->
</div>
                        <!-- end row-->
@endsection

@section("scripts")
    <script>
        $(document).ready(function(){
            let videosList = $("#videos-list");
            function activateDeleteButtons(){
                videosList.find(".delete-btn").unbind().on("click", function(e){
                    e.preventDefault();
                    confirmDelete("Are you sure you want to delete the Session video from archive?").then(confirmed => {
                        if(confirmed){
                            $(this).closest(".single-video").remove();
                        }
                    });
                })
            }
            activateDeleteButtons();
            $("#add-new").on("click", function(e){
                e.preventDefault();
                videosList.append(`
                    <div class="col-md-12 mr-1 single-video">
<div class="card">
                            <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="title[]" value="" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Vimeo Video ID</label>
                            <input type="text" name="video_id[]" class="form-control" />
                        </div>
                                <button class="btn btn-danger delete-btn"><i class="fe-trash mr-1"></i> Remove</button>

</div></div>
                    </div>
                `);
                activateDeleteButtons();
            });
        });
    </script>
@endsection
