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
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE LEVEL</h2>
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

			<div class="panel panel-widget agile-validation">
				<div class="my-div">				
					<form id="form_update" method="post" action="{{URL::to('/admin/update-level-control/'.$level->level_id)}}">
						@csrf
						<input type="hidden" name="_method" value="put" />
						<div class="input-info">
							<h3>Edit Level</h3>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="level_name" value="{{ $level->level_name }}" class="form-control">
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
		</script>
		@endsection
