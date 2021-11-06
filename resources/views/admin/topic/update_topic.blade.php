@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/topics') }}">Topic Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE TOPIC</h2>
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
					<form id="form_update" method="post" action="{{URL::to('/admin/update-topic-control/'.$topic->topic_id)}}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="_method" value="put" />
						<div class="input-info">
							<h3>Edit Topic</h3>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="skill_id" disabled class="form-control">
								<option value="{{ $skill->skill_id }}" disabled selected>{{ $skill->skill_name }}</option>
							</select>
						</div>
						<label for="field-2">Part: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="part_id" class="form-control">
								@foreach($parts as $parts){
									<option value="{{ $parts['part_id'] }}"@if($topic->part_id == $parts->part_id)selected @endif>{{ $parts['part_name'] }}</option>
								}
								@endforeach
							</select>
						</div>
						<label for="field-2">Level: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="level_id" class="form-control">
								@foreach($levels as $levels)
								<option value="{{ $levels->level_id }}"@if($levels->level_id == $topic->level_id) selected @endif>{{ $levels->level_name }}</option>
								@endforeach
							</select>
						</div>
						<label for="field-2">Topic: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="topic_name" value="{{ $topic->topic_name }}" class="form-control">
						</div>
						@if($skill['skill_name'] == 'Listening')
						<select name="edit_audio">
							<option value="1">No Action</option>
							<option value="2">Change</option>
						</select>
						<label for="field-2">Audio: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							@if($topic->topic_audio != null)
							<audio controls src="/file/audio/{{ $topic->topic_audio }}"></audio>
							@endif
							<input type="file" name="topic_audio" disabled class="form-control-file">
						</div>
						@endif					
						@if($topic->topic_content != null)
						<label for="field-2">Content: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<textarea name="topic_content">{{ $topic->topic_content }}</textarea>
						</div>
						@endif
						<select name="edit_image">
							<option value="1">No Action</option>
							<option value="2">Change</option>
							<option value="3">Remove</option>
						</select>
						<label for="field-2">Image: <span class="at-required-highlight">*</span></label>	
						<div class="form-group">
							<img src="/file/image/{{ $topic->topic_image }}" id="get_image" alt="@if(!isset($topic->topic_image))No Image @endif"  width="150" height="180">
							<input type="file" name="topic_image" disabled class="form-control-file">
						</div>
						<br>
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
			$(document).ready(function(){
					//tinyMCE (quản lý soạn thảo văn bản cho thẻ <textarea>)
					tinymce.init({
						selector: '[name=topic_content]',
						plugins: [
						'advlist autolink lists link image charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table paste code help wordcount',
						],
						toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
						height: 300,
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

		//nếu trong topic ko có hình sẽ không có tính năng xoá hình
		if ($('#get_image').attr('alt') == "") {
			$('[name=edit_image]').find('option[value=3]').removeAttr('disabled');
		}else{
			$('[name=edit_image]').find('option[value=3]').attr('disabled','disabled');
		}
		
		//khi có chọn hành động audio
		$('[name=edit_audio]').change(function(){
			if ($(this).val() == 1) {
				$('[name=topic_audio]').val('');
				$('[name=topic_audio]').attr('disabled','disabled');
			}else{
				$('[name=topic_audio]').removeAttr('disabled','disabled');
			}
		});	
		
		//khi có chọn hành động hình
		$('[name=edit_image]').change(function(){
			if ($(this).val() == 2) {
				$('[name=topic_image]').removeAttr('disabled','disabled');		
			}else{
				$('[name=topic_image]').val('');
				$('[name=topic_image]').attr('disabled','disabled');
			}
		});	

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
	});
</script>
@endsection
