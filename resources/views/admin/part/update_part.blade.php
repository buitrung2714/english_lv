@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/parts') }}">Part Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE PART</h2>
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
					<form id="form_update" method="post" action="{{URL::to('/admin/update-part-control/'.$part->part_id)}}">
						@csrf
						<input type="hidden" name="_method" value="put" />
						<div class="input-info">
							<h3>Edit Part</h3>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="skill_id" class="form-control">
								@foreach($skills as $skills)
								<option value="{{ $skills->skill_id }}"@if($skills->skill_id == $part->skill_id) selected="selected" @endif>{{ $skills->skill_name }}</option>
								@endforeach
							</select>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="part_name" value="{{ $part->part_name }}" class="form-control">
						</div>
						<label for="field-2">Ordinal Numbers: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="number" name="part_no" class="form-control" value="{{ $part->part_no }}" min="1" oninput="validity.valid||(value=1);" max="10">
						</div>
						<label for="field-2">Amount Question / Topic: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="number" name="part_amount_ques_per_topic" value="{{ $part->part_amount_ques_per_topic }}" class="form-control" min="1" oninput="validity.valid||(value=1);" max="10">
						</div>
						<label for="field-2">Topic Max: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="number" name="part_topic_max" value="{{ $part->part_topic_max }}" class="form-control" oninput="validity.valid||(value=1);" max="10">
						</div>
						<label for="field-2">Description: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<textarea name="part_des">{{ $part->part_des }}</textarea>
						</div>
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
					selector: '[name=part_des]',
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
				// 		Swal.fire({
				// 			icon: 'error',
				// 			title: 'Please insert 4 skills basic: Listening, Reading, Writting, Speaking',
				// 			backdrop: false,
				// 			showConfirmButton: true,
				// 			confirmButtonColor: '#00bcd4',
				// 		}).then(function(result){
				// 			if (result.isConfirmed) {
				// 				window.location = "{{ URL::to('/admin/add-skill') }}"
				// 			}
				// 		});
				// 	}
				
				//khi đổi kỹ năng
				skill_old = $('[name="skill_id"]').val();
				$('[name="skill_id"]').change(function(){
					skill = $(this).find(':selected').text();
					
					if ((skill != 'Listening') && (skill != 'Reading') && (skill != 'Writting') && (skill != 'Speaking')) {
						Swal.fire({
							toast: true,
							icon: 'error',
							title: skill + ' not working!',
							position: 'top-end',
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						})
						
						$(this).val(skill_old);
						
					}
					skill_old = $(this).find(':selected').val();
				})

				$('[type="submit"]').click(function(e){
					e.preventDefault();
					if ($('[name="skill_id"]').val() == null) {
						Swal.fire({
						toast:true,
						title: 'Please chose Skill!',
						icon: 'error',
						backdrop: false,
						showConfirmButton: true,
						showCancelButton: true,
						confirmButtonColor: '#00bcd4'
						})
					}else{
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
					}
				})
			});	
		</script>
		@endsection