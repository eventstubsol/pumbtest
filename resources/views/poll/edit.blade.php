@extends("layouts.admin")

@section("title")
    Edit Poll - {{ $poll->name }}
@endsection

@section("page_title")
    Edit Poll - {{ $poll->name }}
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="{{ route("poll.manage") }}">Polls</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="app">
                        @verbatim
                            <fieldset>
                                <legend>Poll Details</legend>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Poll Name</label>
                                            <input autofocus type="text" id="title" v-model="pollName" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" v-model='startDate' class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" v-model='endDate' class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset v-for="(question, idx) in questions" :key="idx">
                                <legend>Question #{{ idx + 1 }}<button v-if='questions.length > 1 && idx >= 1' class="mt-2 btn btn-primary mt-n1 ml-3" v-on:click="shift('up', idx)"><i class="fe-chevron-up"></i></button> <button v-if='questions.length > 1' class="mt-2 btn btn-danger mt-n1 ml-3" v-on:click="removeQuestion(idx)"><i class="fe-minus"></i></button> <button v-if='questions.length > 1 && idx < questions.length - 1' class="mt-2 btn btn-primary mt-n1 ml-3" v-on:click="shift('down', idx)"><i class="fe-chevron-down"></i></button>
                                </legend>
                                <div class="form-group">
                                    <label>Question Text</label>
                                    <ckeditor v-model="question.text" :config="editorConfig"></ckeditor>
                                </div>

                                <div class="form-group" style="font-weight: bold">
                                    <label for="title">Options <button class="btn btn-success" v-on:click="question.options.push('')"><i class="fe-plus"></i></button></label>
                                </div>

                                <div class="row form-group mb-3" v-for="(option, idx) in question.options" :key="idx">
                                    <div class="col-10">
                                        <input type="text" class="form-control" v-model="question.options[idx]">
                                    </div>
                                    <div class="col-2 text-center">
                                        <button class="btn btn-success" v-if="question.options.length == idx + 1" v-on:click="question.options.push('')"><i class="fe-plus"></i></button>
                                        <button class="btn btn-danger" v-if="question.options.length > 1" v-on:click="question.options.splice(idx, 1)"><i class="fe-minus"></i></button>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <button class="mt-2 btn btn-primary" v-on:click="questions.push({ text: '', options: [''] })"><i class="fe-plus"></i> Add Question</button>
                            </div>

                            <div class="form-group float-right">
                                <button v-bind:disabled="working" id="btn-save" v-bind:class="{ disabled: working }"  v-on:click="save" class="mt-2 btn btn-primary">Update Poll</button>
                            </div>
                        @endverbatim
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/vue@2.6.11'></script>
    <script src="https://cdn.jsdelivr.net/npm/ckeditor4-vue@1.0.1/dist/ckeditor.min.js"></script>

    <script>
        Vue.use(CKEditor)
        new Vue({
            el: "#app",
            data: {
                editorConfig: {
                    extraPlugins: 'colorbutton'
                },
                pollName: "{{ $poll->name }}",
                startDate: "{{ date("Y-m-d", strtotime($poll->start_date)) }}",
                endDate: "{{ date("Y-m-d", strtotime($poll->end_date)) }}",
                questions: {!! json_encode($poll->questions) !!},
                token: "{{ csrf_token() }}",
                working: false
            },
            methods: {
                removeQuestion(idx) {
                    confirmDelete("Are you sure you want to DELETE the question", "Confirm Question Delete").then(confirmation=>{
                    if(confirmation){
                        this.questions.splice(idx, 1);
                    }
                });
                },
                shift(direction, idx) {
                    let questions = [...this.questions]
                    let a, b;
                    switch (direction) {
                        case 'up':
                            a = questions[idx]
                            b = questions[idx - 1]
                            questions[idx] = b
                            questions[idx - 1] = a
                            break;
                        case 'down':
                            a = questions[idx]
                            b = questions[idx + 1]
                            questions[idx] = b
                            questions[idx + 1] = a
                            break;
                    }
                    this.questions = questions
                },
                save() {
                    let data = {
                        ...this.$data
                    };
                    data._token = data.token;
                    data._method = "PUT";
                    delete data.token;

                    for (let idx = 0; idx < data.questions.length; idx++) {
                        const question = data.questions[idx];
                        if(!question.text) {
                            data.questions.splice(idx, 1);
                            continue;
                        }
                        
                        question.options = question.options.filter(v => !!v);
                        if(question.options.length == 0) {
                            alert("Question " + (idx + 1) + " has no valid options")
                            return;
                        }
                    }


                    if(data.questions.length == 0) {
                        alert("You need to create atleast one question with atleast one option")
                        this.questions.push({ text: "", options: [""] })
                        return;
                    }

                    this.working = true;
                    $.ajax({
                        url:"{{ route('poll.update.put', [ "poll" => $poll->id ]) }}",
                        method: "POST",
                        data,
                        success(response) {
                            $("#btn-save").removeAttr("disabled")
                            $("#btn-save").removeClass("disabled")
                            if (response.success) {
                                window.location = "{{ route('poll.manage') }}"
                            } else {
                                alert(response.message)
                            }
                        },

                    })
                }
            }
        })
    </script>


@endsection