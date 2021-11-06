@extends('admin.layout.layout')
@section('admin_content')

<style>
#table_questions>thead>tr{
	background: #00bcd4;
	color: #fff;
}
.btn-secondary{
	background: #D1EA2E;
}
.btn-danger{
	background: #EE3542;
}
#excel_btn{
	float: right;
	border: none;
}
#excel_btn:hover{
	background: #333 !important;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active" aria-current="page">Question Manage</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>Question Manage</h2>
	</div>

	{{-- thông báo lỗi --}}
	@if(session()->has('error'))
	<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;">
		<p>{{ session()->get('error') }}</p>
	</div>
	@endif
	{{-- thông báo thành công --}}
	@if(session()->has('success'))
	<div class="alert alert-success success" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
		<p>{{ session()->get('success') }}</p>
	</div>
	@endif
	<a href="{{ URL::to('/admin/add-question') }}"><button class="btn-lg btn-primary" style="border:none;"><i class="glyphicon glyphicon-plus-sign"></i></button></a>
	<button class="btn-lg btn-success" id="excel_btn">IMPORT</button>
	<br><br>

	<div class="forms-grids">
		<div class="w3agile-validation">
			<table id="table_questions">
				<thead>
					<tr>
						<th>No</th>
						<th>Skill</th>
						<th>Question</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@php $i = 0 @endphp
					@foreach($questions as $question)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $question['skill_name'] }}</td>
						<td>{{ $question['question_content'] }}</td>
						<td>
							<button class="btn btn-primary" data-id="{{ $question['question_id'] }}" style="border: none;padding: 10px 16px;border-radius: 6px;"><i class="glyphicon glyphicon-eye-open"></i></button>

							<a href="{{ URL::to('/admin/edit-question/'.$question['question_id']) }}" class="btn-lg btn-secondary"><i class="glyphicon glyphicon-edit"></i></a>

							<a data-url="{{ URL::to('/admin/delete-question/'.$question['question_id']) }}" class="btn-lg btn-danger delete_question" onclick="delete_question()"><i class="glyphicon glyphicon-trash"></i></a>
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
							<label>Part:</label>			
							<b id="get_part_name_by_id"></b><br>
							<label>Title:</label>			
							<b id="get_topic_name_by_id"></b><br>
							<label>Content:</label>
							<div id="detail_audio" style="display:none;">
								<audio controls id="get_topic_audio_by_id"></audio>
							</div>
							<div id="detail_cont" style="display:none;">
								<p id="get_topic_content_by_id"></p>
							</div>
							<div id="detail_image" style="display:none;">
								<br><label>Image:</label><br>
								<img width="150" height="180" id="get_topic_image_by_id" alt="No Image">
							</div>
							<br><div id="detail_answer" style="display:none;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color:lightgrey;">Close</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			{{-- hiển thị khi sử dụng Excel --}}
			<div class="modal fade" id="excel_modal">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								<span class="sr-only">Close</span>
							</button>
							<div class="text-left">
								
							</div>
							<h4 class="modal-title text-center">Excel</h4>
						</div>
						<div class="modal-body">
							{{-- thông báo lỗi file excel --}}
							<div class="alert alert-danger err_excel" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;display: none;">
							</div>
							<label for="field-2">Method: <span class="at-required-highlight">*</span></label>
							<select name="excel_method" class="form-control">
								<option value="1">Import</option>
								<option value="2">Export</option>
							</select>
							<div id="import_excel">
								<form id="import_excel_form">

									<br><label for="field-2">Excel: <span class="at-required-highlight">*</span></label>
									<a href="{{ URL::to('/admin/use-excel') }}" class="btn-sm btn-warning" style="padding: 8px 13px;background-color: #666;"><i class="fa fa-question" style="font-size: 15px"></i></a><br><br>
									<div class="form-group">
										<input type="file" name="excel_file" class="form-control-file">
									</div>
									<button class="btn btn-primary">Uploads</button>
								</form>
							</div>
							<div id="export_excel" style="display:none">
								<form action="{{ URL::to('/admin/export-question') }}" method="post">
									@csrf
									<br>
									<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
									<div class="form-group">
										<select name="skill_export" class="form-control">
											<option value="-1" disabled selected>Chose Skill here!</option>
											@foreach($skills as $skill)
											<option value="{{ $skill->skill_id }}">{{ $skill->skill_name }}</option>
											@endforeach
										</select>
									</div>
									<label for="field-2">Part: <span class="at-required-highlight">*</span></label>
									<div class="form-group">
										<select name="part_export" class="form-control">
											<option value="-1" disabled selected>Chose Part here!</option>
										</select>
									</div>
									<label for="field-2">Level: <span class="at-required-highlight">*</span></label>
									<div class="form-group">
										<select name="level_export" class="form-control">
											@foreach($levels as $level)
											<option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
											@endforeach
										</select>
									</div>
									<button class="btn btn-primary">Downloads</button>

								</form>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" style="background-color:lightgrey;" data-dismiss="modal">Close</button>
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

			<script>
				$('.delete_question').click(function(){
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
					var table = $('#table_questions').DataTable({
						responsive: true,
						autoWidth: false,
						columnDefs: [
						{"className": "dt-center", "targets": "_all"}
						],
					});
					//chi tiết dữ liệu
					$(document).on('click','button',function(e){
						if ($(this).html() == '<i class="glyphicon glyphicon-eye-open"></i>') {
							var id = $(this).data('id');
							$.get("{{ URL::to('/admin/get-id-question') }}/" + id,function(response){
								//hiển thị chi tiết câu hỏi
								$('#detail_answer').html('');
								$('#detail').modal('toggle');
								$('#get_part_name_by_id').html(response.part_name);
								$('#get_topic_name_by_id').html(response.topic_name);
								//nếu topic có hình
								if (response.topic_image != null){
									$('#detail_image').css('display','block');		
									$('#get_topic_image_by_id').attr('src','/file/image/' + response.topic_image);
								}else{
									$('#get_topic_image_by_id').removeAttr('src');	
								}
								//nếu là kỹ năng nghe
								if (response.topic_audio != null) {
									//hiển thị
									$('#detail_audio').css('display','block');
									$('#detail_cont').css('display','none');
									$('#get_topic_audio_by_id').attr('src','/file/audio/' + response.topic_audio);
									
								//nếu là kỹ năng đọc, nói, viết
							}else{
									//hiển thị
									$('#detail_audio').css('display','none');
									$('#detail_cont').css('display','block');
									$('#get_topic_content_by_id').html(response.topic_content);
								}
								//duyệt đáp án kỹ năng nghe hoặc đọc
								if ((response.skill_name == 'Listening') || (response.skill_name == 'Reading')) {
									$('#detail_answer').css('display','block');
									//duyệt đáp án
									$.each(response[0],function(i,val){
										//nếu là đáp án đúng
										if (response[0][i].answer_true == 1) {
											$('#detail_answer').append(`<label>Answer `+(i+1)+`:</label> <b style="color:green;text-decoration:underline;">`+response[0][i].answer_content+`</b><br>`);
										}else{
											$('#detail_answer').append(`<label>Answer `+(i+1)+`:</label> `+response[0][i].answer_content+`<br>`);
										}
									});
								}else{
									$('#detail_answer').css('display','none');
								}	
							});
						}else if($(this).html() == 'IMPORT'){
							$('#excel_modal').modal('show');
				//thêm dữ liệu excel
			}else if($(this).html() == 'Uploads'){
				e.preventDefault();
				btnUpload = this;
				$.ajax({
					url: "{{ URL::to('/admin/add-question-excel') }}",
					method: "post",
					data: new FormData($('#import_excel_form')[0]),
					contentType:false,
					cache:false,
					// async:false,
					processData:false,
					beforeSend: function(response){
						$(btnUpload).prop('disabled',true);
						
						Swal.fire({
							position: 'top-end',
							toast: true,
							title: 'Please wait...',
							timer: 3000000,
							showConfirmButton: false,
						});
						Swal.showLoading()
					},
					
					success: function(response){
						
						$('.err_excel').html('');
						if (response.status == 1) {
							if (typeof response.error == "undefined") {
								const Toast = Swal.mixin({
									toast: true,
									position: 'top-end',
									showConfirmButton: false,
									confirmButtonColor: '#00bcd4',
									timer: 2000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.addEventListener('mouseenter', Swal.stopTimer)
										toast.addEventListener('mouseleave', Swal.resumeTimer)
									}
								})

								Toast.fire({
									icon: 'success',
									title: 'Updated data successfully'
								}).then(function(){
									window.location.href = '/admin/questions';
								})

							}else{
								
								const Toast1 = Swal.mixin({
									toast: true,
									position: 'top-end',
									showConfirmButton: false,
									confirmButtonColor: '#00bcd4',
									timer: 10000,
									timerProgressBar: true,
									didOpen: (toast) => {
										toast.addEventListener('mouseenter', Swal.stopTimer)
										toast.addEventListener('mouseleave', Swal.resumeTimer)
									}
								})

								Toast1.fire({
									icon: 'warning',
									title: 'The page will loading in 10s...'
								}).then(function(){
									window.location.href = '/admin/questions';
								})
								
								$.each(response.error,function(i,val){
									$('.err_excel').css('display','block');
									$('.err_excel').append(val+'<br>');
								});
							}
						}else{
							$(btnUpload).prop('disabled',false);
							Swal.close();

							if (typeof response.errors != "object") {
								$('.err_excel').css('display','block');
								$('.err_excel').html(response.errors);
							}else{
								$.each(response.errors,function(i,val){
									$('.err_excel').css('display','block');
									$('.err_excel').html(val);
								});
							}
						}
					}, 
					error: function(){
						$(btnUpload).prop('disabled',false);
						Swal.fire({
							icon: 'error',
							title: 'Import Fail!',
							backdrop: false,
							confirmButtonColor: '#00bcd4',
							showConfirmButton: true,
						})
					}
				});
					//khi nhấn export file excel 
				}else if($(this).html() == 'Downloads'){
					err = new Array();
					if ($('[name="skill_export"]').val() == null) {
						err.push('Skill');
					}

					if ($('[name="part_export"]').val() == null) {
						err.push('Part');
					}

					if ($('[name="level_export"]').val() == null) {
						err.push('Level');
					}

					if (err.length > 0) {
						e.preventDefault();
						Swal.fire({
							position: 'top-end',
							icon: 'error',
							toast: true,
							title: 'Please chose ' + err.toString() + '!',
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						});
					}else{
						setTimeout(function(){
							Swal.fire({
								icon: 'success',
								title: 'Export data successfully!',
								showConfirmButton: true,
								confirmButtonColor: '#00bcd4',
								backdrop:false
							})
						}, 1500)
					}

				}
			});
					//khi thay đổi hình thức excel
					$('[name=excel_method]').change(function(){
						if ($(this).val() == 1) {
							$('#import_excel').removeClass("animate__animated animate__fadeIn");
							$('#import_excel').addClass("animate__animated animate__fadeIn");
							$('#import_excel').css('display','block');
							$('#export_excel').css('display','none');
						}else{
							$('#export_excel').removeClass("animate__animated animate__fadeIn");
							$('#export_excel').addClass("animate__animated animate__fadeIn");
							$('#import_excel').css('display','none');
							$('#export_excel').css('display','block');
							$('[name=excel_file]').val('');
						}
					});

					//nếu thay đổi kỹ năng khi EXPORT
					$('[name="skill_export"]').change(function(){
						var id = $(this).val();

						$('[name="part_export"]').html('<option value="-1" disabled selected>Chose Part here!</option>')
						$.get("{{ URL::to('/admin/get-list-part-ques') }}/" + id, function(response){
							$.each(response,function(i,v){
								$('[name="part_export"]').append(`<option value="${response[i].part_id}">${response[i].part_name}</option>`);
							})
						});
					});
				});

			</script>

			@endsection