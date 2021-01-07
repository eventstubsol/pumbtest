@extends("layouts.admin")

@section('title')
Create Users
@endsection

@section("page_title")
Create Users
@endsection

@section("breadcrumbs")
<li class="breadcrumb-item"><a href="{{ route("user.index") }}">Users</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p class="text-right mb-3">
                    <input accept=".json" type="file" hidden id="fileUpload">
                    <button class="btn btn-primary" id="btnFileUpload"><i class="fe-upload-cloud mr-1"></i> Bulk
                        Upload</button>
                </p>
                <form action="{{ route("user.store") }}" method="post" id="userForm">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input autofocus required value="{{ old('name') }}" type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input id="email" required value="{{ old('email') }}" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input id="password" required name="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="user-type">Type of User</label>
                        <select class="form-control" id="user-type" name="type">
                            @foreach(USER_TYPES as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>

                </form>
                <div id="uploader-progress" style="display: none">
                    <h3>Creating Users</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function csvTojs(csv) {
            var lines=csv.split("\n");
            var result = [];
            var headers = lines[0].split(",");

        for(var i=1; i<lines.length; i++) {
            var obj = {};

            var row = lines[i],
            queryIdx = 0,
            startValueIdx = 0,
            idx = 0;

            if (row.trim() === '') { continue; }

            while (idx < row.length) {
            /* if we meet a double quote we skip until the next one */
            var c = row[idx];

            if (c === '"') {
                do { c = row[++idx]; } while (c !== '"' && idx < row.length - 1);
            }

            if (c === ',' || /* handle end of line with no comma */ idx === row.length - 1) {
                /* we've got a value */
                var value = row.substr(startValueIdx, idx - startValueIdx).trim();

                /* skip first double quote */
                if (value[0] === '"') { value = value.substr(1); }
                /* skip last comma */
                if (value[value.length - 1] === ',') { value = value.substr(0, value.length - 1); }
                /* skip last double quote */
                if (value[value.length - 1] === '"') { value = value.substr(0, value.length - 1); }

                var key = headers[queryIdx++];
                obj[key] = value;
                startValueIdx = idx + 1;
            }

            ++idx;
            }

            result.push(obj);
            }
            return result;
        }

        function sleep(ms) {
            return new Promise(function(resolve) {
                setTimeout(resolve, ms)
            })
        } 
</script>
<script>
    $("#btnFileUpload").click(function (e) {
            $("#fileUpload").click()
        })

        $("#fileUpload").change(function(e) {
            
            let file = e.target.files[0]
            if (!file) return;

            $("#btnFileUpload").removeClass("btn-primary")
            $("#btnFileUpload").attr("disabled", "true")
            $("#btnFileUpload").addClass("btn-secondary")
            $("#btnFileUpload").addClass("disabled")
            $("#btnFileUpload").html('<i class="fe-upload-cloud mr-1"></i> Uploading')
            
            $("#uploader-progress").html('')
            $("#uploader-progress").append('<h3>Creating Users</h3>')
            $("#userForm").hide()
            $("#uploader-progress").show()

            let c = new FileReader();

            c.onloadend = async function (e) {
                let batches = JSON.parse(c.result);

                batches = batches
                    .map(function(user){
                        return {
                            ...user,
                            email: user.email.split(/\//gmi)[0].trim().toLowerCase()
                        }

                    })
                        .filter(v => !!v.email);

                let total = batches.length;
                let $data = []
                let i,j,k=0,chunk=10;

                for (i=0,j=batches.length; i<j; i+=chunk) {
                    $data.push(batches.slice(i,i+chunk))
                }
                batches = $data;
                delete $data;
                let flag = true;
                for (const batch of batches) {
                    window.scrollTo(0,document.body.scrollHeight);
                    $("#uploader-progress").append("<p style='font-family: monospace;'>[!] Uploading <strong>" + batch.length + "</strong> users.</p>")
                    let data = {
                        users: batch,
                        _token: '{{ csrf_token() }}'
                    }
                    let x = await new Promise(function(resolve) {
                        $.ajax({
                            url: '{{ route("users.bulk_upload") }}',
                            method: "POST",
                            data,
                            success: function(e) {
                                resolve(e)
                            },
                            error: function (e) {
                                resolve({success:false, message: e.responseJSON.message.replace(/\\r?\\n?/, ". ")})
                            }
                        })
                    })
                    
                    flag = x.success
                    if(x.success) {
                        k += batch.length
                        $("#uploader-progress").append("<p style='font-family: monospace; color: green'>[#] Done <strong>" + k + "/" + total +"</strong></p>")
                    } else {
                        $("#uploader-progress").append("<p style='font-family: monospace; color: red'>[x] Error: <strong>" + x.message + "</strong></p>")
                        $("#uploader-progress").append("<p style='font-family: monospace; color: red'>[!] Please reload the page</p>")
                        break;
                    }
                }

                if (flag) {
                    $("#uploader-progress").append("<h3>All Done</h3>")
                    location.reload(true)
                } else {
                    $("#btnFileUpload").html('<i class="ti-face-sad mr-1"></i> Error')

                }
                                
            }

            c.readAsText(file)
            
        })
</script>
@endsection