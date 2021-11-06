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
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>UPDATE LESSON</h2>
	</div>

	<div class="forms-grids">
		<div class="w3agile-validation">
			{{-- thông báo lỗi validate --}}
			@if(session()->has('error'))
			<div class="alert alert-danger" style="background-color: #F2D4D8; color: red;font-size: 14px;font-weight: bold; list-style:none;">
				@if(is_array(session()->get('error')))
				@foreach(session()->get('error') as $err)
				@if(is_array($err))
				@foreach($err as $err_s)
				<li>{{ $err_s[0] }}</li>
				@endforeach
				@else
				<li>{{ $err }}</li>
				@endif
				@endforeach
				@else
				<li>{{ session()->get('error') }}</li>
				@endif
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
					<form method="post" action="{{URL::to('/admin/update-lesson-control/'.$lesson->lesson_id)}}" >
						@csrf
						<div class="input-info">
							<h3>Edit Lesson</h3>
						</div>
						<input type="hidden" name="_method" value="put" />
						<input type="hidden" name="question_id">
						<label for="field-2">Structure: <span class="at-required-highlight">*</span></label>
						<div class="form-group">
							<input type="hidden" name="filter_id" value="{{ $lesson->filter_id }}">
							<select name="filter_id" disabled class="form-control">
								<option value="{{ $lesson->filter_id }}" selected>{{ $filter_name }}</option>
							</select>
						</div>
						<label for="field-2">Skill: <span class="at-required-highlight">*</span></label>
						<div class="form-group skill_all" style="display:flex;">
							@foreach($skills as $skill)
							<div style="width:25%;">
								<button type="button" class="btn btn-info btn_skill">{{ $skill }}</button>
							</div>
							@endforeach
						</div>
						
						@if(isset($data_part))

						@foreach($data_part as $key => $info)
						<div id="skill_{{ $key }}" class="skill_part" data-skill="{{ $key }}" @if(count($info) == 0) style="display:none;" @endif>

							@foreach($info as $detail)

							<div id="div_part_{{ $detail[0] }}" data-part="{{ $detail[0] }}" style="display:none;">
								<select class="amount_topic">
									@for($i = 0; $i < $detail[3]; $i++)
									<option value="{{ $i+1 }}" @if($i == 0) selected @endif>Topic {{ $i+1 }}</option>
									@endfor
								</select>
								<h4 style="display: inline;margin-left: 5px">{{ $detail[1] }}.</h4><br>

								@for($i = 0; $i < $detail[3]; $i++)

								<div id="part_{{ $detail[0] }}_{{ $i+1 }}" data-index="{{ $i+1 }}" data-ques="{{ $detail[2] }}" @if($i != 0) style="display:none;" @endif>
									@php $topic1 = $detail[4][$i] @endphp
									<label for="field-2">Topic: <span class="at-required-highlight">*</span></label>
									<select name="topic" class="form-control">
										<option value="" disabled selected>Chose Topic here</option>
										@foreach($detail[4] as $j => $topic)
										@if((isset($detail[4][$j][2]) && !is_array($detail[4][$j][2]) && !isset($selected)))
										<option value="{{ $topic[0] }}" {{ $selected = 'selected' }} >{{ $detail[4][$j][1] }}</option>
										@php $key_topic = $j @endphp
										@php unset($detail[4][$j][2]) @endphp
										
										@else
										<option value="{{ $topic[0] }}" >{{ $detail[4][$j][1] }}</option>
										@endif
										@endforeach
										@php unset($selected) @endphp
									</select>

									<label for="field-2">Question: <span class="at-required-highlight">*</span></label>

									<select class="selectpicker form-control" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Selected ({0}/{{ $detail[2]}})" data-live-search="true">

										@if(isset($key_topic))

										@foreach($detail[4][$key_topic] as $k => $questions)
										@if(is_array($questions))
										<option value="{{ $questions[0] }}" @if(isset($questions[2])) selected @endif>{{ $questions[1] }}</option>	
										@endif			
										@endforeach

										@endif

									</select><br><br>

								</div>

								@endfor
							</div>
							@endforeach
						</div>
						
						@php unset($key_topic) @endphp
						@endforeach

						@endif
						<p>
							<br><input type="submit" value="Update" class="btn btn-primary">
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

		@if(!isset($data_part))
		<script>
			Swal.fire({
				title: "Please insert 1 of 4 skills basic: Listening, Reading, Writting, Speaking!",
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
		</script>

		@endif

		<script>
			$(document).ready(function(){
				$('.selectpicker').selectpicker();
				question = new Array();
				topic = new Array();

				//lấy dữ liệu topic đã chọn
				$('[name="topic"]').each(function(i,v){		
					if ($(v).val() == null) {
						$(v).parent().find('.selectpicker').html('').selectpicker('refresh');
					}else{
						topic.push($(v).val());
					}
				});

				//lấy dữ liệu câu hỏi đã chọn
				$('.selectpicker').each(function(i,v){
					$($(v).val()).each(function(j, val){
						question.push(val);
					});
				});

				//check kỹ năng của cấu trúc
				$('.skill_part').each(function(i, v){
					if ($(v).css('display') == 'none') {
						skill = $(this).data('skill');
						$('.btn_skill').each(function(j, val){
							if($(val).html() == skill){
								$(val).prop('disabled',true);
							}
						});
					}
				});

				//khi chọn kỹ năng
				$('.btn_skill').click(function(i,v){
					skill = $(this).html();
					//reset
					$('.skill_part').each(function(j,val){
						if ($(val).children('div').css('display') == 'block') {
							$(val).children('div').css('display','none');
						}
					});
					$('#skill_'+skill).children('div').css('display','block');

					//disable topic đã được chọn
					$($('#skill_'+skill).children('div')).each(function(k, pt){
						part = $(pt).data('part');
						index = $(pt).find('.amount_topic').val();

						$($('#part_'+part+'_'+index).find('[name="topic"]').find('option')).each(function(h,op){
							if ($(op).is(':selected') && topic.includes($(op).val())) {
								$(op).prop('disabled',false);
							}else if(!$(op).is(':selected') && !topic.includes($(op).val()) && ($(op).val() != "")){
								$(op).prop('disabled',false);
							}else if((topic.includes($(op).val()) && !$(op).is(':selected')) || ($(op).val() == "")){
								$(op).prop('disabled',true);
							}
						});
					})
				});

				//khi thay đổi topic
				$('[name="topic"]').change(function(){
					selector_ques = $(this).parent().find('.selectpicker');
					//reset
					$($(selector_ques).val()).each(function(i,v){
						if (question.indexOf(v) != -1) {
							question.splice(question.indexOf(v), 1);
						}
					});
					$(selector_ques).html('');
					$(selector_ques).val('default').selectpicker('refresh');
					id = $(this).val();
					$.get("{{ URL::to('/admin/get-ques-topic') }}/" + id, function(response){
						$.each(response,function(i,v){
							$(selector_ques).append(`<option value="`+response[i].question_id+`">`+response[i].question_content+`</option>`);
						});
						$(selector_ques).selectpicker('refresh');
					});
					
					pos = $(this).index('[name="topic"]');
					
					topic.splice(pos, 1);
					topic.splice(pos ,0, id);
					
				});

				//khi chọn số topic
				$('.amount_topic').change(function(){
					index = $(this).val();
					part = $(this).parent().data('part');
					selector_part_i = $(this).parent().children('div');
					//reset
					$(selector_part_i).each(function(i,v){
						if ($(v).css('display') == 'block') {
							$(v).css('display','none');
						}
					});
					$('#part_'+part+'_'+index).css('display','block');

					value = $('#part_'+part+'_'+index).find('[name="topic"]').val();
					
					$($('#part_'+part+'_'+index).find('[name="topic"]').find('option')).each(function(h,op){
						if ($(op).is(':selected') && topic.includes($(op).val())) {
							$(op).prop('disabled',false);
						}else if(!$(op).is(':selected') && !topic.includes($(op).val()) && ($(op).val() != "")){
							$(op).prop('disabled',false);
						}else if((topic.includes($(op).val()) && !$(op).is(':selected')) || ($(op).val() == "")){
							$(op).prop('disabled',true);
						}
					});	
					
				});

				//khi chọn câu hỏi
				$('.selectpicker').on('changed.bs.select',function(e,clickedIndex){
					select = this.options[clickedIndex].value;
					if (question.indexOf(select) == -1) {
						question.push(select);
					}else{
						question.splice(question.indexOf(select), 1);
					}
					
				});

				//khi nhấn gửi
				$('[type="submit"]').click(function(e){

					err = new Array();
					arr_question = new Array();
					$('.selectpicker').each(function(i,v){
						value_tp = $(v).parent().parent().find('[name="topic"]').val();
						//nếu chưa có topic
						if (value_tp == null) {
							
							err.push("Please could you chose Topic "+$(v).parent().parent().data('index')+" in "+$(v).parent().parent().parent().find('h4').html()+" "+$(v).parent().parent().parent().parent().data('skill'));
							
						}else{
							//nếu câu hỏi rỗng
							if ($(v).val() == null) {
								
								err.push("Question is empty in Topic "+$(v).parent().parent().data('index')+" "+$(v).parent().parent().parent().find('h4').html()+" "+$(v).parent().parent().parent().parent().data('skill'));
								
							}
						//có chọn câu hỏi
						else{
							ques_amount = $(v).parent().parent().data('ques');
							if ($(v).val().length != ques_amount) {
								
								err.push("Only use "+ques_amount+" question in Topic "+$(v).parent().parent().data('index')+" "+$(v).parent().parent().parent().find('h4').html()+" "+$(v).parent().parent().parent().parent().data('skill'));
								
							}

							$($(v).val()).each(function(k,value){
								arr_question.push(value);
								
							})
						}
					}
				});

					if (err.length > 0) {
						e.preventDefault();
						str = err.toString();
						Swal.fire({
							position: 'top-end',
							toast: true,
							icon: 'info',
							title: str.replaceAll(",","<br><br>"),
							showConfirmButton: true,
							confirmButtonColor: '#00bcd4',
						})
					}
					$('[name="question_id"]').val(question.length == arr_question.length ? question : arr_question);
					
				});
			});
		</script>
		@endsection