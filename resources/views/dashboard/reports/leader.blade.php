@extends("layouts.admin")

@section("content")
    <div class="card">
        <div class="card-header">
            Leaderboard
        </div>
        <div class="card-body">
            <ol id="list-of-people" class="list-group"></ol>
        </div>
    </div>
@endsection


@section("scripts")
    <script>
        function showLeaderboard(inLoop = false){
            let list = $("#list-of-people");
            $.ajax({
                url: '{{ route("leaderboard") }}',
                method: "POST",
                data: { _token: '{{ csrf_token() }}' },
                success: function(leaderboard){
                    list.html(leaderboard.map(([name, points]) => {
                        return `<li class="list-group-item d-flex justify-content-between align-items-center"><span>${name}</span><span>${points} points</span></li>`;
                    }).join(""));
                },
                error: function(err){
                    if(!inLoop){
                        showMessage(
                            "Error loading the leaderboard. Please try again in some time",
                            "error"
                        );
                    }
                }
            });
        }
        showLeaderboard();
        setInterval(showLeaderboard, 5000);
    </script>
@endsection