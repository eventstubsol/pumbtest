@extends("layouts.admin")

@section('title')
    Change Password
@endsection

@section("page_title")
    Change Password
@endsection

@section("breadcrumbs")
    <li class="breadcrumb-item"><a href="/event#profile">Profile</a></li>
    <li class="breadcrumb-item active">Change Password</li>
@endsection


@section('content')
<div class="card">
    <div class="card-body">
	    <form action="{{ route("updatePassword") }}" method="post">
	    	@csrf
	    	 <div class="form-group mb-3">
	            <label for="oldpassword">Old Password</label>
	            <input autofocus type="password" id="oldpassword" name="oldpassword" class="form-control  @error('oldpassword') is-invalid @enderror" required>
	            @error('oldpassword')
		            <span class="invalid-feedback" role="alert">
		                <strong>{{ $message }}</strong>
		            </span>
	            @enderror
	        </div>
	        <div class="form-group mb-3">
	            <label for="newpassword">New Password</label>
	            <input autofocus type="password" id="newpassword" name="newpassword" class="form-control  @error('newpassword') is-invalid @enderror" required>
	            @error('newpassword')
		            <span class="invalid-feedback" role="alert">
		                <strong>{{ $message }}</strong>
		            </span>
	            @enderror
	        </div>	
	        <div class="form-group mb-3">
	            <label for="confirmnew">Confirm New Password</label>
	            <input autofocus type="password" id="confirmnew" name="confirmnew" class="form-control mb-2  @error('confirmnew') is-invalid @enderror" required>
	             <span id="pass-error" class="text-danger mt-2">
		                <strong></strong>
	            </span>
	            @error('confirmnew')
		            <span class="invalid-feedback" role="alert">
		                <strong>{{ $message }}</strong>
		            </span>
	            @enderror
	        	@error('passmismatch')
		            <span class="text-danger mt-2">
		                <strong>{{ $message }}</strong>
		            </span>
	            @enderror
	            @error('success')
		            <span class="text-success mt-2" role="alert">
		                <strong>{{ $message }}</strong>
		            </span>
	            @enderror	
	        </div>
	       


	        <input class="btn btn-primary" id="submit" type="Submit" value="Submit">	
		</form>
	</div>
</div>

@endsection

@section("scripts")
<script type="text/javascript">
	$(document).ready(function () {
		$("#submit").on("click",function(e){
			if($("#newpassword").val()!=$("#confirmnew").val()){
				e.preventDefault();
				$("#pass-error").html("The New Password and Confirm Password don't match");
			}
		});
	});
</script>
	
@endsection