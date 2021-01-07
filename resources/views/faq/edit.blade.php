@extends("layouts.admin")

@section("page_title")
    Edit FAQ
@endsection

@section("title")
    Edit FAQ
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("faq.index") }}">FAQs</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("faq.update", [ "faq" => $faq->id ]) }}" method="post">
                    {{ csrf_field() }}
                    @method("PUT")
                    <div class="form-group mb-3">
                        <label for="question">Question</label>
                        <input required class="form-control @error('question') is-invalid @enderror" autofocus type="text" name="question" id="question" value="{{ $faq->question }}" />
                         @error('question')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="answer">Answer</label>
                        <textarea required rows="10" class="form-control   @error('answer') is-invalid @enderror" name="answer" id="answer">{{ $faq->answer }}</textarea>
                        @error('answer')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <input class="btn btn-primary" type="submit" value="Save" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
