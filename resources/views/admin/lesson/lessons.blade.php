@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_lesson>thead>tr{
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
		<li class="breadcrumb-item active" aria-current="page">Lesson Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Lesson Manage</h2>
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

	<a href="{{ URL::to('/admin/add-lesson') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<br><br>

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_lesson">
				<thead>
					<tr>
						<th>No</th>
						<th>Structure</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@php $i = 0 @endphp
					@foreach($data as $detail)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $detail['filter_name'] }}</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($detail['date'])) }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $detail['lesson_id'] }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-print"></i></button>

							
							@if($detail['status'] == -1)
							<a data-url="{{ URL::to('/admin/status-lesson/'.$detail['lesson_id'].'/1') }}" class="btn-lg btn-danger update_status"><i class="glyphicon glyphicon-refresh"></i></a>
							@else
							<a href="{{ URL::to('/admin/edit-lesson/'.$detail['lesson_id']) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>

							<a data-url="{{ URL::to('/admin/status-lesson/'.$detail['lesson_id'].'/-1') }}" class="btn-lg btn-danger update_status"><i class="glyphicon glyphicon-off"></i></a>
							@endif
							

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
							<table class="table table-responsive table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Skill</th>
										<th>Part</th>
										<th>Topic</th>
										<th>Question</th>
									</tr>
								</thead>
								<tbody id="insert_data" class="text-center"></tbody>
							</table>
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
				$(document).ready(function(){

					$('.update_status').click(function(){
						url = $(this).data('url');
						if ($(this).html() == '<i class="glyphicon glyphicon-off"></i>') {
							status = 'hide lesson?';
						}else{
							status = 'show lesson?';
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

					//datatable
					var table = $('#table_lesson').DataTable({
						responsive: true,
						autoWidth: false,
						columnDefs: [
						{"className": "dt-center", "targets": "_all"}
						],
					});
					//chi tiết dữ liệu
					$('button').click(function(){
						if ($(this).html() == '<i class="glyphicon glyphicon-print"></i>') {
							var id = $(this).data('id');
							window.location = "{{ URL::to('/admin/get-id-lesson') }}/"+id;
							
						}
					});
				});

			</script>

			@endsection