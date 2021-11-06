@extends('welcome')
@section('content')
<style>

.wizard-content-left {
  background-blend-mode: darken;
  background-color: rgba(0, 0, 0, 0.45);
  background-image: url("https://i.ibb.co/X292hJF/form-wizard-bg-2.jpg");
  background-position: center center;
  background-size: cover;
  height: 100vh;
  padding: 30px;
}
.wizard-content-left h1 {
  color: #ffffff;
  font-size: 38px;
  font-weight: 600;
  padding: 12px 20px;
  text-align: center;
}

.form-wizard {
  color: #00000;
  padding: 30px;
}
.form-wizard .wizard-form-radio {
  display: inline-block;
  margin-left: 5px;
  position: relative;
}
.form-wizard .wizard-form-radio input[type="radio"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  -ms-appearance: none;
  -o-appearance: none;
  appearance: none;
  background-color: #dddddd;
  height: 25px;
  width: 25px;
  display: inline-block;
  vertical-align: middle;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
}
.form-wizard .wizard-form-radio input[type="radio"]:focus {
  outline: 0;
}
.form-wizard .wizard-form-radio input[type="radio"]:checked {
  background-color: #fb1647;
}
.form-wizard .wizard-form-radio input[type="radio"]:checked::before {
  content: "";
  position: absolute;
  width: 10px;
  height: 10px;
  display: inline-block;
  background-color: #ffffff;
  border-radius: 50%;
  left: 1px;
  right: 0;
  margin: 0 auto;
  top: 8px;
}
.form-wizard .wizard-form-radio input[type="radio"]:checked::after {
  content: "";
  display: inline-block;
  webkit-animation: click-radio-wave 0.65s;
  -moz-animation: click-radio-wave 0.65s;
  animation: click-radio-wave 0.65s;
  background: #000000;
  content: '';
  display: block;
  position: relative;
  z-index: 100;
  border-radius: 50%;
}
.form-wizard .wizard-form-radio input[type="radio"] ~ label {
  padding-left: 10px;
  cursor: pointer;
}
.form-wizard .form-wizard-header {
  text-align: center;
  align-items: center;
}

.form-wizard .form-wizard-next-btn, .form-wizard .form-wizard-previous-btn, .form-wizard .form-wizard-submit {
  background-color: #4c5a7d;
  color: #ffffff;
  display: inline-block;
  min-width: 100px;
  min-width: 120px;
  padding: 10px;
  text-align: center;
}
.form-wizard .form-wizard-next-btn:hover, .form-wizard .form-wizard-next-btn:focus, .form-wizard .form-wizard-previous-btn:hover, .form-wizard .form-wizard-previous-btn:focus, .form-wizard .form-wizard-submit:hover, .form-wizard .form-wizard-submit:focus {
  color: #ffffff;
  opacity: 0.6;
  text-decoration: none;
}
.form-wizard .wizard-fieldset {
  display: none;
}
.form-wizard .wizard-fieldset.show {
  display: block;
}
.form-wizard .wizard-form-error {
  display: none;
  background-color: #d70b0b;
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  height: 2px;
  width: 100%;
}
.form-wizard .form-wizard-previous-btn {
  background-color: #4c5a7d;
}
.form-wizard .form-control {
  font-weight: 300;
  height: auto !important;
  padding: 15px;
  color: #888888;
  background-color: #f1f1f1;
  border: none;
}
.form-wizard .form-control:focus {
  box-shadow: none;
}
.form-wizard .form-group {
  position: relative;
  margin: 25px 0;
}
.form-wizard .wizard-form-text-label {
  position: absolute;
  left: 10px;
  top: 16px;
  transition: 0.2s linear all;
}
.form-wizard .focus-input .wizard-form-text-label {
  color: #d65470;
  top: -18px;
  transition: 0.2s linear all;
  font-size: 12px;
}
.form-wizard .form-wizard-steps {
  margin: auto;
  align-content: center;
  align-items: center;
  margin-bottom: 15px;
}
.form-wizard .form-wizard-steps li {
  width: 12%;
  float: left;
  position: relative;
}
.form-wizard .form-wizard-steps li::after {
  background-color: #f3f3f3;
  content: "";
  height: 5px;
  left: 0;
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
  border-bottom: 1px solid #dddddd;
  border-top: 1px solid #dddddd;
}
.form-wizard .form-wizard-steps li span {
  background-color: #dddddd;
  border-radius: 50%;
  display: inline-block;
  height: 70px;
  line-height: 70px;
  position: relative;
  text-align: center;
  width: 70px;
  z-index: 1;
  font-weight: bold;
  font-size: 25px;
}
.form-wizard .form-wizard-steps li:last-child::after {
  width: 50%;
}
.form-wizard .form-wizard-steps li.active span, .form-wizard .form-wizard-steps li.activated span {
  background-color: #4c5a7d;
  color: #ffffff;
}
.form-wizard .form-wizard-steps li.active::after, .form-wizard .form-wizard-steps li.activated::after {
  background-color: #4c5a7d;
  left: 50%;
  width: 50%;
  border-color: #4c5a7d;
}
.form-wizard .form-wizard-steps li.activated::after {
  width: 100%;
  border-color: #4c5a7d;
}
.form-wizard .form-wizard-steps li:last-child::after {
  left: 0;
}
.form-wizard .wizard-password-eye {
  position: absolute;
  right: 32px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}

