@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
.swal-wide{
	width:550px !important;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/structures') }}">Structure Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Add</li>
	</ol>
</nav>

@if(count($data) < 1)

<script>
	Swal.fire({
		title: "Plese insert 1 of 4 skills basic: Listening, Reading, Writting, Speaking!",
		icon: 'error',
		backdrop: false,
		showConfirmButton: true,
		confirmButtonColor: '#00bcd4',

	}).then(function(result){
		if (result.isConfirmed) {
			window.location = "{{ URL::to('/admin/add-skill') }}"
		}
	});
</script>

@else

<script>
	err_data = new Array();
	@if((isset($data['Listening'])) && (count($data['Listening']) < 1))
	err_data.push('Listening')
	@endif

	@if((isset($data['Reading'])) && (count($data['Reading']) < 1))
	err_data.push('Reading')
	@endif

	@if((isset($data['Writting'])) && (count($data['Writting']) < 1))
	err_data.push('Writting')
	@endif

	@if((isset($data['Speaking'])) && (count($data['Speaking']) < 1))
	err_data.push('Speaking')
	@endif

	if (err_data.length > 0) {
		Swal.fire({
			title: "Please insert Part in " + err_data.toString() + '!',
			icon: 'error',
			backdrop: false,
			showConfirmButton: true,
			confirmButtonColor: '#00bcd4',
			customClass: 'swal-wide',
		}).then(function(result){
			if (result.isConfirmed) {
				window.location = "{{ URL::to('/admin/add-part') }}"
			}
		});
	}

	//nếu chưa có level
	if($('[name="level_id[]"] option').length == $('[name="level_id[]"]').length){
		Swal.fire({
			title: "Please insert Level!",
			icon: 'error',
			backdrop: false,
			showConfirmButton: true,
			confirmButtonColor: '#00bcd4',
		}).then(function(result){
			if (result.isConfirmed) {
				window.location = "{{ URL::to('/admin/add-level') }}"
			}
		});
	}
</script>

@endif

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>ADD STRUCTURE</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
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
				<li>{{ $err[0] }}</li>
				@endif
				@endforeach
				{{-- nếu lỗi ràng buộc --}}
				@else
				<li>{{ $err_array }}</li>
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
					<form id="form_add" method="post" action="{{ URL::to('/admin/add-structure-control') }}" >
						{{ csrf_field() }}
						<div class="input-info">
							<h3>Create Structure</h3>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="filter_name"class="form-control">
						</div>
						<label for="field-2">Status: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="filter_status" class="form-control">
								<option value="1">Standard</option>
								<option value="2">Extra</option>
								<option value="3">Beginner</option>
							</select>
						</div>

						@if(count($data) > 0)
						
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group" style="display:flex;">

							@foreach($data as $key => $data)
							<div style="width:100%" class="form-group">
								<button class="btn btn-info btn_skill" type="button" style="width:50%;">{{ $key }}</button>
								<button class="btn-sm btn-default" style="background-color:lightgrey;padding: 9px 17px;font-size: 11px;color:#fff;font-weight: bold;width: 30%;display: none;" type="button">RESET</button>
								<input type="hidden" name="skill_name[]" value="{{ $key }}">
								<div style="width:80%;display: none;">
									<label>Level:</label>
									<select class="form-control" name="level_id[]">
										<option value="-1" disabled selected>Chose Level here</option>
										@foreach($levels as $level)
										<option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
										@endforeach
									</select><br>
									<label>Part:</label><br>
									@foreach($data as $part)
									<i class="glyphicon glyphicon-chevron-down" style="color:lightgrey;display: none;"></i>
									<label>{{ $part[0] }}</label>
									<input type="checkbox" value="{{ $part[1] }}" name="part_id[]" class="form-check-input"><br>
									<div style="display:none;" data-id="{{ $part[2] }}">
										<label>Amount Topic (Max = {{ $part[3] }}):</label>
										<input type="number" class="form-control" value="0" min="0" disabled name="amount_topic[]" max="{{ $part[3] }}" style="text-align: center;" oninput="validity.valid||(value=0);">
										<label>Amount Question:</label>
										<input type="text" value="0" style="text-align:center;" disabled class="form-control">
									</div><br>
									@endforeach
								</div>
							</div>
							@endforeach
						</div>

						@endif
						<div class="form-group">
							<table class="table table-bordered table-responsive">
								<thead>
									<tr>
										<th>Skill</th>
										<th>Part</th>
										<th>Total Topic</th>
										<th>Level</th>
									</tr>
								</thead>
								<tbody class="text-center show_data">
								</tbody>
							</table>
						</div>
						<p>
							<br><button type="submit" class="btn btn-primary">Add</button>
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

		@if(isset($fail_data))
		<script>
			// Swal.fire({
			// 	title: "{{ $fail_data }}",
			// 	icon: 'error',
			// 	backdrop: false,
			// 	showConfirmButton: true,
			// 	confirmButtonColor: '#00bcd4',

			// }).then(function(result){
			// 	if (result.isConfirmed) {
			// 		window.location = "{{ URL::to('/admin/add-skill') }}"
			// 	}
			// });
		</script>
		@endif

		<script>
			$(document).ready(function(){

				//khi nhấn vào kỹ năng
				$('.btn_skill').click(function(){
					seletor_lv = $(this).parent().find('div:first').find('[name="level_id[]"]');
					if ($(this).parent().find('div:first').css('display') == 'block') {
						$(this).parent().find('div:first').css('display','none');
					}else{
						$(this).parent().find('div:first').css('display','block');
					}
					//nếu kỹ năng chưa có lv
					if ($(seletor_lv).val() == null) {
						$(seletor_lv).parent().find('[name="part_id[]"]').prop('disabled', true);
					}
				});
				//khi nhấn button
				$('button').click(function(e){
					//chọn reset
					if ($(this).html() == 'RESET') {
						skill = $(this).parent().find('button:first').html();
						selector_DIV = $(this).parent().find('div');
						selector_lv = $(this).parent().find('div:first').find('[name="level_id[]"]');
						selector_checkbox = $(selector_DIV).find('[name="part_id[]"]');
						$(selector_lv).find('option:first-child').prop('disabled',false);
						$(selector_lv).val($(selector_lv).find('option:first-child').val());
						$(selector_lv).find('option:first-child').prop('disabled', true);
						$(selector_checkbox).each(function(i,val){
							$(val).prop('checked',false);
							$(val).prop('disabled', true);
							$(val).prev().prev().css('display','none');
							$(val).next().next().css('display','none');
							$(val).next().next().find('[type="text"]').val(0);
							$(val).next().next().find('[name="amount_topic[]"]').val(0);
							$(val).next().next().find('[name="amount_topic[]"]').prop('disabled', true);
						});
						//xoá dữ liệu table
						$('#skill_'+skill).parent().remove();
						$(this).css('display','none');
					}
					//gửi dữ liệu
					else if($(this).html() == 'Add'){
						e.preventDefault();
						skill_check = 0;
						flag = 0;
						err = new Array();
						//kiểm tra level kỹ năng
						$('[name="level_id[]"]').each(function(i,val){
							skill = $(this).parent().parent().find('button:first').html();
							//nếu kỹ năng đã có lv
							if ($(val).val() != null) {
								//kiểm tra part
								s=0;
								selector_checkbox = $(val).parent().find('[name="part_id[]"]');
								size = $(selector_checkbox).length;
								$(selector_checkbox).each(function(i,val_check){
									//kiểm tra check part
									if (!$(val_check).is(':checked')) {
										s++;
									}else{
										//chọn part mà chưa nhập số lượng
										if (($(val_check).next().next().find('[name="amount_topic[]"]').val() == "") || ($(val_check).next().next().find('[name="amount_topic[]"]').val() < 1)) {
											
											err.push("Amount Topic is empty in Part " + $(val_check).prev().html() + " in "+skill+'!');
											
										}
									}
								});
								if (s == size) {
									
									err.push('Please could you chose Part in '+skill+'!');
									
								}
								$(val).parent().parent().find('[name="skill_name[]"]').prop('disabled', false);
							}
							//nếu kỹ năng chưa có level
							else{
								$(val).parent().parent().find('[name="skill_name[]"]').prop('disabled', true);
								skill_check++;
							}
						});

						//nếu chưa chọn kỹ năng nào
						if (skill_check == $('.btn_skill').length) {
							err.push('Please could you chose a Skill!');
							
						}

						//nếu chưa nhập tên
						if ($('[name="filter_name"]').val() == "") {
							err.push('Name is empty!')
						}else if($('[name="filter_name"]').val().length > 255){
							err.push('Name must not be greater than 255 characters.')
						}

						if (err.length > 0) {
							flag = 1;
							j = 0;
							part_length = $('[name="part_id[]"]').length;

							$('[name="part_id[]"]').each(function(i,v){
								if(!$(v).is(':checked')){
									++j;
								}
								
								if(j == part_length){
									Swal.fire({
										position: 'top-end',
										toast: true,
										title: err.toString().replaceAll(",","<br><br>"),
										icon: 'error',
										showConfirmButton:true,
										confirmButtonColor: '#00bcd4'
									})
								}
							})	
						}
						// kiểm tra cấu trúc
						
						$.ajax({
							url: "{{ URL::to('/admin/check-struc') }}",
							method: "post",
							data: $('#form_add').serialize(),
							success:function(response){
								if(typeof response.error == "undefined"){
									if (flag != 1) {
										$('#form_add').submit();
									}else{
										Swal.fire({
											position: 'top-end',
											toast: true,
											title: err.toString().replaceAll(",","<br><br>"),
											icon: 'error',
											showConfirmButton:true,
											confirmButtonColor: '#00bcd4'
										})
									}
								}else{
									$.each(response.error,function(i,error){
										err.push(error);
									})
									Swal.fire({
										position: 'top-end',
										toast: true,
										title: err.toString().replaceAll(",","<br><br>"),
										icon: 'error',
										showConfirmButton:true,
										confirmButtonColor: '#00bcd4'
									})
								}	
							}
						});
					}
				});
				//khi thay đổi level
				$('[name="level_id[]"]').change(function(){
					ar = new Array();
					seletor_this = this;
					skill = $(this).parent().parent().find('button:first').html();
					selector_table_skill = $('.show_data').find('tr').find('td:first');

					//nếu chưa có kỹ năng nào
					if ($('.show_data').find('tr').length == 0) {
						$('.show_data').append(`<tr>
							<td id="skill_`+skill+`">`+skill+`</td>
							<td id="part_`+skill+`"></td>
							<td id="amount_topic_`+skill+`">0</td>
							<td id="level_`+skill+`">`+$(seletor_this).find(':selected').text()+`</td>
							</tr>`);
					}
					//nếu đã có kỹ năng
					else{
						$(selector_table_skill).each(function(i,val){
							ar.push($(val).html());
						});
						//nếu đã có kỹ năng này
						if (ar.includes(skill)) {
							$('#level_'+skill).html($(seletor_this).find(':selected').text());
						}
							//nếu chưa có kỹ năng này
							else{
								$('.show_data').append(`<tr>
									<td id="skill_`+skill+`">`+skill+`</td>
									<td id="part_`+skill+`"></td>
									<td id="amount_topic_`+skill+`">0</td>
									<td id="level_`+skill+`">`+$(seletor_this).find(':selected').text()+`</td>
									</tr>`);
							}
						}
						$(this).parent().parent().find('button:nth-child(2)').css('display','inline');
						$(this).parent().find('[name="part_id[]"]').prop('disabled', false);
					});
				//khi chọn part
				$('[name="part_id[]"]').change(function(){
					skill = $(this).parent().parent().find('button:first').html();
					//nếu checked
					if ($(this).is(':checked')) {
						$(this).next().next().css('display','block');
						$(this).prev().prev().css('display','inline');
						$('#part_'+skill).append($(this).prev().html() + ',');
						$(this).next().next().find('[name="amount_topic[]"]').prop('disabled', false);
					}
					//nếu bỏ check
					else{
						//thay thế chuỗi
						str = $('#part_'+skill).html();
						if (str.indexOf($(this).prev().html()) != -1) {
							rep = str.replace($(this).prev().html() + ',', "");
							$('#part_'+skill).html(rep);
						}
						//tính số topic còn lại
						total = $('#amount_topic_'+skill).html();
						cur = $(this).next().next().find('[name="amount_topic[]"]').val();
						$('#amount_topic_'+skill).html(parseInt(total) - cur);
						$(this).next().next().css('display','none');
						$(this).prev().prev().css('display','none');
						$(this).next().next().find('[type="text"]').val(0);
						$(this).next().next().find('[name="amount_topic[]"]').val(0);
						$(this).next().next().find('[name="amount_topic[]"]').prop('disabled', true);
					}
				})
				//khi thay đổi số lượng topic
				$('[name="amount_topic[]"]').on('input',function(){
					skill = $(this).parent().parent().parent().find('button:first').html();
					selector_div = $(this).parent().parent().find('div');
					topic_ques = $(this).parent().data('id');
					topic_chose = $(this).val();

					$(this).parent().find('[type="text"]').val(topic_ques * topic_chose);
					//tính tổng topic
					s=0;
					$(selector_div).each(function(i,val){
						amount = $(val).find('[name="amount_topic[]"]').val();
						$('#amount_topic_'+skill).html(s += parseInt(amount));
					});
				});
			});
		</script>

		@endsection