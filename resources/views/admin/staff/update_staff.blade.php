@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/staff') }}">Staff Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE STAFF</h2>
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
					<form id="form_update" method="post" action="{{URL::to('/admin/update-staff-control/'.$staff->staff_id)}}">
						@csrf
						<input type="hidden" name="_method" value="put" />
						<div class="input-info">
							<h3>Edit Staff</h3>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" value="{{ $staff->staff_name }}" name="staff_name"class="form-control">
						</div>
						<label for="field-2">Email: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" value="{{ $staff->staff_email }}" name="staff_email"class="form-control">
						</div>
						<input type="checkbox" name="change_pass" class="form-check-input">
						<label for="field-2">Password: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="password" disabled value="{{ $staff->staff_password }}" name="staff_password"class="form-control">
						</div>
						<label for="field-2">Role: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							@foreach($data as $detail)
							<label> {{ $detail['role_name'] }} </label>
							<input type="checkbox" name="staff_role[]" value="{{ $detail['role_id'] }}" class="form-check-input" @if($detail['role_chose'] == 1) checked @endif><br>
							@endforeach
						</div>
						<p>
							<input type="submit" value="Update" class="btn btn-primary">
							{{-- <input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-default">		 --}}
						</p>
					</form>		
				</div>
			</div>
		</div>
		@endsection

		@section('javascript')
		@if(session()->has('error'))
		<script>
			Swal.fire({
				title: 'Updated Fail!',
				icon: 'error',
				backdrop: false,
				showConfirmButton: true,
				confirmButtonColor: '#00bcd4'
			})
		</script>
		@endif

			<script>
				$(document).ready(function(){
					old_pass = $('[type="password"]').val();
					//nếu chọn thay đổi password
					$('[name="change_pass"]').change(function(){
						if ($(this).is(':checked')) {
							$('[type="password"]').val('');
							$('[type="password"]').prop('disabled',false);
						}else{
							$('[type="password"]').val(old_pass);
							$('[type="password"]').prop('disabled',true);
						}
					});

					$('[type="submit"]').click(function(e){
					e.preventDefault();
					Swal.fire({
						title: 'Do you want to update?',
						icon: 'question',
						backdrop: false,
						showConfirmButton: true,
						showCancelButton: true,
						confirmButtonColor: '#00bcd4'
					}).then(function(result){
						if (result.isConfirmed) {
							$('#form_update').submit();
						}
					});
				})
				});
			</script>
		@endsection