.mcq-wrapper{
    margin-bottom: 30px;
    display: inline-block;
    vertical-align: top;
    width: 48%;
    max-width: 50%;
    padding: 10px 15px;
} 
.containerAnswer {
    background-color: #fdfcfc;
    border: 2px solid #9298b6;
    color: black;
    border-radius: 10px;
    padding: 20px;
    font-family: 'Montserrat', sans-serif;
    max-width: 1200px 
    
}
.part-number{
    margin-bottom: 20px;
    text-align: left;
    font-weight: bold; 
    font-size: 30px;
    text-decoration: underline;  
}
.audio_part{
  text-align: center;
}
.wrap
{
    display: flex;
    justify-content: center;

}
.au{

    text-align: center;
}
.ques
{
    font-weight: bold;
}
.option{
    margin-left: 20px;
}
.topic{
    border-radius: 5px;
    border: 1px solid black;
}
.ans_true{
    background-color: green;
}
.ans_false{
    background-color: orange;
}


</style>
{{-- <?php
    var_dump($all_ans_listen);
?>
--}}    

<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">List Test</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mark</li>
    </ol>
</nav>

<div style="font-size: 30px; color: #4c5a7d; margin-top: 20px" >
    <b><center>Mark</center></b>
</div>

<div style ="text-align:center;" class="mt-3">
    @foreach($data as $skill => $data_skill)
        @if(!empty($data_skill))
            <button type="button" class="btn btn-primary show_{{ $skill }}"> {{ $skill }} </button>
        @endif
    @endforeach
</div>

