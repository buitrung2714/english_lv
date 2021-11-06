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
		<li class="breadcrumb-item active" aria-current="page">Add</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>ADD TOPIC</h2>
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

			{{-- thông báo thành công --}}
			@if(session()->has('success'))
			<div class="alert alert-success" style="background-color: #C6F5D5; font-size: 14px;font-weight: bold;color: green;">
				<p>{{ session()->get('success') }}</p>
			</div>
			@endif

			<div class="panel panel-widget agile-validation">
				<div class="my-div">
					<form method="post" action="{{URL::to('/admin/add-topic-control')}}" enctype="multipart/form-data">
						@csrf
						<div class="input-info">
							<h3>Input Topic</h3>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="skill_id" class="form-control">
								<option value="-1" disabled selected>Choose Skill here</option>
								@foreach($skills as $skills)
								<option value="{{ $skills->skill_id }}">{{ $skills->skill_name }}</option>
								@endforeach
							</select>
						</div>
						<label for="field-2">Part: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="part_id" class="form-control">
								<option value="">Choose Part here</option>
							</select>
						</div>
						<label for="field-2">Level: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="level_id" class="form-control">
								@foreach($levels as $levels)
								<option value="{{ $levels->level_id }}">{{ $levels->level_name }}</option>
								@endforeach
							</select>
						</div>
						<label for="field-2">Topic: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="topic_name" class="form-control">
						</div>
						<div id="hide_audio" style="display: none;">
							<label for="field-2">Audio: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<input type="file" name="topic_audio" class="form-control-file">
							</div>
						</div>
						<div id="hide_content" style="display: none;">
							<label for="field-2">Content: <span class="at-required-highlight">*</span></label>
							<div class="form-group">
								<textarea name="topic_content"></textarea>
							</div>
						</div>
						<label for="field-2">Image: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="file" name="topic_image" class="form-control-file">
						</div>
						<br>
						<p>
							<input type="submit" value="Add" class="btn btn-primary">
							{{-- <input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-default">		 --}}
						</p>
					</form>
				</div>
			</div>
		</div>
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
				title: "Insert Fail!",
				icon: 'error',
				backdrop: false,
				showConfirmButton: true,
				confirmButtonColor: '#00bcd4',
			});
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

				//kiểm tra 4 kỹ năng
				// count = 0;
				// $('[name="skill_id"] option').each(function(i,v){
				// 	skill = $(v).text();
				// 	if ((skill == 'Listening') || (skill == 'Reading') || (skill == 'Writting') || (skill == 'Speaking')) {
				// 		++count;
				// 	}
				// });
				// if(count < 4){
				// 	Swal.fire({
				// 		icon: 'error',
				// 		title: 'Please insert 4 skills basic: Listening, Reading, Writting, Speaking',
				// 		backdrop: false,
				// 		showConfirmButton: true,
				// 		confirmButtonColor: '#00bcd4',
				// 	}).then(function(result){
				// 		if (result.isConfirmed) {
				// 			window.location = "{{ URL::to('/admin/add-skill') }}"
				// 		}
				// 	});
				// }else{
				// 	if ($('[name="level_id"]').html().trim() == "") {
				// 		Swal.fire({
				// 			icon: 'error',
				// 			title: 'Please insert Level!',
				// 			backdrop: false,
				// 			showConfirmButton: true,
				// 			confirmButtonColor: '#00bcd4',
				// 		}).then(function(result){
				// 			if (result.isConfirmed) {
				// 				window.location = "{{ URL::to('/admin/add-level') }}"
				// 			}
				// 		});
				// 	}
				// }

				if($('[name="skill_id"] option').length == 1){
					Swal.fire({
							icon: 'error',
							title: 'Please insert 1 of 4 skills basic: Listening, Reading, Writting, Speaking',
							backdrop: false,
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						}).then(function(result){
							if (result.isConfirmed) {
								window.location = "{{ URL::to('/admin/add-skill') }}"
							}
						});
				}

				if ($('[name="level_id"]').html().trim() == "") {
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


			//khi thay đổi kỹ năng
			$('[name=skill_id]').change(function(){
				var id = $(this).val();
				
				if (id == "") {
					$('[name=part_id]').html('<option value="">Choose Part here</option>');
				}
				//lấy danh sách part
				$.get("{{ URL::to('/admin/get-list-part-topic') }}/" + id, function(response){
					$('[name=part_id]').html('');
					$.each(response,function(i,val){
						$('[name=part_id]').append(`<option value="`+response[i].part_id+`">`+response[i].part_name+`</option>`);
					});

					//nếu ko có part
					if (response.length == 0) {
						Swal.fire({
							icon: 'error',
							title: 'Please insert Part in skill ' + $('[name=skill_id]').find(':selected').text(),
							backdrop: false,
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						}).then(function(result){
							if (result.isConfirmed) {
								window.location = "{{ URL::to('/admin/add-part') }}"
							}
						});	
					}
				});
				//lấy tên kỹ năng và show thông tin kỹ năng
				$.get("{{ URL::to('/admin/get-skill-topic') }}/" + id,function(response){
					if (response.skill_name == 'Listening') {
						$('#hide_content').removeClass("animate__animated animate__fadeIn");
						$('#hide_audio').addClass("animate__animated animate__fadeIn");
						$('#hide_audio').css("display","block");
						$('#hide_content').css("display","none");
					}else if(response.skill_name == 'Reading'){
						$('#hide_audio').removeClass("animate__animated animate__fadeIn");
						$('#hide_content').addClass("animate__animated animate__fadeIn");
						$('#hide_audio').css("display","none");
						$('#hide_content').css("display","block");
					}else if(response.skill_name == 'Writting'){
						$('#hide_audio').removeClass("animate__animated animate__fadeIn");
						$('#hide_content').addClass("animate__animated animate__fadeIn");
						$('#hide_audio').css("display","none");
						$('#hide_content').css("display","block");
					}else if(response.skill_name == 'Speaking'){
						$('#hide_audio').removeClass("animate__animated animate__fadeIn");
						$('#hide_content').addClass("animate__animated animate__fadeIn");
						$('#hide_audio').css("display","none");
						$('#hide_content').css("display","block");
					}else{
						$('[name=part_id]').html('<option value="">Choose Part here</option>');
						Swal.fire({
							toast: true,
							icon: 'error',
							title: response.skill_name + ' not working!',
							position: 'top-end',
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						})
						defaults = $('[name="skill_id"]').find('option:first-child');
						defaults.prop('selected',false);
						$('[name=skill_id]').val(defaults.val());
						defaults.prop('selected', true);
					}
				});
			});
		});
	</script>
	@endsection