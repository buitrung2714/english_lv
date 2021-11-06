@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
.row{
	margin-bottom: 30px;
	border-bottom: 1px solid lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active" aria-current="page">Profile</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>PROFILE</h2>
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
					<div class="row">
						<div class="col-md-3 text-center" style="font-weight: bold;">Name:</div>
						<div class="col-md-9 text-center">
							<p>{{ $staff->staff_name }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-center" style="font-weight: bold;">Role: </div>
						<div class="col-md-9 text-center">
							<p class="role">
								@foreach($roles as $role)
								{{ $role->role_name }},
								@endforeach
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-center" style="font-weight: bold;">Email: </div>
						<div class="col-md-9 text-center">
							<p>{{ $staff->staff_email }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-center" style="font-weight: bold;">Password: </div>
						<div class="col-md-9 text-center">
							<a href="{{ URL::to('/admin/change-password/'.$staff->staff_id) }}" class="btn btn-primary">Change</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endsection

		@section('javascript')
		<script>
			$(document).ready(function(){
				str = $('.role').html().trim();
				sub = str.substring(0, str.length-1);
				$('.role').html(sub);
			});
		</script>
		@endsection