<form action="{{ URL::to('/update-mark/'.$result_id) }}" method="post" id="form_mark">@csrf
    <input type="hidden" name="_method" value="put" />
    <input type="hidden" name="teacher_id" value="{{ session()->get('id_gv') }}">
    <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">

    <div id='form_writting' class="containerAnswer container mt-sm-5 my-1">
        <section class="wizard-section">
            <div class="form-wizard">
                <div class="form-wizard-header ">
                    <h2><p >Writing test</p></h2>
                    <ul class="list-unstyled form-wizard-steps clearfix wrap">
                        @foreach($data['Writting'] as $key_part => $part)

                        <li @if($key_part == 0) class="active" @endif><span style="font-size: 14px">{{ $part['part_name'] }}</span></li>

                        @endforeach   
                    </ul>
                </div>
                @php
                $a =1;
                $num_part = count($data['Writting']);
                $i = 1;
                @endphp
                @foreach($data['Writting'] as $key => $all_part_write)

                <fieldset class="wizard-fieldset @if($key == 0) show  @endif">

                    <section>
                        <h2 class="part-number">{{  $all_part_write['part_name']  }}</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            @if($all_part_write['part_des'] != null)
                                <span><b>{!! $all_part_write['part_des'] !!}</b></span>
                            @endif
                        </div>

                        
                     @foreach($data['Writting'][$key]['topic'] as $key_topic => $all_topic_write)

                        <div style="margin-top: 10px">
                            <div class="reading-text-wrapper text-en" data-part="{{ $all_part_write['part_name'] }}" data-skill="Writting">
                                <div class="paragraph-p7 topic">
                                    <p class="reading-text-paragraph ques" style="text-align:center"><span class="paragraph-sentence">{{ $all_topic_write['topic_name'] }}</span></p>
                                    <p class="reading-text-paragraph"><span class="paragraph-sentence">{!! $all_topic_write['topic_content'] !!}</span></p>

                                    @if($all_topic_write['topic_image'] != null)
                                        <img  style="text-align:center;  " align="center" width="75%" height="75%" src="/file/image/{{ $all_topic_write['topic_image'] }}" alt="">
                                    @endif

                                </div>
                            </div>
                            <br>

                            @foreach($data['Writting'][$key]['topic'][$key_topic]['questions'] as $key_ques => $all_ques_write)

                            <div class="">
                                <span class="question-num"> @php echo $i++; @endphp</span>
                                <span class="question-content ">{{ $all_ques_write['question_content'] }}</span>
                                
                                <textarea class="tiny"> {!! $all_ques_write['ans_task'] !!}</textarea>

                                <br><label class="form-label" for="textAreaExample">Teacher's comment:</label>
                                <textarea name="note_{{ $all_ques_write['question_id'] }}" class="form-control" cols="5" rows="5" style="background:#fff;border:1px solid black">@if($all_ques_write['note'] !== null){{ $all_ques_write['note'] }}@endif</textarea>

                                <br><label>Mark:</label>
                                <input type="number" name="mark_{{ $all_ques_write['question_id'] }}" min="0" max="{{ $all_ques_write['question_mark'] }}" step="any" class="form-control" @if($all_ques_write['mark'] !== null) value="{{ $all_ques_write['mark'] }}" @endif oninput="validity.valid||(value=0,1);" style="background-color: #fff;border:1px solid black">

                                <input type="hidden" name="question[]" value="{{ $all_ques_write['question_id'] }}">

                            </div>

                            @endforeach 

                            </div>
                            @endforeach
                        
                    </section>
                    <div class="form-group clearfix">

                        @if($a == $num_part)

                        @if(empty($data['Speaking']))

                        <button type="submit" class="form-wizard-submit float-right" >Submit</button>

                        @else

                        <button type="button" class="form-wizard-submit float-right show_Speaking"  >Speaking Test</button>

                        @endif

                        @elseif($a >= 1)

                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                        @endif 

                        @if($a > 1)

                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>

                        @endif
                    </div>
                </fieldset> 

                @php $a++ @endphp

                @endforeach

                @if(!empty($data['Speaking']))

                <button type="button" class="btn btn-primary show_Speaking"  >Speaking Test   </button>

                @endif
                
            </div>

        </section>

    </div>

    {{-- ===================================================== --}}

    <div id='form_speaking' class="containerAnswer container mt-sm-5 my-1">
        <section class="wizard-section">
            <div class="form-wizard">
                <div class="form-wizard-header ">
                    <h2><p >Speaking test</p></h2>
                    <ul class="list-unstyled form-wizard-steps clearfix wrap">
                        @foreach($data['Speaking'] as $key_part => $part)

                        <li @if($key_part == 0) class="active" @endif><span style="font-size: 14px">{{ $part['part_name'] }}</span></li>

                        @endforeach   
                    </ul>
                </div>

                @php
                $a =1;
                $num_part = count($data['Speaking']);
                $i = 1;
                @endphp

                @foreach($data['Speaking'] as $key => $all_part_speak)

                <fieldset class="wizard-fieldset @if($key == 0) show  @endif">

                    <section>
                        <h2 class="part-number"> {{$all_part_speak['part_name']}}</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            @if($all_part_speak['part_des'] != null)
                                <span><b>{!! $all_part_speak['part_des'] !!}</b></span>
                            @endif
                        </div>

                        
                      @foreach($data['Speaking'][$key]['topic'] as $key_topic => $all_topic_speak)
                    
                        <div style="margin-top: 10px">
                            <div class="reading-text-wrapper text-en" data-part="{{ $all_part_speak['part_name'] }}" data-skill="Speaking">
                                <div class="paragraph-p7 topic">
                                    <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{ $all_topic_speak['topic_name'] }}</span></p>
                                    <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{!! $all_topic_speak['topic_content'] !!}</span></p>

                                    @if($all_topic_speak['topic_image'] != null)
                                        <img  style="text-align:center;  " align="center" width="75%" height="75%" src="/file/image/{{ $all_topic_speak['topic_image'] }}" alt="">
                                    @endif

                                </div>

                            </div>
                            <br>

                            @foreach($data['Speaking'][$key]['topic'][$key_topic]['questions'] as $key_ques => $all_ques_speak)

                            <div class="mcq-wrapper">
                                <span class="question-num">  @php echo $i++; @endphp</span>
                                <span class="question-content ">{{$all_ques_speak['question_content']}}</span>
                                <br>

                                <audio src="/file/answer_record/{{ $all_ques_speak['ans_task'] }}" controls></audio>

                                <br><label class="form-label" for="textAreaExample">Teacher's comment:</label>
                                <textarea name="note_{{ $all_ques_speak['question_id'] }}" class="form-control" cols="5" rows="5" style="background:#fff; border:1px solid black">@if($all_ques_speak['note'] !== null){{ $all_ques_speak['note'] }}@endif</textarea>

                                <br><label>Mark:</label>
                                <input type="number" name="mark_{{ $all_ques_speak['question_id'] }}" min="0" max="{{ $all_ques_speak['question_mark'] }}" step="any" class="form-control" @if($all_ques_speak['mark'] !== null) value="{{ $all_ques_speak['mark'] }}" @endif oninput="validity.valid||(value=0,1);" style="background-color: #fff;border:1px solid black">

                                <input type="hidden" name="question[]" value="{{ $all_ques_speak['question_id'] }}">
                            </div>

                            @endforeach 
                            
                         </div>
                      @endforeach
                            
                        </section>
                        <div class="form-group clearfix">
                           @if($a == $num_part)

                           <button type="submit" class="form-wizard-submit float-right " >Submit</button>

                           @elseif($a >= 1)

                           <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>

                           @endif

                           @if($a > 1)

                           <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>

                           @endif
                       </div>

                   </fieldset>
                   @php $a++ @endphp 
                   @endforeach
               </div>
           </section>

       </div>
   </form>

   @endsection

   @section('javascript')

   <script type="text/javascript">
    $(document).ready(function(){
            //tinyMCE (quản lý soạn thảo văn bản cho thẻ <textarea>)
            tinymce.init({
                selector: 'textarea.tiny',
                plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
                readonly:true,
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

            
            $('#form_writting').hide()
            $('#form_speaking').hide()
        });
    $( '.show_Speaking' ).on('click',function(){

        $('#form_speaking').show(1000)
        $('#form_writting').hide();

    });

    $( '.show_Writting' ).on('click',function(){

        $('#form_speaking').hide()
        $('#form_writting').show(1000);
    });



</script>

<script>
    jQuery(document).ready(function() {
    // click on next button
    jQuery('.form-wizard-next-btn').click(function() {
        var parentFieldset = jQuery(this).parents('.wizard-fieldset');
        var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
        var next = jQuery(this);
        var nextWizardStep = true;
        parentFieldset.find('.wizard-required').each(function(){
            var thisValue = jQuery(this).val();

            if( thisValue == "") {
                jQuery(this).siblings(".wizard-form-error").slideDown();
                nextWizardStep = false;
            }
            else {
                jQuery(this).siblings(".wizard-form-error").slideUp();
            }
        });
        if( nextWizardStep) {
            next.parents('.wizard-fieldset').removeClass("show","400");
            currentActiveStep.removeClass('active').addClass('activated').next().addClass('active',"400");
            next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show","400");
            jQuery(document).find('.wizard-fieldset').each(function(){
                if(jQuery(this).hasClass('show')){
                    var formAtrr = jQuery(this).attr('data-tab-content');
                    jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
                        if(jQuery(this).attr('data-attr') == formAtrr){
                            jQuery(this).addClass('active');
                            var innerWidth = jQuery(this).innerWidth();
                            var position = jQuery(this).position();
                            jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
                        }else{
                            jQuery(this).removeClass('active');
                        }
                    });
                }
            });
        }
    });
    //click on previous button
    jQuery('.form-wizard-previous-btn').click(function() {
        var counter = parseInt(jQuery(".wizard-counter").text());;
        var prev =jQuery(this);
        var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
        prev.parents('.wizard-fieldset').removeClass("show","400");
        prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show","400");
        currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active',"400");
        jQuery(document).find('.wizard-fieldset').each(function(){
            if(jQuery(this).hasClass('show')){
                var formAtrr = jQuery(this).attr('data-tab-content');
                jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
                    if(jQuery(this).attr('data-attr') == formAtrr){
                        jQuery(this).addClass('active');
                        var innerWidth = jQuery(this).innerWidth();
                        var position = jQuery(this).position();
                        jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
                    }else{
                        jQuery(this).removeClass('active');
                    }
                });
            }
        });
    });
    //click on form submit button
    jQuery(document).on("click",".form-wizard .form-wizard-submit" , function(){
        var parentFieldset = jQuery(this).parents('.wizard-fieldset');
        var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
        parentFieldset.find('.wizard-required').each(function() {
            var thisValue = jQuery(this).val();
            if( thisValue == "" ) {
                jQuery(this).siblings(".wizard-form-error").slideDown();
            }
            else {
                jQuery(this).siblings(".wizard-form-error").slideUp();
            }
        });
    });

    $(document).on('click','[type="submit"]',function(e){
        err_ar = new Array();
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            title: 'Are you sure ?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'orange',
        }).then(function(result){
            if (result.isConfirmed) {

                $('[type="number"]').each(function(i,v){
                    if ($(v).val() == "") {

                        skill = $(v).parents().parents().children('.text-en').data('skill');
                        part = $(v).parents().parents().children('.text-en').data('part');
                        ques = $(v).parents().children('span:first').html().trim();
                        
                        err_ar.push("Mark is empty in question "+ ques +" " + part + " " + skill);
                    }
                });
                if (err_ar.length > 0) {
                    Swal.fire({
                        toast: true,
                        title: err_ar.toString().replaceAll(",","<br>"),
                        showConfirmButton: true,
                        confirmButtonColor: 'orange',
                        icon: 'error',
                        position: 'top-end',
                    })
                }else{
                    $('#form_mark').submit();
                }
           }
        })
    });

    // focus on input field check empty or not
    jQuery(".form-control").on('focus', function(){
        var tmpThis = jQuery(this).val();
        if(tmpThis == '' ) {
            jQuery(this).parent().addClass("focus-input");
        }
        else if(tmpThis !='' ){
            jQuery(this).parent().addClass("focus-input");
        }
    }).on('blur', function(){
        var tmpThis = jQuery(this).val();
        if(tmpThis == '' ) {
            jQuery(this).parent().removeClass("focus-input");
            jQuery(this).siblings('.wizard-form-error').slideDown("3000");
        }
        else if(tmpThis !='' ){
            jQuery(this).parent().addClass("focus-input");
            jQuery(this).siblings('.wizard-form-error').slideUp("3000");
        }
    });
});
</script>
@endsection