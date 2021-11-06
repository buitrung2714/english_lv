@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/levels') }}">Level Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Add</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>ADD LEVEL</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
			{{-- lỗi trùng dữ liệu --}}
			@if(session()->has('error'))
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;">
				@foreach(session()->get('error') as $error)
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
					<form method="post" action="{{URL::to('/admin/add-level-control')}}" >
						@csrf
						<div class="input-info">
							<h3>Input Level</h3>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="level_name"class="form-control">
						</div>

						<p>
							<input type="submit" value="Add" class="btn btn-primary">
							{{-- <input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-default">		 --}}
						</p>
					</form>
				</div>
			</div>
		</div>
		@endsection

		@section('javascript')
			@if(session()->has('success'))
				<script>
					Swal.fire({
						title: "OK",
						icon: 'success',
						backdrop: false,
						showConfirmButton: true,
						confirmButtonColor: '#00bcd4',
					});
				</script>
			@endif

			@if(session()->has('error'))
				<script>
					Swal.fire({
						title: "Insert Fail!",
						icon: 'error',
						backdrop: false,
						showConfirmButton: true,
						confirmButtonColor: '#00bcd4',
					});
				</script>
			@endif
		@endsection
