@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
.error_mess{
	color: red;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/routes') }}">Route Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Add</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>ADD ROUTE</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
			{{-- lỗi trùng dữ liệu --}}
			@if(session()->has('error'))
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold;list-style: none;">
				<li>{{ session()->get('error') }}</li>
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
					<form method="post" action="{{URL::to('/admin/add-route-control')}}" >
						@csrf
						<div class="input-info">
							<h3>Input Route</h3>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="route_name" class="form-control">
							<span class="error_mess"></span>
						</div>
						<label for="field-2">Description: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<textarea name="route_des"></textarea>
							<span class="error_mess"></span>
						</div>
						<button type="button" class="btn btn-secondary insert_route" style="color: black">Add Structure</button><br>

						<div class="route">

							<div class="count">
								<label for="field-2">Structure 1: <span class="at-required-highlight">*</span></label>
								<div class="form-group">
									<select name="filter_id[]" class="form-control">
										<option value="-1" disabled selected>Chose Structure here</option>
										@foreach($filters as $filter)
											<option value="{{ $filter['filter_id'] }}">{{ $filter['filter_name'] }}</option>
										@endforeach
									</select>
									<span class="error_mess"></span>
								</div>
								<button type="button" class="btn btn-primary detailBtn" style="background-color: #666; display:none">Details</button><br>
							</div>

						</div>
						<p>
							<br><input type="submit" value="Add" class="btn btn-primary">
							{{-- <input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-default"> --}}	
						</p>
					</form>

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
									<table class="table table-bordered table-responsive">
										<thead>
											<tr>
												<th>Skill</th>
												<th>Part</th>
												<th>Level</th>
												<th>Amount Topic</th>
											</tr>
										</thead>
										<tbody id="show_detail" class="text-center">
										</tbody>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

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
							selector: 'textarea',
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

				var options = [];
				$.each(@php echo json_encode($filters) @endphp, function(i,v){ 
					options.push(`<option value=${v.filter_id}>${v.filter_name}</option>`);
				})

				$('.insert_route').click(function(){
					var count = $('.count').length;
					 
					if (count < 10) {
						
						$('.route').append(`
							<div class="count">
								<label for="field-2">Structure ${count + 1}: <span class="at-required-highlight">*</span></label>
								<div class="form-group">
									<select name="filter_id[]" class="form-control" style="width: 96%; display: inline;">
										<option value="-1" disabled selected>Chose Structure here</option>
										${options.toString()}
									</select>
									<button type="button" class="btn-sm btn-warning delBtn" style="background: red;border: none;"><i class="glyphicon glyphicon-remove"></i></button>
									<span class="error_mess"></span>
								</div>
								<button type="button" class="btn btn-primary detailBtn" style="background-color: #666;display: none;">Details</button><br>
							</div>`);	
					}
					else{
						Swal.fire({
							icon: 'warning',
							title: 'Maximum 10 Structures / Route !',
							toast: true,
							position: 'top-end',
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						})
					}
				});

				//khi thay đổi cấu trúc
				$(document).on('change','[name="filter_id[]"]',function(){

					if ($(this).val() != null) {
						$(this).parent().next().show();
					}else{
						$(this).parent().next().hide();
					}
					
				});

				//khi lấy thông tin cấu trúc
				$(document).on('click','.detailBtn',function(){
					var id = $(this).prev().find('[name="filter_id[]"]').val();

					$('#show_detail').empty();
					$.get("{{ URL::to('/admin/get-id-structure') }}/" + id, function(response){
						$('#detail').modal('toggle');

						$.each(response,function(i,v){
							$('#show_detail').append(`
									<tr>
										<td>${v.skill_name}</td>
										<td>${v.part_name}</td>
										<td>${v.level}</td>
										<td>${v.amount_topic}</td>
									</tr>
								`);
						})
					});
				})

				//khi xoá cấu trúc dư
				$(document).on('click','.delBtn',function(){
					$(this).parent().parent().remove();
				});

				//khi nhấn nút submit
				$('[type="submit"]').click(function(e){
					var err = 0;
					tinyMCE.triggerSave();
					var filter_array = [];
					$('.error_mess').empty();

					if($('[name="route_name"]').val().trim() == ""){
						err = 1;
						$('[name="route_name"]').parent().find('.error_mess').html('Name is empty !');
					}

					if($('[name="route_des"]').val().trim() == ""){
						err = 1;
						$('[name="route_des"]').parent().find('.error_mess').html('Description is empty !');
					}

					$('[name="filter_id[]"]').each(function(i,v){
						if ($(v).val() == null) {
							err = 1;
							$(v).parent().find('.error_mess').html(`Structure ${i+1} is empty !`);
						}else{

							if (filter_array.indexOf($(v).val()) == -1) {
								filter_array.push($(v).val());
							}else{
								err = 1;
								$(v).parent().find('.error_mess').html(`Structure ${filter_array.indexOf($(v).val()) + 1} was chose !`);
							}
						}
					});

					if (err == 1) {
						e.preventDefault();

						Swal.fire({
							toast: true,
							position: 'top-end',
							icon: 'error',
							title: 'Something..wrong!',
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						})
					}
				});

			})
			</script>
		@endsection