@extends('welcome')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <style>
        body {
  background-color: #dddd;
  color: #444444;
  font-family: 'Roboto', sans-serif;
  font-size: 16px;
  font-weight: 300;
  margin: 0;
  padding: 0;
}
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
@keyframes click-radio-wave {
  0% {
    width: 25px;
    height: 25px;
    opacity: 0.35;
    position: relative;
  }
  100% {
    width: 60px;
    height: 60px;
    margin-left: -15px;
    margin-top: -15px;
    opacity: 0.0;
  }
}
@media screen and (max-width: 767px) {
  .wizard-content-left {
    height: auto;
  }
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
    background-color: white;
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

    </style>
    <div class="all-title-box">
        <div class="container text-center">
            <h1> Test Level 1<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
        </div>
    </div>
    <div class="containerAnswer container mt-sm-5 my-1">
    <section class="wizard-section">
        <div class="form-wizard">
            <form id="result_level" action="{{URL::to('/results-level-test')}}" method="post" role="form">
              @csrf
                <div class="form-wizard-header ">
                    <h2><p>Fill all form field to go next step</p></h2>
                    <ul class="list-unstyled form-wizard-steps clearfix wrap">

                        <li class="active"><span>1</span></li>
                        <li><span>2</span></li>
                        <li><span>3</span></li>
                        
                       
                    </ul>
                </div>
                <fieldset class="wizard-fieldset show">
                   
                    <section>
                        <h2 class="part-number"> PART 1</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear EIGHT short announcements or instructions. There is one question for each announcement or instruction. For each question, choose the right answer A, B, C or D. Then, on the answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer that you have chosen. </span>
                        </div>
                        
                        <?php
                            $i=1;
                            $ans1 = array("(A)","(B)","(C)","(D)" );
                            
                           
                            
                        ?>
                        
                    

                        {{-- <?php
                               print_r($all_listen_test_part1) ;
                            ?> --}}
                        {{-- <script>   
                          let arrAudio_part1 = [];
                        </script> --}}
                        {{-- @foreach($detail_filter as $k => $detail_filters)
                            <span  class="question-num"><?php
                                   
                                    //echo $all_listen_test_part1s->question_id ;
                                    echo $detail_filters->part_name.' : '.$detail_filters->filter_part_amount_topic.'<br>';
                                ?>
                            </span>
                            
                        @endforeach --}}
                        @foreach($all_part1 as $k => $all_part1s)
                        
                        
                        <div class="mcq-wrapper " id="mau">
                            <span  class="question-num"><?php
                                    echo $i.'.';
                                    $i++;
                                    //echo $all_listen_test_part1s->question_id ;
                                    //echo $detail_filters->part_name.' : '.$detail_filters->filter_part_amount_topic.'<br>';
                                ?>
                            </span>
                            
                            <div >
                                <span>Click on the play button to play a sound:</span> 
                                <audio controls >   
                                   
                                  {{--   <source src="horse.ogg" type="audio/ogg"> --}}
                                    <source src="{{asset('/uploads/audio/'.$all_part1s->topic_audio)}}" type="audio/mpeg">
                                    <source src="{{asset('/uploads/audio/'.$all_part1s->topic_audio)}}" type="audio/ogg">
                                    
                                </audio>
                            
                            </div>
                            <span class="question-content empty-question-content">{{$all_part1s->question_content}}</span>
                            {{-- <div class="options-wrapper">
                                @foreach($all_answer as $key => $answers)
                                <div class="option ">
                                   @if($all_read_test_part1s->question_id==$answers->question_id)
                                        <input id="{{$answers->answer_id}}" type='radio' name="name[{{$all_read_test_part1s->question_id}}]" value="{{$answers->answer_id}}" />
                                        <label for="{{$answers->answer_id}}">{{$ans1[$index++].' '.$answers->answer_content}}
                                        </label>
                                    @endif
                                </div>
                                @endforeach
                                
                            </div> --}}
                            <br>

                            
                           

                        </div>

                        @endforeach

                      
                        <script >
                          // for(var i = 0 ;i<=arrAudio_part1.length; i++) {
                          //   // arrAudio_part1[i];
                          //   //var au = document.getElementById(arrAudio_part1[i]);

                           
                            
                          //   au.onended =function(){
                          //     i++;
                          //     var au = document.getElementById(arrAudio_part1[i]);
                          //   au.play()
                          //    callback();
                          //   };

                          // }
                        </script>
                      
                    </section>
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                    </div>
                </fieldset> 

                <fieldset class="wizard-fieldset">
                   
                   <section>
                        <h2 class="part-number"> PART 2</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear THREE conversations. The conversations will not be repeated. There are four questions for each conversation. For each question, choose the correct answer A, B, C or D.
                                <br>
                            Questions 9 to 12 refer to the following conversation.</span>
                        </div>
                        <?php
                        $i=7;
                        $ans = array("(A)","(B)","(C)" );
                        ?>
                        @foreach($all_part2 as $key => $all_part2s)
                        <div class="mcq-wrapper">
                            <span class="question-num"><?php
                                    echo $i.'.';
                                    $i++;
                                ?></span>
                                <div >
                                <span>Click on the play button to play a sound:</span> 
                                <audio controls >   
                                   
                                  {{--   <source src="horse.ogg" type="audio/ogg"> --}}
                                    <source src="{{asset('/uploads/audio/'.$all_part1s->topic_audio)}}" type="audio/mpeg">
                                    <source src="{{asset('/uploads/audio/'.$all_part1s->topic_audio)}}" type="audio/ogg">
                                    
                                </audio>
                            
                            </div>
                            <span class="question-content empty-question-content">{{$all_part1s->question_content}}</span>
                            <br>
                            <div class="options-wrapper">
                                {{-- <?php $index=0; ?>
                                @foreach($all_answer as $key => $answers)
                                <div class="option">
                                    @if($all_listen_test_part2s->question_id==$answers->question_id)
                                        <input value="{{$answers->answer_id}}" type='radio' name="name[{{$all_listen_test_part2s->question_id}}]" id="id[{{$answers->answer_id}}]"  />
                                        <label for="id[{{$answers->answer_id}}]">{{$ans[$index++].' '.$answers->answer_content}}
                                        </label>
                                    @endif
                                </div>
                                @endforeach --}}
                            </div>
                        </div>
                        @endforeach
                    </section>

                    <section>
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                    </div>
                </fieldset> 
                <fieldset class="wizard-fieldset">
                    <section>
                        <h2 class="part-number"> PART 3</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>Directions: In this part, you will hear THREE talks or lectures. The talks or lectures will not be repeated. There are five questions for each talk or lecture. For each question, choose the right answer A, B, C or D. 
                            <br>
                            Questions 21 to 25 refer to the following lecture. Listen to part of a lecture in a psychology class.</span>
                        </div>
                        <?php
                        $i=32;
                        ?>
                       {{--   @foreach($audio_content_p3 as $key => $audio_content_p3s)
                         <div>
                         <div class="audio_part">
                            <audio controls >
                                <source src="{{asset('/uploads/audio/'.$audio_content_p3s->audio_content)}}" type="audio/mpeg">
                                <source src="{{asset('/uploads/audio/'.$audio_content_p3s->audio_content)}}" type="audio/ogg">
                            </audio>
                          </div>
                          <?php $temp_3=0; ?>
                         @foreach($all_listen_test_part3 as $key => $all_listen_test_part3s)
                         
                          @if($audio_content_p3s->audio_id==$all_listen_test_part3s->audio_id)
                        
                        <?php if($temp_3==3) break; ?>
                        
                        <div class="mcq-wrapper">
                            <span class="question-num"><?php echo $i.'.'; $i++; ?></span>
                              
                            <span class="question-content empty-question-content">{{$all_listen_test_part3s->question_content}}</span>
                            <div class="options-wrapper">
                                <?php $index=0; ?>
                                @foreach($all_answer as $key => $answers)
                                <div class="option">
                                    @if($all_listen_test_part3s->question_id==$answers->question_id)
                                        <input value="{{$answers->answer_id}}" type='radio' name="name[{{$all_listen_test_part3s->question_id}}]" id="id[{{$answers->answer_id}}]"   />
                                        <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}
                                        </label>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <?php  $temp_3++;  ?>
                            @endif  
                           @endforeach
                         </div>
                         @endforeach --}}
                    </section>
                   
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                         <a href="" ><button  class="form-wizard-submit float-right">Submit  </button> </a>
                        {{-- <a href="" class="form-wizard-submit float-right">Submit</a> --}}
                    </div>
                </fieldset> 
                
                
            </form>
        </div>

    </section>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
</body>
</html>
@endsection
