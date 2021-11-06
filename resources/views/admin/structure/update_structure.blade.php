@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/structures') }}">Structure Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE STRUCTURE</h2>
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
					<form id="form_update" method="post" action="{{URL::to('/admin/update-structure-control/'.$struc->filter_id)}}" >
						{{ csrf_field() }}
						<input type="hidden" name="edit_id" value="{{ $struc->filter_id }}">
						
						<div class="input-info">
							<h3>Edit Structure</h3>
						</div>
						<label for="field-2">Name: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="text" name="filter_name" value="{{ $struc->filter_name }}" class="form-control">
						</div>
						<label for="field-2">Status: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="filter_status" class="form-control">
								<option value="1"@if($struc->filter_status == 1) selected @endif>Standard</option>
								<option value="2"@if($struc->filter_status == 2) selected @endif>Extra</option>
								<option value="3"@if($struc->filter_status == 3) selected @endif>Beginner</option>
							</select>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group" style="display:flex;">
							@if(isset($data))

							@foreach($data as $key => $detail)
							@php $k = explode(",", $key) @endphp
							<div style="width:100%" class="form-group">
								<button class="btn btn-info btn_skill" type="button" style="width:50%">{{ $k[0] }}</button>
								<button class="btn-sm btn-default" style="background-color:lightgrey;padding: 9px 17px;font-size: 11px;color:#fff;font-weight: bold;width: 30%;" type="button">RESET</button>
								<input type="hidden" name="skill_name[]" value="{{ $k[0] }}">
								<div style="width:80%;">
									<label>Level:</label>
									<select class="form-control" name="level_id[]">
										<option value="" disabled selected>Chose Level here</option>
										@foreach($levels as $level)
										<option value="{{ $level->level_id }}" @if($k[1] == $level->level_id) selected @endif>{{ $level->level_name }}</option>
										@endforeach
									</select><br>
									<label>Part:</label><br>
									@foreach($detail as $part)
									<i class="glyphicon glyphicon-chevron-down" style="color:lightgrey;display: inline;"></i>
									<label>{{ $part[1] }}</label>
									<input type="checkbox" class="form-check-input" name="part_id[]" value="{{ $part[0] }}" @if(isset($part[6])) checked @endif><br>
									<div data-id="{{ $part[2] }}">
										<label>Amount Topic (Max = {{ $part[3] }}):</label>
										<input type="number" @if(isset($part[5])) value="{{ $part[5] }}" @else value="0" @endif class="form-control" style="text-align: center;" name="amount_topic[]" max="{{ $part[3] }}" min="0" oninput="validity.valid||(value=0);">
										<label>Amount Question:</label>
										<input type="text" disabled class="form-control" value="0" style="text-align: center;">
									</div><br>
									@endforeach
								</div>
							</div>
							@endforeach

							@endif
						</div>
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
							<br><button type="submit" class="btn btn-primary">Update</button>
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

		@if(!isset($data))
		<script>
			Swal.fire({
				title: 'Please insert 1 of 4 skills basic: Listening, Reading, Writting, Speaking!',
				icon: 'error',
				backdrop: false,
				showConfirmButton: true,
				confirmButtonColor: '#00bcd4'
			})
		</script>
		@endif

		@if(isset($data))
		<script>
			err_data = new Array();

			@foreach($data as $ks => $v)
				@if(count($data[$ks]) < 1)
					@php 
						$skill_key = explode(",", $ks);
					@endphp
					
					err_data.push("{{ $skill_key[0] }}")
				@endif
			@endforeach
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
		</script>
		@endif

		<script>
			$(document).ready(function(){
			//render kỹ năng
			selector_lv_all = $('[name="level_id[]"]');
			$(selector_lv_all).each(function(i,val){
				//nếu chưa chọn kỹ năng
				if ($(val).val() == null) {
					$(val).parent().css('display','none');
					$(val).parent().find('i').css('display','none');
					$(val).parent().find('div').css('display','none');
					$(val).parent().parent().find('button:nth-child(2)').css('display','none');
					$(val).parent().find('[name="part_id[]"]').prop('disabled',true);
					$(val).parent().find('div').find('[name="amount_topic[]"]').prop('disabled',true);
				}
				//nếu đã chọn kỹ năng
				else{
					skill = $(val).parent().parent().find('button:first-child').html();
					$('.show_data').append(`<tr>
						<td id="skill_`+skill+`">`+skill+`</td>
						<td id="part_name_`+skill+`"></td>
						<td id="amount_topic_`+skill+`"></td>
						<td>`+$(val).find(':selected').text()+`</td>
						</tr>`);
					selector_checkbox = $(val).parent().find('[name="part_id[]"]');
					$(selector_checkbox).each(function(i,val_check){
						//nếu có checked
						if ($(val_check).is(':checked')) {
							$('#part_name_'+skill).append($(val_check).prev().html() + ',');
						}
						//nếu ko checked
						else{
							$(val_check).next().next().find('[name="amount_topic[]"]').prop('disabled',true);
							$(val_check).next().next().css('display','none');
							$(val_check).prev().prev().css('display','none');
						}
					});

					s=0;
					selector_amounts = $(val).parent().find('div');
					$(selector_amounts).each(function(i,val_amount){
						topic_ques = $(val_amount).data('id');
						val = $(val_amount).find('[name="amount_topic[]"]');
						if ($(val).val() != "") {
							$('#amount_topic_'+skill).html(s+=parseInt($(val).val()));
							$(val).parent().find('[type="text"]').val(parseInt($(val).val()) * topic_ques);
						}
					});
				}
			});

			//khi nhấn chọn skill
			$('.btn_skill').click(function(){
				selector_div_first = $(this).parent().find('div:first');
				if ($(selector_div_first).css('display') == 'block') {
					$(selector_div_first).css('display','none');
				}else{
					$(selector_div_first).css('display','block');
				}
			});
			
			$('button').click(function(e){
				//khi chọn reset
				if ($(this).html() == 'RESET') {
					skill = $(this).parent().find('button:first').html();
					selector_checkbox = $(this).parent().find('div:first').find('[name="part_id[]"]');
					div_amount = $(this).parent().find('div:first').find('div');
					selector_amount = $(div_amount).find('[name="amount_topic[]"]');
					default_lv = $(this).parent().find('div:first').find('[name="level_id[]"]').find('option:first-child');
					$(default_lv).prop('disabled',false);
					$(this).parent().find('div:first').find('[name="level_id[]"]').val($(default_lv).val());
					$(default_lv).prop('disabled',true);
					//reset số topic
					$(selector_amount).each(function(i,val){
						$(val).val(0);
						$(val).parent().find('[type="text"]').val(0);
						$(val).prop('disabled',true);
					});
					//bỏ check
					$(selector_checkbox).each(function(i,val_check){
						if ($(val_check).is(':checked')) {
							$(val_check).prop('checked', false);
							$(val_check).prev().prev().css('display','none');
						}
						$(val_check).prop('disabled',true);
					});
					$(div_amount).css('display','none');
					$('#skill_'+skill).parent().remove();
					$(this).css('display','none');
				}
				//khi nhấn submit
				else if($(this).html() == 'Update'){
					e.preventDefault();
					err = new Array();
					flag = 0;
					total = 0;
					$('[name="level_id[]"]').each(function(i,val){
						s=0;
						skill = $(this).parent().parent().find('button:first').html();
						//khi đã có cấp độ
						if ($(val).val() != null) {
							selector_checkbox = $(val).parent().find('[name="part_id[]"]');
							size = $(selector_checkbox).length;
							$(selector_checkbox).each(function(i,val_check){
								if ($(val_check).is(':checked')) {
									//chọn part mà chưa nhập số lượng
									if (($(val_check).next().next().find('[name="amount_topic[]"]').val() == "") || ($(val_check).next().next().find('[name="amount_topic[]"]').val() < 1)) {
										// e.preventDefault();
										err.push("Amount Topic is empty in Part " + $(val_check).prev().html() + " in "+skill+'!');
										// alert("Please could you fill Amount Topic in Part " + $(val_check).prev().html() + " in "+skill+'!');
									}
								}else{
									++s;
								}
							});
							if (s == size) {
								// e.preventDefault();
								err.push("Please could you chose Part in "+skill+'!');
								// alert("Please could you chose Part in "+skill+'!');
							}
							$(this).parent().parent().find('[name="skill_name[]"]').prop('disabled', false);
						}
						//chưa có cấp độ
						else{
							$(this).parent().parent().find('[name="skill_name[]"]').prop('disabled', true);
							total++;
						}
					});
					//nếu chưa chọn kỹ năng nào
					if (total == 4) {
						err.push("Please could you chose Skill!");
					}

					if ($('[name="filter_name"]').val() == "") {
						err.push("Name is empty!");
					}else if ($('[name="filter_name"]').val().length > 255){
						err.push("Name must not be greater than 255 characters.");
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
							data: $('#form_update').serialize(),
							success:function(response){
								if(typeof response.error == "undefined"){
									if (flag != 1) {
										$('#form_update').submit();
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
			//khi thay đổi cấp độ
			$('[name="level_id[]"]').change(function(){
				selector_lv = this;
				ar_skill = new Array();
				skill = $(this).parent().parent().find('button:first').html();
				$(this).parent().find('[name="part_id[]"]').prop('disabled',false);
				//kiểm tra tồn tại kĩ năng
				$($('.show_data')).each(function(i,val){
					selector_skill = $(val).find('tr').find('td:first');
					$(selector_skill).each(function(i,val_skill){
						ar_skill.push($(val_skill).html());
					});
					//nếu có kỹ năng
					if(ar_skill.includes(skill)){
						$('#skill_'+skill).next().next().next().html($(selector_lv).find(':selected').text());
					}else{
						$('.show_data').append(`<tr>
							<td id="skill_`+skill+`">`+skill+`</td>
							<td id="part_name_`+skill+`"></td>
							<td id="amount_topic_`+skill+`">0</td>
							<td>`+$(selector_lv).find(':selected').text()+`</td>
							</tr>`);
						$(selector_lv).parent().parent().find('button:nth-child(2)').css('display','inline');
					}
				});
			});

			//khi chọn part
			$('[name="part_id[]"]').change(function(){
				skill = $(this).parent().parent().find('button:first').html();
				if ($(this).is(':checked')) {
					$(this).next().next().find('[name="amount_topic[]"]').prop('disabled', false);
					$(this).next().next().css('display','block');
					$(this).prev().prev().css('display','inline');
					$('#part_name_'+skill).append($(this).prev().html()+',');
				}
				else
				{
					$(this).next().next().find('[name="amount_topic[]"]').val(0);
					$(this).next().next().find('[name="amount_topic[]"]').prop('disabled', true);
					$(this).next().next().css('display','none');
					$(this).prev().prev().css('display','none');
					str = $('#part_name_'+skill).html();
					part_chose = $(this).prev().html();
					if (str.indexOf(part_chose) != -1) {
						rep = str.replace(part_chose + ',', "");
						$('#part_name_'+skill).html(rep);
					}
					val_topic = $(this).next().next().find('[name="amount_topic[]"]').val();
					val_total = $('#amount_topic_'+skill).html();
					$('#amount_topic_'+skill).html(parseInt(val_total) - val_topic);
					$(this).next().next().find('[name="amount_topic[]"]').val(0);
					$(this).next().next().find('[type="text"]').val(0);
					$(this).next().next().find('[name="amount_topic[]"]').prop('disabled', true);
				}
			});
			//khi thay đổi số lượng topic
			$('[name="amount_topic[]"]').on('input',function(){
				s=0;
				selector_this = this;
				skill = $(this).parent().parent().parent().find('button:first').html();
				selector_total_amount = $(this).parent().parent().find('[name="amount_topic[]"]');
				topic_ques = $(this).parent().data('id');
				$(this).parent().find('[type="text"]').val($(this).val() * topic_ques);
				$(selector_total_amount).each(function(i,val){
					if ($(val).val() != "") {
						$('#amount_topic_'+skill).html(s+=parseInt($(val).val()));
					}
				});
			});
		});
	</script>

	@endsection