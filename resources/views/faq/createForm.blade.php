@extends("layouts.admin")

@section("page_title")
    Create FAQ
@endsection

@section("title")
    Create FAQ
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("faq.index") }}">FAQs</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("faq.store") }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <label for="question">Question</label>
                        <input required autofocus type="text"  id="question" value="{{old('question')}}" name="question" class="form-control   @error('question') is-invalid @enderror">
                        @error('question')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="answer">Answer</label>
                        <textarea required rows="10" id="answer" name="answer"  value="{{old('question')}}"  class="form-control  @error('answer') is-invalid @enderror"></textarea>
                        @error('answer')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <input class="btn btn-primary" type="submit" value="Create" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
            

@endsection