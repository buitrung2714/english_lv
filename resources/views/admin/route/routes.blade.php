@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_routes>thead>tr{
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
		<li class="breadcrumb-item active" aria-current="page">Route Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Route Manage</h2>
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

	<a href="{{ URL::to('/admin/add-route') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<br><br>

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_routes">
				<thead>
					<tr>
						<th>No</th>
						<th>Route</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

					@foreach($routes as $key => $route)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ $route->route_name }}</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($route->created_at)) }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $route->route_id }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							@if($route->route_status != -1)
								<a href="{{ URL::to('/admin/edit-route/'.$route->route_id) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>
								
								<a data-url="{{ URL::to('/admin/status-route/'.$route->route_id.'/-1') }}" class="btn-lg btn-danger update_status"><i class="glyphicon glyphicon-off"></i></a>
								@else
								<a data-url="{{ URL::to('/admin/status-route/'.$route->route_id.'/0') }}" class="btn-lg btn-danger update_status"><i class="glyphicon glyphicon-refresh"></i></a>
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
							<table class="table table-bordered table-responsive text-center">
								<thead>
									<tr>
										<th>Structure</th>
										<th>Level</th>
									</tr>
								</thead>
								<tbody class="detailBody"></tbody>
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
				$('.update_status').click(function(){
					url = $(this).data('url');
					if ($(this).html() == '<i class="glyphicon glyphicon-off"></i>') {
						status = 'hide route?';
					}else{
						status = 'show route?';
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
					var table = $('#table_routes').DataTable({
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

							$('.detailBody').empty();
							$.get("{{ URL::to('/admin/get-id-route') }}/" + id,function(response){
								$('#detail').modal('toggle');

								$.each(response,function(i,v){
									$('.detailBody').append(`
										<tr>
											<td>${v.filter_name}</td>
											<td>${v.route_level}</td>
										</tr>
									`);
								})
							});
						}
					});
				});

			</script>

			@endsection