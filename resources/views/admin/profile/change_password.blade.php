@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/profile/'.$staff->staff_id) }}">Profile</a></li>
		<li class="breadcrumb-item active" aria-current="page">Change Password</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Change Password</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
			{{-- lỗi dữ liệu --}}
			@if(session()->has('err'))
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;">
				@foreach(session()->get('err') as $error)
				@if(is_array($error))
				@foreach($error as $err)
				<li>{{ $err[0] }}</li>
				@endforeach
				@else
				<li>{{ $error }}</li>
				@endif
				@endforeach
			</div>
			@endif
			{{-- thông báo thành công --}}
			@if(session()->has('success'))
			<div class="alert alert-success" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
				<p>{{ session()->get('success') }}</p>
			</div>
			@endif

			<div class="panel panel-widget agile-validation">
				<div class="my-div">
					<form method="post" action="{{URL::to('/admin/change-password-control/'.$staff->staff_id)}}" >
						@csrf
						<input type="hidden" name="_method" value="put" />
						<div class="input-info">
							<h3>Edit Password</h3>
						</div>
						<label for="field-2">Password: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="password" name="old_password"class="form-control">
						</div>
						<label for="field-2">New Password: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="password" name="new_password"class="form-control">
						</div>
						<label for="field-2">Confirm: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="password" name="confirm_password"class="form-control">
						</div>
						<p>
							<input type="submit" value="Save" class="btn btn-primary">
							<input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-default">		
						</p>
					</form>
				</div>
			</div>
		</div>
		@endsection
