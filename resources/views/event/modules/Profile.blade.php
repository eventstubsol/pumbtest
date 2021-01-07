<div class="page has-padding padding-medium" id="profile">
	@php
		$user = Auth::user();
	@endphp
	<!-- ============================================================== -->
	<!-- Start Page Content here -->
	<!-- ============================================================== -->
	<div class="content">
		<div id="profile-app"></div>
		<!-- Start Content-->
	</div>
	<!-- ============================================================== -->
	<!-- End Page content -->
	<!-- ============================================================== -->

{{--    <form class="profile-card">--}}
{{--		<div class="p-header"></div>--}}
{{--		<div class="p-body">--}}
{{--			<div class="pic" data-toggle="modal" data-target="#profile-modal">--}}
{{--				<img src="{{isset($user->profileImage)?assetUrl($user->profileImage):''}}" alt="{{$user->name}}">--}}
{{--			</div>--}}
{{--			<div class="p-info">--}}
{{--				<p class="name">{{$user->name}}</p>--}}
{{--				<span class="email">{{$user->email}}</span>--}}
{{--				<span class="points">				<b>Treasure Hunt Points</b><br/>{{$user->points}}</span>--}}
{{--				@if($user->type=="admin" || $user->type=="exhibiter")--}}
{{--					<a class="password" href="/changepassword">Change Password</a>--}}
{{--				@endif--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</form>	--}}
</div>
<div class="modal fade" id="view-profile-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h4 class="modal-title" id="myCenterModalLabel">Member Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body p-0" id="profile-detail-view">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--<div class="modal fade profile-modal" id="profile-modal" tabindex="-1" role="dialog">--}}
{{--    <div class="modal-dialog modal-sm">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h4>Upload New Profile Pic</h4>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--				<div class="image-uploader profilepic">--}}
{{--					<input type="hidden" id="profileurl" class="upload_input" name="profileimage" value="" >--}}
{{--					<input accept="images/*" type="file" data-name="imageurl" data-plugins="dropify" data-type="image" data-default-file="" />--}}
{{--				</div>--}}
{{--				<button class="btn btn-primary m-3" id="saveprofile">Save</button>--}}
{{--            </div>--}}
{{--        </div><!-- /.modal-content -->--}}
{{--    </div><!-- /.modal-dialog -->--}}
{{--</div><!-- /.modal -->--}}