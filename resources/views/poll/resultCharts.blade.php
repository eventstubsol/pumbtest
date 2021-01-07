<div class="row">
    <div class="col-md-6 col-xl-6 mx-auto">
        <div class="card-header">
            <h4 class="header-title">Voters</h4>
        </div>
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                        <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $poll->votes_count }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">Votes</p>
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->
    <div class="col-md-6 col-xl-6 mx-auto">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="header-title">Non-Voters</h4>
            <button class="btn btn-primary" id="export-button">Export to CSV</button>
            <button class="btn btn-primary" onclick="window.print()">Export to PDF</button>
        </div>
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                        <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $poll->non_submitted }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">People</p>
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->
</div>
<div class="row">
    <div class="col-xl-6 mx-auto col-md-6">
        <div class="card">
            <div class="card-header">
                <h4  class="header-title">Question wise results follow</h4>
            </div>
            <div class="card-body">

            @foreach($poll->questions as $index => $question)
            @php
                $maxSelectionCount = -1;
                $correctOption = 0;
                foreach ($question->options as $option){
                    $count = count($option->vote_options);
                    if($count && $maxSelectionCount < $count){
                        $maxSelectionCount = $count;
                    }
                }
            @endphp
                        <h4 class="header-title">{{ $index + 1 }}. {!! $question->text !!}</h4>
                        <ul class="list-group">
                            @foreach($question->options as $option)
                                @php
                                    $correctOption = false;
                                    if($maxSelectionCount == count($option->vote_options)){
                                        $correctOption = true;
                                    }
                                @endphp
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $correctOption ? "list-group-item-success" : "" }}">
                                <span>
                                    <i class="{{ $correctOption ? "fe-check" : "fe-circle" }} mr-1"></i>
                                    {{$option->text}}
                                </span>
                                    <span class="badge badge-primary badge-pill">{{ count($option->vote_options) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    <hr class="my-3" />
        @endforeach
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
    <div class="col-xl-6 mx-auto col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title">
                    List of Non-Voters
                </h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($nonVoters as $nonVoter)
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span class="mr-3">
                            {{ $nonVoter['name'] }} {{ $nonVoter['last_name'] }}
                            ({{ $nonVoter['email'] }} - {{ $nonVoter['region_name'] }})
                        </span>
                        <span class="badge badge-primary badge-pill">{{ ucwords($nonVoter['type']) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    (function(){
        let exportBtn = document.querySelector("#export-button");
        exportBtn.addEventListener("click", function(){
            let rows = {!! json_encode($nonVoters) !!};
            if(rows.length){
                let keys = {};
                Object.keys(rows[0]).map(k => keys[k] = k);
                rows = [
                    keys,
                    ...rows
                ];
                let csvContent = "data:text/csv;charset=utf-8,"
                    + rows.map(e => Object.values(e).join(",")).join("\n");
                var encodedUri = encodeURI(csvContent);

                let opener = document.createElement("a")
                opener.href = encodedUri;
                opener.download = "{{ $poll->name }} (Non Voters).csv"
                opener.click()
                // window.open(encodedUri);
            }else{
                alert("Nothing to export!");
            }
        });
    })();
</script>