@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_parts>thead>tr{
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
		<li class="breadcrumb-item active" aria-current="page">Part Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Part Manage</h2>
	</div>

	{{-- thông báo thành công --}}
	@if(session()->has('success'))
	<div class="alert alert-success" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
		<p>{{ session()->get('success') }}</p>
	</div>
	@endif
	{{-- thông báo thành công --}}
	@if(session()->has('fail'))
	<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;">
		<p>{{ session()->get('fail') }}</p>
	</div>
	@endif

	<a href="{{ URL::to('/admin/add-part') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<br><br>

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_parts">
				<thead>
					<tr>
						<th>No</th>
						<th>Skill</th>
						<th>Part</th>
						<th>Ordinal numbers</th>
						<th>Amount Question</th>					
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0 ?>
					@foreach($parts as $parts)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $parts['skill_name'] }}</td>
						<td>{{ $parts['part_name'] }}</td>
						<td>{{ $parts['part_no'] }}</td>
						<td>{{ $parts['part_amount_ques_per_topic'] }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $parts['part_id'] }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							<a href="{{ URL::to('/admin/edit-part/'.$parts['part_id']) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>

							<a data-url="{{ URL::to('/admin/delete-part/'.$parts['part_id']) }}" class="btn-lg btn-danger delete_part"><i class="glyphicon glyphicon-trash"></i></a>

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
							<br>
							<label>Part:</label>			
							<b id="get_part_name_by_id"></b>
							<br>
							<label>Ordinal Numbers:</label>			
							<b id="get_part_no_by_id"></b>
							<br>
							<label>Amount Question / Topic:</label>			
							<b id="get_part_amount_by_id"></b>
							<br>
							<label>Topic Max:</label>			
							<b id="get_part_topic_max_by_id"></b>
							<br>
							<div id="show_part_des" style="display:none;">
								<label>Description:</label>			
								<b id="get_part_des_by_id"></b>
							</div>
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
					$('.delete_part').click(function(){
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
					var table = $('#table_parts').DataTable({
						responsive: true,
						autoWidth: false,
						columnDefs: [
						{"className": "dt-center", "targets": "_all"}
						],
					});
					//chi tiết dữ liệu
					$(document).on('click','button',function(){
						if ($(this).html() == '<i class="glyphicon glyphicon-eye-open"></i>') {
							var id = $(this).data('id');
							$.get("{{ URL::to('/admin/get-id-part') }}/" + id,function(response){
								$('#detail').modal('toggle');
								$('#get_skill_name_by_id').html(response[0].skill_name);
								$('#get_part_name_by_id').html(response[0].part_name);
								$('#get_part_amount_by_id').html(response[0].part_amount_ques_per_topic);
								$('#get_part_no_by_id').html(response[0].part_no);
								$('#get_part_topic_max_by_id').html(response[0].part_topic_max);

								if (response[0].part_des != null) {
									$('#get_part_des_by_id').html(response[0].part_des);
									$('#show_part_des').css('display','block');
								}else{
									$('#show_part_des').css('display','none');
								}
							});
						}
					});
				});

			</script>

			@endsection