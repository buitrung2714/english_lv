@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_student>thead>tr{
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
		<li class="breadcrumb-item active" aria-current="page">Student Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Student Manage</h2>
	</div>

	{{-- thông báo lỗi --}}
	@if(session()->has('error'))
	<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;">
		<p>{{ session()->get('error') }}</p>
	</div>
	@endif
	{{-- thông báo thành công --}}
	@if(session()->has('success'))
	<div class="alert alert-success" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
		<p>{{ session()->get('success') }}</p>
	</div>
	@endif

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_student">
				<thead>
					<tr>
						<th>No</th>
						<th>Email</th>
						<th>Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@php $i = 0 @endphp
					@foreach($students as $student)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $student->student_email }}</td>
						<td>{{ $student->student_name }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $student->student_id }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							@if($student->student_status == 1)
								<a data-url="{{ URL::to('/admin/lock-student/'.$student->student_id.'/0') }}" class="btn-lg btn-danger update_status">
										<i class="fa fa-unlock"></i>		
								</a>
							@else
								<a data-url="{{ URL::to('/admin/lock-student/'.$student->student_id.'/1') }}" class="btn-lg btn-danger update_status">	
										<i class="fa fa-lock"></i>
								</a>
							@endif

							{{-- <a href="{{ URL::to('/admin/delete-student/'.$student->student_id) }}" class="btn-lg btn-secondary" onclick="return confirm('Are you sure?')" style="margin-left:5px"><i class="glyphicon glyphicon-trash"></i></a> --}}
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
						<div class="modal-body"></div>
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

			<script>

				$('.update_status').click(function(){
						url = $(this).data('url');
						if ($(this).html().trim() == '<i class="fa fa-unlock"></i>') {
							status = 'unlock student?';
						}else{
							status = 'lock student?';
						}

						Swal.fire({
							icon: "question",
							title: 'Do you want to '+status,
							backdrop: false,
							showConfirmButton: true,
							showCancelButton: true,
							confirmButtonColor: '#00bcd4',
						}).then(function(result){
							if (result.isConfirmed) {
								window.location = url;
							}
						});
					});

				$(document).ready(function(){
					//setup token ajax
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					//datatable
					var table = $('#table_student').DataTable({
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
							$.get("{{ URL::to('/admin/get-id-student') }}/" + id,function(response){
								$('#detail').find('.modal-body').html('');
								$('#detail').modal('toggle');
								$.each(response, function(i,v){
									str = i.split("_");
									if (str[1] != 'id' && str[1] != 'password' && str[1] != 'token') {
										if (str[1] != 'status') {
											$('#detail').find('.modal-body').append(`<label>${str[1].charAt(0).toUpperCase() + str[1].slice(1)}:</label>			
							<b>${v}</b><br>`);
										}
										else{
											$('#detail').find('.modal-body').append(`<label>${str[1].charAt(0).toUpperCase() + str[1].slice(1)}:</label>			
							<b>${v == 0 ? 'Unlock' : 'Lock'}</b><br>`);
										}
									}
								})
							});
						}	
					});
				});

			</script>

			@endsection