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
		<li class="breadcrumb-item active" aria-current="page">Topic Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Topic Manage</h2>
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
	{{-- thông báo ko tồn tại file trên gg server --}}
	@if(session()->has('fail_download'))
	<div class="alert alert-danger" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
		<p>{{ session()->get('fail_download') }}</p>
	</div>
	@endif
	<a href="{{ URL::to('/admin/add-topic') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<br><br>

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_parts">
				<thead>
					<tr>
						<th>No</th>
						<th>Skill</th>
						<th>Part</th>
						<th>Level</th>
						<th>Topic</th>				
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0 ?>
					@foreach($topics as $topics)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $topics['skill_name'] }}</td>
						<td>{{ $topics['part_name'] }}</td>
						<td>{{ $topics['level_name'] }}</td>
						<td>{{ $topics['topic_name'] }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $topics['topic_id'] }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							<a href="{{ URL::to('/admin/edit-topic/'.$topics['topic_id']) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>

							<a data-url="{{ URL::to('/admin/delete-topic/'.$topics['topic_id']) }}" class="btn-lg btn-danger delete_topic"><i class="glyphicon glyphicon-trash"></i></a>

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
							<label>Title:</label>			
							<b id="get_topic_name_by_id"></b>
							<br>
							<div id="hide_audio_detail" style="display:none;">
								<label>Audio:</label><br>			
								<audio controls id="get_topic_audio_by_id"></audio>
								<br>

								<button type="button" class="btn btn-primary" id="get_link_topic_by_id">Download</button>
								
								<br>
							</div>
							<div id="hide_text_detail" style="display:none;">
								<label>Content:</label>
								<p id="get_topic_content_by_id"></p>
							</div> 			
							<br>
							<label>Image:</label><br>
							<img alt="No Image" id="get_topic_image_by_id" width="150" height="180">			
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

			@if(session()->has('error'))
			<script>
				Swal.fire({
					title: "{{ session()->get('error') }}",
					icon: 'error',
					backdrop: false,
					showConfirmButton: true,
					confirmButtonColor: '#00bcd4',
				});
			</script>
			@endif

			@if(session()->has('fail_download'))
			<script>
				Swal.fire({
					title: "Download Fail!",
					icon: 'error',
					backdrop: false,
					showConfirmButton: true,
					confirmButtonColor: '#00bcd4',
				});
			</script>
			@endif
			
			<script>
				$('.delete_topic').click(function(){
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
							$.get("{{ URL::to('/admin/get-id-topic') }}/" + id,function(response){
								$('#detail').modal('toggle');
								//nếu là kỹ năng nghe
								if (response.topic_audio != null) {
									$('#hide_audio_detail').css('display','block');
									$('#hide_text_detail').css('display','none');
									$('#get_link_topic_by_id').attr('data-id', response.topic_id);
									$('#get_topic_audio_by_id').attr('src','/file/audio/'+response.topic_audio);
								}
								//ko là kỹ năng nghe
								else{
									$('#hide_audio_detail').css('display','none');
									$('#hide_text_detail').css('display','block');
									$('#get_topic_content_by_id').html(response.topic_content);
								}
								//nếu có hình ảnh
								if (response.topic_image != null) {
									$('#get_topic_image_by_id').attr('src','/file/image/'+response.topic_image);
								}else{
									$('#get_topic_image_by_id').removeAttr('src');
								}
								$('#get_topic_name_by_id').html(response.topic_name);
								
							});
						}
						//tải audio
						else if($(this).html() == 'Download'){
							var id_topic = $(this).attr('data-id');
							window.location = "{{ URL::to('/admin/download-audio') }}/" + id_topic;
							setTimeout(function(){
								Swal.fire({
									icon: 'success',
									title: 'Download Successfully!',
									showConfirmButton: true,
									confirmButtonColor: '#00bcd4',
									backdrop:false
								})
							}, 2000)	
							
						}
					});
				});

			</script>

			@endsection