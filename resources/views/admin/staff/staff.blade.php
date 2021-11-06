@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_staff>thead>tr{
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
		<li class="breadcrumb-item active" aria-current="page">Staff Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Staff Manage</h2>
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

	<a href="{{ URL::to('/admin/add-staff') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<br><br>
	
	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_staff">
				<thead>
					<tr>
						<th>No</th>
						<th>Role</th>
						<th>Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@php $i = 0 @endphp
					@foreach($data as $detail)
					<tr>
						<td>{{ ++$i }}</td>
						<td class="role_staff">
							@foreach($detail as $key => $roles)
							@if(is_array($roles))

							{{-- nếu có gv --}}
							@php
								if ($roles['role_name'] != 'Teacher') {
									$k = $key;
								}
							@endphp

							{{ $roles['role_name'] }},
							@endif
							@endforeach
						</td>
						<td>{{ $detail['staff_name'] }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $detail['staff_id'] }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							@if((Auth::id() != $detail['staff_id']) && isset($k))
							<a href="{{ URL::to('/admin/imper-staff/'.$detail['staff_id']) }}" class="btn-lg btn-success"><i class="glyphicon glyphicon-retweet"></i></a>
							@endif
							<a href="{{ URL::to('/admin/edit-staff/'.$detail['staff_id']) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>

							@if(Auth::id() != $detail['staff_id'])
							<a data-url="{{ URL::to('/admin/delete-staff/'.$detail['staff_id']) }}" class="btn-lg btn-danger delete_staff"><i class="glyphicon glyphicon-trash"></i></a>
							@endif
						</td>
					</tr>
					@php unset($k) @endphp
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
							<label>Name:</label>			
							<b id="get_staff_name_by_id"></b>
							<br><label>Email:</label>			
							<b id="get_staff_email_by_id"></b>
							<br><label>Role:</label>			
							<b id="get_staff_role_by_id"></b>
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

			<script>

				$('.delete_staff').click(function(){
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
					var table = $('#table_staff').DataTable({
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
							//reset
							$('#get_staff_name_by_id').html('');
							$('#get_staff_email_by_id').html('');
							$('#get_staff_role_by_id').html('');
							
							$.get("{{ URL::to('/admin/get-id-staff') }}/" + id,function(response){
								$('#detail').modal('toggle');
								$.each(response, function(i,v){
									$('#get_staff_name_by_id').html(response.staff_name);
									$('#get_staff_email_by_id').html(response.staff_email);
									if (typeof response[i] == "object") {
										$('#get_staff_role_by_id').append(response[i].role_name+', ');
									}
								});
								str = $('#get_staff_role_by_id').html().trim();
								last_str = str.substring(0, str.length-1);
								$('#get_staff_role_by_id').html(last_str);
							});
						}	
					});

					$('.role_staff').each(function(i,v){
						str = $(this).html().trim();
						last_str = str.substring(0, str.length-1);
						$(this).html(last_str);
					});
				});

			</script>

			@endsection