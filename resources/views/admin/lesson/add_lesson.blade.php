@extends('admin.layout.layout')
@section('admin_content')

<style>
#res-1{
	background: lightgrey;
}

.btn.btn-default[role=combobox]{
	width: 100%;
	background: white;
	color: black;
	border: 1px solid lightgrey;
}
.bootstrap-select .dropdown-menu { 
	max-width: 100% !important; 
}
.dropdown-menu .open{
	max-height: 320px !important;
}
.bs-actionsbox{
	padding: 0px 6px 35px !important;
}
.bs-deselect-all{
	float: right !important;
}
.actions-btn.btn-default{
	background: #f8f9fa !important;
    color: black !important;
    border: #f8f9fa !important;
}
</style>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('/admin/lessons') }}">Lesson Manage</a></li>
		<li class="breadcrumb-item active" aria-current="page">Add</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>ADD LESSON</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
			{{-- thông báo lỗi validate --}}
			@if(session()->has('error'))
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold; list-style:none;">
				@foreach(session()->get('error') as $err)
				@if(is_array($err))
				@foreach($err as $err_s)
				<li>{{ $err_s[0] }}</li>
				@endforeach
				@else
				<li>{{ $err }}</li>
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
					<form method="post" action="{{URL::to('/admin/add-lesson-control')}}" >
						@csrf
						<div class="input-info">
							<h3>Input Lesson</h3>
						</div>

						<input type="hidden" name="question_id">
						<label for="field-2">Structure: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<select name="filter_id" class="form-control">
								<option value="-1" disabled selected>Chose Structure here</option>
								@foreach($strucs as $struc)
								<option value="{{ $struc->filter_id }}">{{ $struc->filter_name }}</option>
								@endforeach
							</select>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group skill_all" style="display:flex;">
							@foreach($skills as $skill)
							<div style="width:25%;">
								<button type="button" class="btn btn-info btn_skill" disabled>{{ $skill }}</button>
							</div>
							@endforeach
						</div>
						@foreach($data as $key => $detail)
						<div class="form-group" id="skill_{{ $key }}" style="display:none;">
							@foreach($detail as $part)
							<div id="div_part_{{ $part[0] }}" style="display:none;">
								<select name="amount_topic_{{ $part[0] }}" class="amount_topic" data-id="{{ $part[0] }}">
								</select>
								<h4 style="display: inline;margin-left: 5px">{{ $part[1] }}.</h4>
								<div id="add_part_{{ $part[0] }}" class="reset_part" data-id="{{ $part[0] }}" data-skill="{{ $key }}"></div>
							</div>
							@endforeach
						</div>
						@endforeach

						<p>
							<br><input type="submit" value="Add" class="btn btn-primary">
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

		@if(isset($data))
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
		</script>
		@endif

		@if(isset($fail_skill))
		<script>
			// Swal.fire({
			// 	title: "{{ $fail_skill }}",
			// 	icon: 'error',
			// 	backdrop: false,
			// 	showConfirmButton: true,
			// 	confirmButtonColor: '#00bcd4',
			// }).then(function(result){
			// 	window.location = "{{ URL::to('/admin/add-skill') }}"
			// });
		</script>
		@endif

		@if(!isset($skills))
		<script>
			Swal.fire({
				title: "Please insert 1 of 4 skills basic: Listening, Reading, Writting, Speaking!",
				icon: 'error',
				backdrop: false,
				showConfirmButton: true,
				confirmButtonColor: '#00bcd4',
			}).then(function(result){
				window.location = "{{ URL::to('/admin/add-skill') }}"
			});
		</script>
		@endif

		<script>
			$(document).ready(function(){
				$('.selectpicker').selectpicker();
				
				//nếu chưa có cấu trúc
				if($('[name="filter_id"] option').length == 1){
					Swal.fire({
						title: "Please insert Structure!",
						icon: 'error',
						backdrop: false,
						showConfirmButton: true,
						confirmButtonColor: '#00bcd4',
					}).then(function(result){
						window.location = "{{ URL::to('/admin/add-structure') }}"
					});
				}

				//khi thay đổi cấu trúc
				$('[name="filter_id"]').change(function(){
					err = new Array();
					ar_topic = new Array();
					//reset part
					$('.btn_skill').each(function(i,val){
						skill_check = $(val).html();
						$('.reset_part').html('');
						$('#skill_'+skill_check).css('display','none');
						$('#skill_'+skill_check).children('div').css('display','none');
						$('.amount_topic').html('<option value="" selected disabled>Topic</option>');
					});

					var id = $(this).val();
					$.get("{{ URL::to('/admin/get-filter-struc') }}/" + id,function(response){
						if (typeof response.status == "undefined") {
							//kiểm tra hiển thị kỹ năng có trong cấu trúc
							$.each(response,function(i,val){
								array = Object.values(response[i]);
								selector_skill_all = $('.skill_all').find('div');
								$(selector_skill_all).each(function(j,val_skill){
									skill = $(val_skill).find('button');
									if (skill.html() == i) {
									//nếu kỹ năng có dữ liệu
									if (array.length > 0) {
										$.each(array, function(k, value){
											$('#div_part_'+value[0]).css('display','block');
											$('#add_part_'+value[0]).attr('data-topic',value[3]);
											$('#add_part_'+value[0]).attr('data-ques',value[2]);
											for(l = 0; l < value[3]; l++){	
												$('[name="amount_topic_'+value[0]+'"]').append(`<option value="`+(l+1)+`">Topic `+(l+1)+`</option>`);
												$('#add_part_'+value[0]).append(`<div id="part_`+value[0]+`_`+(l+1)+`" style="display:none;" data-no="`+(l+1)+`"><label for="field-2">Topic: <span class="at-required-highlight">*</span></label>
													<select name="topic_`+value[0]+`" class="form-control part_topic">
													<option value="" selected disabled>Chose Topic here</option>
													</select><br>
													<label for="field-2">Question: <span class="at-required-highlight">*</span></label>
													<select multiple data-actions-box="true" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Selected ({0}/${value[2]})" class="form-control selectpicker">
													</select><br><br></div>`);
											};
											$.each(value[4],function(h,val_topic){
												$(val_topic).each(function(k,val_tp){
													$('[name="topic_'+value[0]+'"]').append(`<option value="`+value[4][h][0]+`">`+value[4][h][1]+`</option>`);
													return false;
												});
												$('.selectpicker').val('default').selectpicker('refresh');
											});
										});
										$(skill).prop('disabled', false);
									}
									//nếu ko có dữ liệu
									else{
										$(skill).prop('disabled', true);
									}
								}
							});
							});
						}	
						//nếu có lỗi
						else{
							$.each(response.error,function(i,error){
								err.push(error);
							});
							str = err.toString();

							Swal.fire({
								icon: 'warning',
								title: 'Oops..!',
								html: str.replaceAll(",","<br>"),
								backdrop: false,
								showConfirmButton: true,
								confirmButtonColor: '#00bcd4',
							})

							selector_default = $('[name="filter_id"]').find('option:first-child');
							$(selector_default).prop('disabled',false);
							val_default = $(selector_default).val();
							$('[name="filter_id"]').val(val_default);
							$(selector_default).prop('disabled',true);
							$('.btn_skill').prop('disabled',true);
						}
					});
				});
				//khi thay đổi skill
				skill_checks = '';
				count_skill = 1;
				$('.btn_skill').click(function(){
					skill = $(this).html();
						//ẩn form kỹ năng cũ
						$('.btn_skill').each(function(i,val){
							skill_check = $(val).html();
							if ($('#skill_'+skill_check).css('display') == 'block') {
								$('#skill_'+skill_check).css('display','none');
							}
						});

						if (skill_checks == skill) {
							count_skill++;
						}
						if (count_skill == 2) {
							$('#skill_'+skill).css('display','none');
							count_skill = 0;
						}else{
							$('#skill_'+skill).css('display','block');
						}
						skill_checks = skill;
					});

				//khi thay đổi topic
				$(document).on('change','.part_topic',function(){
					selector_this = this;
					var id = $(this).val();

					$.get("{{ URL::to('/admin/get-ques-topic') }}/" + id, function(response){
						part_id = $(selector_this).parent().parent().data('id');
						selector_picker = $(selector_this).parent().find('.selectpicker');
						$(selector_picker).html('').selectpicker('refresh');
						$.each(response,function(i,val){
							$(selector_picker).append(`<option value="`+response[i].question_id+`">`+response[i].question_content+`</option>`);
						});
						$(selector_picker).selectpicker('refresh');
					});
				});
				//khi đổi số topic
				$('.amount_topic').change(function(){
					part = $(this).data('id');
					val = $(this).val();
					//reset 
					$('#add_part_'+part).each(function(i,val){
						selector_div = $(this).children('div');
						$(selector_div).each(function(j, val_div){
							if ($(val_div).css('display') == 'block') {
								$(val_div).css('display','none');
							}
						})
					});
					$('#part_'+part+'_'+val).css('display','block');
					$('#add_part_'+part).css('display','block');		

					//disable topic đã chọn
					selector_topic = $(this).next().next().find('.part_topic');
					$(selector_topic).each(function(k,v){
						if ($(v).val() != "") {
							ar_topic.push($(v).val());
						}
					});

					
					select_tp = $('#part_'+part+'_'+val).find('.part_topic').find('option');
					$(select_tp).each(function(i,v){
						if (ar_topic.includes($(v).val())) {
							$(v).prop('disabled',true);
						}else{
							$(v).prop('disabled',false);
						}
					});
					$('#part_'+part+'_'+val).find('.part_topic').find(':selected').prop('disabled',false);
					$('#part_'+part+'_'+val).find('.part_topic').find('option:first-child').prop('disabled',true);
					val_tmp = $('#part_'+part+'_'+val).find('.part_topic').val();
					ar_topic.splice(ar_topic.indexOf(val_tmp));
				});

				//khi chọn câu hỏi
				myChoices = new Array();
				$(document).on('changed.bs.select','.selectpicker', function (e, clickedIndex, newValue, oldValue) {
					var selected = this.options[clickedIndex].value;
					if (myChoices.indexOf(selected) == -1) {
						myChoices.push(selected);
					} else {
						myChoices.splice(myChoices.indexOf(selected), 1);
					}
				});

				//khi bấm gửi
				$('[type="submit"]').click(function(e){
					
					err = new Array();
					arr_question = new Array();
					$('.part_topic').each(function(i,val){
						no = $(this).parent().attr('data-no');
						//nếu chưa chọn đủ topic
						if ($(this).val() == null) {
							
							err.push("Please could you chose Topic "+no+" in "+$(val).parent().parent().prev().html()+" "+$(val).parent().parent().data('skill'));
							
						}
						//đủ topic
						else{
							selector_ques = $(val).parent().find('.selectpicker');
							part_ques = $(val).parent().parent().attr('data-ques');

							//chưa chọn câu hỏi
							if ($(selector_ques).val() == null) {
								
								err.push("Question is empty for Topic "+no+" in "+$(val).parent().parent().prev().html()+" "+$(val).parent().parent().data('skill'));
								
							}else{
								//chưa chọn đủ câu hỏi
								if ($(selector_ques).val().length != part_ques) {
									
									err.push("Only use "+part_ques+" question for Topic "+no+" in "+$(val).parent().parent().prev().html()+" "+$(val).parent().parent().data('skill'));
									
								}

								$(selector_ques.val()).each(function(k,value){
									arr_question.push(value);
								})
							}
						}
					});
					
					if(err.length > 0){
						e.preventDefault();
						Swal.fire({
							position: 'top-end',
							toast: true,
							icon: 'info',
							title: err.toString().replaceAll(",","<br><br>"),
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						})
					}

					$('[name="question_id"]').val(myChoices.length == arr_question.length ? myChoices : arr_question);
				});
			});
		</script>

		@endsection