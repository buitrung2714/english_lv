@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_skills>thead>tr{
	background: #00bcd4;
	color: #fff;
}
.btn-secondary{
	background: #D1EA2E;
}
.btn-danger{
	background: #EE3542;
}

</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active" aria-current="page">Skills Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Skills Manage</h2>
	</div>

	{{-- thông báo thành công --}}
	@if(session()->has('success'))
	<div class="alert alert-success" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
		<p>{{ session()->get('success') }}</p>
	</div>
	@endif
	{{-- thông báo thất bại --}}
	@if(session()->has('fail'))
	<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;">
		<p>{{ session()->get('fail') }}</p>
	</div>
	@endif

	<a href="{{ URL::to('/admin/add-skill') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<br><br>

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_skills">
				<thead>
					<tr>
						<th>No</th>
						<th>Skill</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0 ?>
					@foreach($skills as $skills)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $skills->skill_name }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $skills->skill_id }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							<a href="{{ URL::to('/admin/edit-skill/'.$skills->skill_id) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>

							<a data-url="{{ URL::to('/admin/delete-skill/'.$skills->skill_id) }}" class="btn-lg btn-danger delete_skill" ><i class="glyphicon glyphicon-trash"></i></a>

						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			{{-- hiển thị thông tin chi tiết --}}
			<div class="modal fade" id="detail">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								<span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title text-center">Details</h4>
						</div>
						<div class="modal-body">				
							<label>Skill:</label>			
							<b id="get_skill_name_by_id"></b>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

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

			@if(session()->has('fail'))
				<script>
					Swal.fire({
						title: "{{ session()->get('fail') }}",
						icon: 'error',
						backdrop: false,
						showConfirmButton: true,
						confirmButtonColor: '#00bcd4',
					});
				</script>
			@endif

			<script>
				$('.delete_skill').click(function(){
					url = $(this).data('url');
						Swal.fire({
							title: "Do you want to delete?",
							icon: 'question',
							backdrop: false,
							showConfirmButton: true,
							showCancelButton: true,
							confirmButtonColor: '#00bcd4'
						}).then(function(result){
							if (result.isConfirmed) {
								window.location = url;
							}
						});
					})

				$(document).ready(function(){
					//setup token ajax
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					//datatable
					var table = $('#table_skills').DataTable({
						responsive: true,
						autoWidth: false,
						columnDefs: [
						{"className": "dt-center", "targets": "_all"}
						],
					});
					//chi tiết dữ liệu
					$('button').click(function(){
						if ($(this).html() == '<i class="glyphicon glyphicon-eye-open"></i>') {
							var id = $(this).data('id');
							$.get("{{ URL::to('/admin/get-id-skill') }}/" + id,function(response){
								$('#get_skill_name_by_id').html(response.skill_name);
								$('#detail').modal('toggle');
							});
						}
					});
				});

			</script>

			@endsection