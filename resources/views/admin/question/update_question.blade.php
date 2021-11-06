@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
.btn.btn-default[role=combobox]{
	width: 100%;
	background: #FFF;
	border: 1px solid #C6CAD2;
	color: black;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/questions') }}">Question Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE QUESTION</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
			{{-- thông báo lỗi validate --}}
			@if($errors->any())
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold; list-style: none;">
				@foreach($errors->all() as $err)
				<li>{{ $err }}</li>
				@endforeach
			</div>
			@endif
			{{-- lỗi validate dữ liệu --}}
			@if(session()->has('error'))
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;">
				@php
				$code = json_encode(session()->get('error'));
				$err_array = json_decode($code,true);
				@endphp
				@foreach($err_array as $key => $err_array)
				{{-- nếu có mảng lỗi validate đáp án --}}
				@if(is_array($err_array))
				@foreach($err_array as $err)
				@if(count($err) > 0)
				@foreach($err as $errs)
				{{-- lỗi validate đáp án --}}
				@if(is_array($errs))
				<li>{{ $errs[0] }}</li>
				{{-- lỗi validate dữ liệu --}}
				@else
				<li>{{ $errs }}</li>
				@endif
				@endforeach
				@endif
				@endforeach
				{{-- nếu lỗi ràng buộc --}}
				@else
				<li>{{ $err_array }}</li>
				@endif	
				@endforeach
			</div>
			@endif
			{{-- xoá đáp án thành công--}}
			@if(session()->has('success'))
			<div class="alert alert-success" style="background-color: #C6F5D5; color: green;font-size: 14px;font-weight: bold;">
				<p>{{ session()->get('success') }}</p>
			</div>
			@endif
			<div class="panel panel-widget agile-validation">
				<div class="my-div">				
					<form id="form_update" method="post" action="{{URL::to('/admin/update-question-control/'.$question->question_id)}}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="_method" value="put" />
						<div class="input-info">
							<h3>Edit Question</h3>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="skill_id" disabled class="form-control">
								<option value="{{ $skill->skill_id }}" selected>{{ $skill->skill_name }}</option>
							</select>
						</div>
						<label for="field-2">Part: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="part_id" class="form-control">
								@foreach($parts as $parts)
								<option value="{{ $parts->part_id }}"@if($parts->part_id == $part->part_id) selected @endif>{{ $parts->part_name }}</option>
								@endforeach
							</select>
						</div>

						<select name="topic_method">
							<option value="1">Available</option>
							<option value="2">New</option>
						</select>
						<div id="available">
							<label for="field-2">Topic: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<select name="topic_id" data-live-search="true" class="form-control">
									@foreach($topics as $topics)
									<option value="{{ $topics->topic_id }}"@if($topics->topic_id == $question->topic_id) selected @endif>{{ $topics->topic_name }}</option>
									@endforeach
								</select>
								<div id="show_topic">
									<br><button type="button"class="btn btn-primary" style="background-color:#666;">Edit</button>
								</div>
							</div>
						</div>

						<div id="new" style="display:none;">
							<label for="field-2">Title: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<input type="text" name="topic_name" class="form-control">
							</div>
							<label for="field-2">Level: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<select name="level_id" class="form-control">
									<option value="">Chose level here</option>
									@foreach($levels as $levels)
									<option value="{{ $levels->level_id }}">{{ $levels->level_name }}</option>
									@endforeach
								</select>
							</div>

							<div id="new_audio" style="display:none;">
								<label for="field-2">Audio: <span class="at-required-highlight">*</span></label>
								<div class="form-group">
									<input type="file" name="topic_audio" class="form-control-file">
								</div>						
							</div>

							<div id="new_content" style="display:none;">
								<label for="field-2">Content: <span class="at-required-highlight">*</span></label>
								<div class="form-group">
									<textarea name="topic_content"></textarea>
								</div>
							</div>	

							<label for="field-2">Image: <span class="at-required-highlight"></span></label>
							<div class="form-group">
								<input type="file" name="topic_image" class="form-control-file">
							</div>
						</div>

						<label for="field-2">Question: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="question_content" value="{{ $question->question_content }}" class="form-control">
						</div>
						<label for="field-2">Mark: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="number" step="0.25" min="0" name="question_mark" value="{{ $question->question_mark }}" class="form-control">
						</div>
						@if(($skill->skill_name == 'Listening') || ($skill->skill_name == 'Reading'))
						{{-- <button type="button" class="btn btn-primary">Add Answer</button><br> --}}
						@foreach($answers as $key => $answer)
						<div class="count_ans">
							
							@if($answer->answer_true == 1)
							<br><input type="radio" name="answer_true" value="{{ $answer->answer_id }}"checked>
							@else
							<br><input type="radio" name="answer_true" value="{{ $answer->answer_id }}">
							@endif
							
							{{-- <input type="hidden" value="0" name="answer_true[]"/> --}}
							<label>Answer {{ $key+1 }}: </label>
							<input type="hidden" name="answer_id[]" value="{{ $answer->answer_id }}">
							<input type="text" name="answer_content[]" class="form-control" value="{{ $answer->answer_content }}">
							{{-- <a data-url="{{ URL::to('/admin/update-answer/'.$answer->answer_id) }}" class="btn-sm btn-danger delete_answer" style="padding: 11px 13px;background: red;"><i class="glyphicon glyphicon-trash"></i></a> --}}
						</div>
						@endforeach
						{{-- <div id="add_answer"></div>	 --}}
						<br><br>
						@endif
						<p>
							<button type="submit" class="btn btn-primary">Update</button>
							{{-- <input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-default">		 --}}
						</p>
					</form>		
				</div>
			</div>
		</div>

		{{-- chỉnh sửa thông tin chủ đề  --}}
		<div class="modal fade" id="edit_topic">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title text-center">Edit Topic</h4>
					</div>
					<div class="alert alert-danger error_edit" style="color:red;background-color:#F2D4D8;display: none;"></div>
					<form id="edit_topic_form">
						<div class="modal-body">
							<label for="field-2">Title: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<input type="text" name="topic_name_edit" class="form-control">
							</div>
							<label for="field-2">Level: <span class="at-required-highlight">*</span></label>
							<div class="form-group">			
								<select name="level_id_edit" class="form-control">
									@foreach($levels_edit as $level)
									<option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
									@endforeach
								</select>
							</div>
							<div id="edit_topic_content" style="display:none">
								<label for="field-2">Content: <span class="at-required-highlight">*</span></label>
								<div class="form-group">
									<textarea name="topic_content" id="topic_content_edit"></textarea>
								</div>
							</div>
							<div id="edit_topic_audio" style="display:none;">
								<br>
								<select name="edit_audio">
									<option value="1">No Action</option>
									<option value="2">Change</option>
								</select>
								<label for="field-2">Audio: <span class="at-required-highlight">*</span></label>
								<div class="form-group">
									<br><audio controls></audio>
									<input type="file" name="topic_audio_edit" disabled class="form-control-file"><br>
								</div>
							</div>
							<br>
							<select name="edit_image">
								<option value="1">No Action</option>
								<option value="2">Change</option>
								<option value="3">Remove</option>
							</select>
							<label for="field-2">Image: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<br><img alt="No Image" id="get_image_topic" width="150" height="180">
								<input type="file" name="topic_image_edit" disabled class="form-control-file">
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</form>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		@endsection

		@section('javascript')
		@if(session()->has('success'))
		<script>
			Swal.fire({
				title: 'OK',
				icon: 'success',
				backdrop: false,
				showConfirmButton: true,
				confirmButtonColor: '#00bcd4'
			})
		</script>
		@endif

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

				$('.delete_answer').click(function(){
					url = $(this).data('url');
					Swal.fire({
						title: 'Do you want to delete?',
						icon: 'question',
						backdrop: false,
						showConfirmButton: true,
						showCancelButton: true,
						confirmButtonColor: '#00bcd4',
					}).then(function(result){
						if(result.isConfirmed){
							window.location = url;
						}
					})
				})

				//setup token ajax
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$('[name=topic_id]').selectpicker();
		 		//tinyMCE (quản lý soạn thảo văn bản cho thẻ <textarea>)
		 		tinymce.init({
		 			selector: '[name=topic_content]',
		 			plugins: [
		 			'advlist autolink lists link image charmap print preview anchor',
		 			'searchreplace visualblocks code fullscreen',
		 			'insertdatetime media table paste code help wordcount',
		 			],
		 			toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
		 			height: 250,
				  // enable title field in the Image dialog
				  image_title: true, 
				  // enable automatic uploads of images represented by blob or data URIs
				  automatic_uploads: true,
				  // add custom filepicker only to Image dialog
				  file_picker_types: 'image',
				  file_picker_callback: function(cb, value, meta) {
				  	var input = document.createElement('input');
				  	input.setAttribute('type', 'file');
				  	input.setAttribute('name', 'file_tinymce');
				  	input.setAttribute('accept', 'image/*');

				  	input.onchange = function() {
				  		var file = this.files[0];
				  		var reader = new FileReader();

				  		reader.onload = function () {
				  			var id = 'blobid' + (new Date());
				  			var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
				  			var base64 = reader.result.split(',')[1];
				  			var blobInfo = blobCache.create(id, file, base64);
				  			blobCache.add(blobInfo);

				        // call the callback and populate the Title field with the file name
				        cb(blobInfo.blobUri(), { title: file.name });
				    };
				    reader.readAsDataURL(file);
				};

				input.click();
			}
		});
		 	//thay đổi hình thức thêm chủ đề
		 	$('[name=topic_method]').change(function(){
		 		//nếu chọn topic có sẵn
		 		if ($(this).val() == 1) {
		 			$('#available').removeClass("animate__animated animate__fadeIn");
		 			$('#available').addClass("animate__animated animate__fadeIn");
		 			$('#available').css('display','block');
		 			$('#new').css('display','none');
		 			//reset giá trị
		 			var val = $('[name=topic_id] option:first-child').val();
		 			$('[name=topic_id]').val(val);
		 			$('[name=topic_id]').selectpicker('refresh');
		 			$('[name=topic_name]').val('');
		 			$('[name=topic_audio]').val('');
		 			$('[name=level_id]').val('');
		 			$('[name=topic_image]').val('');
		 			tinymce.activeEditor.setContent('');
		 		//nếu chọn thêm topic mới
		 	}else{
		 		$('#new').removeClass("animate__animated animate__fadeIn");
		 		$('#new').addClass("animate__animated animate__fadeIn");
		 		$('#available').css('display','none');
		 		$('#new').css('display','block');
		 		//reset
		 		$('[name=topic_id]').val('default');
		 		$('[name=topic_id]').selectpicker('refresh');

		 		if ($('[name="level_id"] option').length == 1) {
		 			Swal.fire({
		 				icon: 'error',
		 				title: 'Please insert Level!',
		 				backdrop: false,
		 				showConfirmButton: true,
		 				confirmButtonColor: '#00bcd4',
		 			}).then(function(result){
		 				if (result.isConfirmed) {
		 					window.location = "{{ URL::to('/admin/add-level') }}"
		 				}
		 			});
		 		}
		 	}
		 })
		 	//xác định kỹ năng
		 	var id = $('[name=skill_id] option:first-child').val();
		 	$.get("{{ URL::to('/admin/get-skill-ques') }}/" + id,function(response){
		 		//nếu là kỹ năng nghe
		 		if(response.skill_name == 'Listening'){
		 			$('#new_audio').css('display', 'block');
		 			$('#new_content').css('display','none');
		 		}else{
		 			$('#new_audio').css('display', 'none');
		 			$('#new_content').css('display','block');
		 		}
		 		//load danh sách topic khi thay đổi part
		 		$('[name=part_id]').change(function(){
		 			var id = $(this).val();
		 			$('[name=topic_id]').html('');
		 			$('[name=topic_id]').selectpicker('refresh');
		 			$.get("{{ URL::to('/admin/get-list-topic-ques') }}/" + id, function(response_part){
		 				//nếu có audio rỗng cả part hoặc part ko có audio
		 				if (response_part.length == 0) {
		 					$('#show_topic').css('display','none');
		 				}else{
		 					$('#show_topic').removeClass("animate__animated animate__fadeIn");
		 					$('#show_topic').addClass("animate__animated animate__fadeIn");
		 					$('#show_topic').css('display','block');
		 				}
		 				//duyệt danh sách topic lấy được 		
		 				$.each(response_part, function(i,val){
		 					$('[name=topic_id]').append(`<option value="`+response_part[i].topic_id+`">`+response_part[i].topic_name+`</option>`);
		 				});
		 				var val = $('[name=topic_id] option:first-child').val();
		 				$('[name=topic_id]').val(val);
		 				$('[name=topic_id]').selectpicker('refresh');
		 				$('[name=topic_id]').selectpicker('refresh');
		 			});
		 		});
		 		//xem chi tiết topic
		 		$(document).on('click','button',function(e){
		 			if ($(this).html() == 'Edit') {
		 				var id = $('[name=topic_id]').val();
		 			//lấy thông tin chi tiết chủ đề
		 			$.get("{{ URL::to('/admin/get-detail-topic-ques') }}/" + id, function(response_topic){		
		 				$('#edit_topic').modal('show');
		 				$('[name=topic_name_edit]').val(response_topic.topic_name);
		 				$('[name=level_id_edit]').val(response_topic.level_id
		 					);
		 				//nếu có hình ảnh
		 				if (response_topic.topic_image != null) {
		 					$('#get_image_topic').attr('src','/file/image/' + response_topic.topic_image);
		 					$('[name=edit_image]').find('option[value=3]').removeAttr('disabled');
		 				}else{
		 					$('#get_image_topic').removeAttr('src');
		 					$('[name=edit_image]').find('option[value=3]').attr('disabled','disabled');
		 				}
		 				//nếu là kỹ năng nghe
		 				if (response_topic.topic_audio != null) {
		 					$('#edit_topic_audio').css('display','block');
		 					$('#edit_topic_content').css('display','none');
		 					$('[name=level_id_edit]').val(response_topic.level_id);
		 					$('#edit_topic_audio audio').attr('src','/file/audio/' + response_topic.topic_audio);

		 				 //kỹ năng đọc, nói, viết	
		 				}else{
		 					$('#edit_topic_audio').css('display','none');
		 					$('#edit_topic_content').css('display','block');
		 					tinymce.activeEditor.setContent(response_topic.topic_content);
		 					$('[name=topic_content]').html(tinymce.activeEditor.getContent());
		 				}
		 			});
		 		//nếu thêm đáp án
		 // 	}
		 // 	else if($(this).html() == 'Add Answer'){
		 // 		var count_ans = $('.count_ans').size();
		 // 		var size_add_ans = $('.del').size();
		 // 			//nếu đã đủ 4 đáp án
		 // 			if (count_ans + size_add_ans == 4) {
		 // 				alert("The Answer is maximum!");
		 // 			}else{
		 // 				$('#add_answer').append(`<div class="del"><br><input type="radio" name="answer_true[]">
		 // 					<input type="hidden" value="0" name="answer_true[]"/>
		 // 					<label>Answer `+(count_ans+1)+`: </label>
		 // 					<input type="text" name="answer_content[]" class="form-control" style="width: 94%; display: inline-block;" value="">
		 // 					<button type="button" class="btn-sm btn-danger" style="padding: 8px 11px;background: orange;"><i class="glyphicon glyphicon-minus"></i></button></div>`);
		 // 			}
		 // 		//xoá đáp án
		 // 	}else if($(this).html() == '<i class="glyphicon glyphicon-minus"></i>'){
		 // 		$(this).parent().remove();
		 // }

		 //khi nhấn sửa topic
		}else if($(this).html() == 'Save'){
			e.preventDefault();
			Swal.fire({
				title: 'Do you want to update?',
				icon: 'question',
				backdrop: false,
				showConfirmButton: true,
				showCancelButton: true,
				confirmButtonColor: '#00bcd4',
			}).then(function(result){
				if (result.isConfirmed) {
					tinymce.triggerSave();
					var id = $('[name=topic_id]').val();
					$.ajax({
						url: "{{ URL::to('/admin/edit-topic-ques') }}/" + id,
						method: "post",
						data: new FormData($('#edit_topic_form')[0]),
						processData: false,
						contentType: false,
						async: false,
						cache: false,
						success: function(response){
							$('.error_edit').html('');
							if (response.status == 1) {
								$('.filter-option-inner-inner').text(response[0].topic_name);
								$('#edit_topic').modal('toggle');
								$('#edit_topic_form')[0].reset();
								$('.error_edit').css('display','none');

								Swal.fire({
									position: 'top-end',
									toast: true,
									title: 'Updated Topic Successfully!',
									icon: 'success',
									showConfirmButton: false,
									timer: 1500
								})

							}else{

								Swal.fire({
									position: 'top-end',
									toast: true,
									title: 'Oops..Something wrong!',
									icon: 'error',
									showConfirmButton: false,
									timer: 1500
								})

								$('.error_edit').css('display','block');
								
								$.each(response.error,function(i,val){
									if (typeof val == "object") {
										$.each(val, function(j,v){
											$('.error_edit').append(`<li style="list-style:none;">`+v[0]+`</li>`);
										})
									}else{
										$('.error_edit').append(`<li style="list-style:none;">`+val+`</li>`);
									}
								});
							}	
						}
					});
				}
			});
		}else if($(this).html() == 'Update'){
			e.preventDefault();
			Swal.fire({
				title: 'Do you want to update?',
				icon: 'question',
				backdrop: false,
				showConfirmButton: true,
				showCancelButton: true,
				confirmButtonColor: '#00bcd4',
			}).then(function(result){
				if (result.isConfirmed) {
						flag = 0;
						skill = $('[name="skill_id"]').find(":selected").text();

						//nếu là kỹ năng nghe hoặc đọc
						if (skill == 'Listening' || skill == 'Reading') {
						//kiểm tra đáp án

						array_check = new Array();
						array_pos = new Array();
						$('[name="answer_content[]"]').each(function(i,v){
							if ($(v).val() == "") {
								array_pos.push(i+1);
							}else{
								array_check.push($(v).val());
							}
						});

						//nếu có đáp án rỗng
						if (array_pos.length > 0) {
							flag = 1;
							Swal.fire({
								position: 'top-end',
								toast: true,
								title: 'Answer '+ array_pos.toString() +' is empty!',
								icon: 'error',
								showConfirmButton: true,
								confirmButtonColor: '#00bcd4',
							})
						}

						//kiểm tra trùng đáp án
						res = array_check.filter(function(value,index,self){
							return self.indexOf(value) !== index
						});
						if (res.length > 0) {
							flag = 1;
							Swal.fire({
								position: 'top-end',
								toast: true,
								title: 'Answer was duplicate!',
								icon: 'error',
								showConfirmButton: true,
								confirmButtonColor: '#00bcd4',
							})
						}
					}

					//nếu không có lỗi
					if (flag == 0) {
						$('#form_update').submit();
					}
				}
			})
		}
	});
		//khi có chọn hành động audio
		$('[name=edit_audio]').change(function(){
			if ($(this).val() == 1) {
				$('[name=topic_audio_edit]').val('');
				$('[name=topic_audio_edit]').attr('disabled','disabled');
			}else{
				$('[name=topic_audio_edit]').removeAttr('disabled','disabled');
			}
		});	
		
		//khi có chọn hành động hình
		$('[name=edit_image]').change(function(){
			if ($(this).val() == 2) {
				$('[name=topic_image_edit]').removeAttr('disabled','disabled');		
			}else{
				$('[name=topic_image_edit]').val('');
				$('[name=topic_image_edit]').attr('disabled','disabled');
			}
		});
	});
});
</script>
@endsection
