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
    .au{

    text-align: center;
}

    </style>
    <div class="all-title-box">
        <div class="container text-center">
            <h1> Exemple Test<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
        </div>
    </div>
    <form action="{{URL::to('/results-example-test')}}" method="post"  >
        @csrf
        <div id="form_listening" class="containerAnswer container mt-sm-5 my-1">
            <section class="wizard-section">    
            <div class="form-wizard">
                    <div class="form-wizard-header ">
                        <h1><p>Listening Test</p></h1>
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
                             
                            
                            <?php   $i=1;  $ans1 = array("(A)","(B)","(C)","(D)" );  ?>
                            
                            @foreach($all_part1 as $k => $all_part1s)
                            <div class="mcq-wrapper " id="mau">
                                <span  class="question-num"><?php echo $i.'.'; $i++; ?> </span>
                            
                                <div >
                                    <span>Click on the play button to play a sound:</span> 
                                    <audio controls >   
                                        <source src="/file/audio/{{ $all_part1s->topic_audio }}" type="audio/mpeg">
                                        <source src="/file/audio/{{ $all_part1s->topic_audio }}" type="audio/ogg">
                                        
                                    </audio>
                                
                                </div>
                                <span class="question-content empty-question-content">{{$all_part1s->question_content}}</span>
                                
                                <div class="options-wrapper">
                                    <?php $index=0; ?>
                                    @foreach($all_ans as $key => $answers)
                                    @if($all_part1s->question_id==$answers->question_id)
                                    <div class="option">
                                         
                                        
                                            <input value="{{$answers->answer_id}}" type='radio' name="name[{{$all_part1s->question_id}}]" id="id[{{$answers->answer_id}}]"  />
                                            <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}
                                            </label>
                                       
                                        
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                               
                                <br>
                            </div>
                            @endforeach
                          
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
                            @foreach($all_part2 as $k => $all_part2s)
                                <div class="py-2 h5 au ">
                                    <p>Click on the play button to play a sound:</p>
                                    
                                    <audio controls id="au2" >
                                       
                                  
                                        <source src="/file/audio/{{ $all_part2s['topic_audio'] }}" type="audio/mpeg">
                                        <source src="/file/audio/{{ $all_part2s['topic_audio'] }}" type="audio/ogg">
                                        <script>
                                            au2.onended = function() {
                                            var au3 = document.getElementById("au3");
                                            au3.play();
                                            };
                                            
                                        </script>
                                        
                                      
                                    </audio>
                                    
                                </div>
                           
                          
                            <?php $i=7; $dem=0; ?>

                            @foreach($all_ques as $k => $all_quess)
                            @if($all_quess->topic_id == $all_part2s->topic_id && $dem< $all_part2s->part_amount_ques_per_topic )
                            <?php $dem++; ?>
                            <div class="mcq-wrapper">

                                <span class="question-num"><?php echo $i.'.'; $i++; ?></span>
                                 
                                <span class="question-content empty-question-content">{{$all_quess->question_content}}</span>
                                <br>
                                <div class="options-wrapper">
                                    <?php $index=0; ?>
                                    @foreach($all_ans as $key => $answers)
                                    @if($all_quess->question_id==$answers->question_id)
                                    <div class="option">
                                        
                                            <input value="{{$answers->answer_id}}" type='radio' name="name[{{$all_quess->question_id}}]" id="id[{{$answers->answer_id}}]"  />
                                            <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}
                                            </label>
                                        
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                </div>
                            @endif
                            @endforeach
                            @endforeach
                       
                        </section>

                
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
                            @foreach($all_part3 as $k => $all_part3s)
                                <div class="py-2 h5 au ">
                                    <p>Click on the play button to play a sound:</p>
                                    
                                    <audio controls id="au2" >
                                       
                                        <source src="/file/audio/{{ $all_part3s->topic_audio }}" type="audio/mpeg">
                                        <source src="/file/audio/{{ $all_part3s->topic_audio }}" type="audio/ogg">
                            
                                        <script>
                                            au2.onended = function() {
                                            var au3 = document.getElementById("au3");
                                            au3.play();
                                            };
                                            
                                        </script>
                                        
                                      
                                    </audio>
                                    
                                </div>
                           
                          
                            <?php $i=7; $ans = array("(A)","(B)","(C)" ); $dem=0; ?>

                            @foreach($all_ques as $k => $all_quess)
                            @if($all_quess->topic_id == $all_part3s->topic_id && $dem< $all_part3s->part_amount_ques_per_topic )
                            <?php $dem++; ?>
                            <div class="mcq-wrapper">

                                <span class="question-num"><?php echo $i.'.'; $i++; ?></span>
                                 
                                <span class="question-content empty-question-content">{{$all_quess->question_content}}</span>
                                <br>
                                <div class="options-wrapper">
                                    <?php $index=0; ?>
                                    @foreach($all_ans as $key => $answers)
                                    @if($all_quess->question_id==$answers->question_id)
                                    <div class="option">
                                       
                                            <input value="{{$answers->answer_id}}" type='radio' name="name[{{$all_quess->question_id}}]" id="id[{{$answers->answer_id}}]"  />
                                            <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}
                                            </label>
                                        
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                </div>
                            @endif
                            @endforeach
                            @endforeach
                            
                        </section>
                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                            <button type="button" class="form-wizard-submit float-right show_read"  >Reading</button>
                             {{-- <a class="show_read" ><button  class="form-wizard-submit float-right">Submit  </button> </a> --}}
                            {{-- <a href="" class="form-wizard-submit float-right">Submit</a> --}}
                        </div>
                    </fieldset> 
                    <button type="button" class="btn btn-primary show_read"  > Reading </button>
                </div>
            </section>
        </div>


<div id='form_reading' class="containerAnswer container mt-sm-5 my-1" >
    <section class="wizard-section">
        <div class="form-wizard">
            
                <div class="form-wizard-header ">
                    <h2><p >Reading test</p></h2>
                    <ul class="list-unstyled form-wizard-steps clearfix wrap">

                        <li class="active"><span>1</span></li>
                        <li><span>2</span></li>
                        <li><span>3</span></li>
                        <li><span>4</span></li>                        
                       
                    </ul>
                </div>
                <fieldset class="wizard-fieldset show">
                   
                    <section>
                        <h2 class="part-number"> PASSAGE  1</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear EIGHT short announcements or instructions. There is one question for each announcement or instruction. For each question, choose the right answer A, B, C or D. Then, on the answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer that you have chosen. </span>
                        </div>

                            <div style="margin-top: 10px">
                            @foreach($all_read2 as $key => $all_read2s)
                                <div >
                                    <div><strong><h3><b>Questions 
                                        <?php
                                            $i=1;
                                            $j=10;
                                            echo $i.'-'.$j;
                                        ?></b></h3>
                                    </strong></div>
                                </div>
                                <div class="reading-text-wrapper text-en">
                                    <div class="paragraph-p7">
                                        <p class="reading-text-paragraph" style="text-align:center"><span  class="paragraph-sentence">{{$all_read2s->topic_name}}</span></p>
                                        <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_read2s->topic_content}}</span></p>
                                    </div>
                                   
                                </div>
                                @foreach($all_ques as $key => $all_quess)
                                @if($all_quess->topic_id==$all_read2s->topic_id)
                                <div class="mcq-wrapper">
                                    
                                        <span class="question-num"> 
                                            <?php
                                            echo $i;
                                            $i++;
                                            $index=0;
                                        ?></span>
                                        <span class="question-content ">{{$all_quess->question_content}}</span>
                                         
                                        <div class="options-wrapper">
                                            @foreach($all_ans as $key => $answers)
                                            @if($all_quess->question_id==$answers->question_id)
                                            <div class="option">
                                                
                                                <input id="id[{{$answers->answer_id}}]" type='radio' name="name1[{{$all_quess->question_id}}]" value="{{$answers->answer_id}}" />
                                                <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}</label>
                                                
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        
                                    
                                </div>
                                @endif
                                @endforeach 
                             @endforeach
                        </div>
                            </section>
                            <div class="form-group clearfix">
                                <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                            </div>
                        </fieldset> 

                        <fieldset class="wizard-fieldset">
                           
                           <section>
                                <h2 class="part-number"> PASSAGE  2</h2>
                                <div class="directions">
                                    <span class="directions-label">Directions:</span>
                                    <span>In this part, you will hear THREE conversations. The conversations will not be repeated. There are four questions for each conversation. For each question, choose the correct answer A, B, C or D.
                                        <br>
                                    Questions 9 to 12 refer to the following conversation.</span>
                                </div>
                                  <div style="margin-top: 10px">
                            @foreach($all_read1 as $key => $all_read1s)
                                <div >
                                    <div><strong><h3><b>Questions 
                                        <?php
                                            $i=1;
                                            $j=10;
                                            echo $i.'-'.$j;
                                        ?></b></h3>
                                    </strong></div>
                                </div>
                                <div class="reading-text-wrapper text-en">
                                    <div class="paragraph-p7">
                                        <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_read1s->topic_name}}</span></p>
                                        <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_read1s->topic_content}}</span></p>
                                    </div>
                                   
                                </div>
                                @foreach($all_ques as $key => $all_quess)
                                @if($all_quess->topic_id==$all_read1s->topic_id)
                                <div class="mcq-wrapper">
                                    
                                        <span class="question-num"> 
                                            <?php
                                            echo $i;
                                            $i++;
                                            $index=0;
                                        ?></span>
                                        <span class="question-content ">{{$all_quess->question_content}}</span>
                                         
                                        <div class="options-wrapper">
                                            @foreach($all_ans as $key => $answers)
                                            @if($all_quess->question_id==$answers->question_id)
                                            <div class="option">
                                                
                                                <input id="id[{{$answers->answer_id}}]" type='radio' name="name1[{{$all_quess->question_id}}]" value="{{$answers->answer_id}}" />
                                                <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}</label>
                                                
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        
                                    
                                </div>
                                @endif
                             @endforeach
                              @endforeach

                    </div>
                    </section>

            
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                    </div>
                </fieldset> 
                <fieldset class="wizard-fieldset">
                    <section>
                        <h2  class="part-number"> PASSAGE  3</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>Directions: In this part, you will hear THREE talks or lectures. The talks or lectures will not be repeated. There are five questions for each talk or lecture. For each question, choose the right answer A, B, C or D. 
                            <br>
                            Questions 21 to 25 refer to the following lecture. Listen to part of a lecture in a psychology class.</span>
                        </div>
                        
                        <div style="margin-top: 10px">
                            @foreach($all_read3 as $key => $all_read3s)
                                <div >
                                    <div><strong><h3><b>Questions 
                                        <?php
                                            $i=1;
                                            $j=10;
                                            echo $i.'-'.$j;
                                        ?></b></h3>
                                    </strong></div>
                                </div>
                                <div class="reading-text-wrapper text-en">
                                    <div class="paragraph-p7">
                                        <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_read3s->topic_name}}</span></p>
                                        <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_read3s->topic_content}}</span></p>
                                    </div>
                                   
                                </div>
                                @foreach($all_ques as $key => $all_quess)
                                @if($all_quess->topic_id==$all_read3s->topic_id)
                                <div class="mcq-wrapper">
                                    
                                        <span class="question-num"> 
                                            <?php
                                            echo $i;
                                            $i++;
                                            $index=0;
                                        ?></span>
                                        <span class="question-content ">{{$all_quess->question_content}}</span>
                                         
                                        <div class="options-wrapper">
                                            @foreach($all_ans as $key => $answers)
                                            @if($all_quess->question_id==$answers->question_id)
                                            <div class="option">
                                                
                                                <input id="id[{{$answers->answer_id}}]" type='radio' name="name1[{{$all_quess->question_id}}]" value="{{$answers->answer_id}}" />
                                                <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}</label>
                                                
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        
                                    
                                </div>
                                @endif
                                @endforeach 
                             @endforeach
                        </div>
                    </section>
                   
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                        {{-- <a href="" class="form-wizard-submit float-right">Submit</a> --}}
                    </div>
                </fieldset> 
                  <fieldset class="wizard-fieldset">
                    <section>
                        <h2  class="part-number"> PASSAGE  4</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>Directions: In this part, you will hear THREE talks or lectures. The talks or lectures will not be repeated. There are five questions for each talk or lecture. For each question, choose the right answer A, B, C or D. 
                            <br>
                            Questions 21 to 25 refer to the following lecture. Listen to part of a lecture in a psychology class.</span>
                        </div>
                        
                        <div style="margin-top: 10px">
                            @foreach($all_read4 as $key => $all_read4s)
                                <div >
                                    <div><strong><h3><b>Questions 
                                        <?php
                                            $i=1;
                                            $j=10;
                                            echo $i.'-'.$j;
                                        ?></b></h3>
                                    </strong></div>
                                </div>
                                <div class="reading-text-wrapper text-en">
                                    <div class="paragraph-p7">
                                        <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_read4s->topic_name}}</span></p>
                                        <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_read4s->topic_content}}</span></p>
                                    </div>
                                   
                                </div>
                                @foreach($all_ques as $key => $all_quess)
                                @if($all_quess->topic_id==$all_read4s->topic_id)
                                <div class="mcq-wrapper">
                                    
                                        <span class="question-num"> 
                                            <?php
                                            echo $i;
                                            $i++;
                                            $index=0;
                                        ?></span>
                                        <span class="question-content ">{{$all_quess->question_content}}</span>
                                         
                                        <div class="options-wrapper">
                                            @foreach($all_ans as $key => $answers)
                                            @if($all_quess->question_id==$answers->question_id)
                                            <div class="option">
                                                
                                                <input id="id[{{$answers->answer_id}}]" type='radio' name="name1[{{$all_quess->question_id}}]" value="{{$answers->answer_id}}" />
                                                <label for="id[{{$answers->answer_id}}]">{{$ans1[$index++].' '.$answers->answer_content}}</label>
                                                
                                            </div>
                                            @endif
                                            @endforeach
                                    
                                        </div>
                                        
                                </div>
                                @endif
                                @endforeach 
                             @endforeach
                        </div>
                    </section>
                   
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                         <button type="button" class="form-wizard-submit float-right show_write"  >Writing</button>
                        {{-- <a href="" class="form-wizard-submit float-right">Submit</a> --}}
                    </div>
                </fieldset> 
                
      
             <button type="button" class="btn btn-primary show_write"  >
                    Writing
                </button>
                
            </div>

    </section>

    
</div>



<div id='form_writing' class="containerAnswer container mt-sm-5 my-1">
    <section class="wizard-section">
        <div class="form-wizard">
            <div class="form-wizard-header ">
                <h2><p >Writing test</p></h2>
                <ul class="list-unstyled form-wizard-steps clearfix wrap">
                    <li class="active"><span>1</span></li>
                    <li><span>2</span></li>
                </ul>
            </div>
                <fieldset class="wizard-fieldset show">
                    <section>
                        <h2 class="part-number"> TASK 1</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear EIGHT short announcements or instructions. There is one question for each announcement or instruction. For each question, choose the right answer A, B, C or D. Then, on the answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer that you have chosen. </span>
                        </div>

                        <div style="margin-top: 10px">
                        @foreach($all_write1 as $key => $all_write1s)
                            
                            <div class="reading-text-wrapper text-en">
                                <div class="paragraph-p7">
                                    <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_write1s->topic_name}}</span></p>
                                    <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_write1s->topic_content}}</span></p>
                                </div>
                            </div>
                            @foreach($all_ques as $key => $all_quess)
                            @if($all_quess->topic_id==$all_write1s->topic_id)
                            <div class="">
                                <span class="question-num"> <?php echo $i; $i++; $index=0; ?></span>
                                <span class="question-content ">{{$all_quess->question_content}}</span>
                                <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                    <div class="d-flex flex-start w-100">
                                      <img
                                        class="rounded-circle shadow-1-strong me-3"
                                        src="https://mdbootstrap.com/img/Photos/Avatars/img%20(19).jpg"
                                        alt="avatar"
                                        width="40"
                                        height="40"
                                      />
                                      <div class="form-outline w-100">
                                        <textarea
                                          class="form-control"
                                          id="textAreaExample"
                                          rows="4"
                                          style="background: #fff;"
                                        ></textarea>
                                        <label class="form-label" for="textAreaExample">Message</label>
                                      </div>
                                    </div>
                                                                                                    
                                </div>
                            </div>
                            @endif
                            @endforeach 
                         @endforeach
                        </div>
                   </section>
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                    </div>
                </fieldset> 

                <fieldset class="wizard-fieldset">
                    <section>
                        <h2 class="part-number"> TASK 2</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear THREE conversations. The conversations will not be repeated. There are four questions for each conversation. For each question, choose the correct answer A, B, C or D.
                                <br>
                            Questions 9 to 12 refer to the following conversation.</span>
                        </div>
                          
                        <div style="margin-top: 10px">
                        @foreach($all_write2 as $key => $all_write2s)
                           
                            <div class="reading-text-wrapper text-en">
                                <div class="paragraph-p7">
                                    <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_write2s->topic_name}}</span></p>
                                    <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_write2s->topic_content}}</span></p>
                                </div>
                               
                            </div>
                            @foreach($all_ques as $key => $all_quess)
                            @if($all_quess->topic_id==$all_write2s->topic_id)
                            <div class="mcq-wrapper">
                                <span class="question-num">  <?php echo $i;  $i++; $index=0; ?></span>
                                <span class="question-content ">{{$all_quess->question_content}}</span>
                                <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                    <div class="d-flex flex-start w-100">
                                      <img
                                        class="rounded-circle shadow-1-strong me-3"
                                        src="https://mdbootstrap.com/img/Photos/Avatars/img%20(19).jpg"
                                        alt="avatar"
                                        width="40"
                                        height="40"
                                      />
                                      <div class="form-outline w-100">
                                        <textarea
                                          class="form-control"
                                          id="textAreaExample"
                                          rows="4"
                                          style="background: #fff;"
                                        ></textarea>
                                        <label class="form-label" for="textAreaExample">Message</label>
                                      </div>
                                    </div>
                                                                                                    
                                </div>
                            </div>
                            @endif
                            @endforeach 
                        @endforeach
                        </div>
                    </section>
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                       {{--  <button  class="form-wizard-submit float-right">Submit  </button>  --}}
                       <button type="button" class="form-wizard-submit float-right show_speak"  >Speaking</button>
                    </div>
                </fieldset> 
            <button type="button" class="btn btn-primary show_speak"  >Speaking Test   </button>
                
            </div>

        </section>
    
    </div>


<div id='form_speaking' class="containerAnswer container mt-sm-5 my-1">
    <section class="wizard-section">
        <div class="form-wizard">
            <div class="form-wizard-header ">
                <h2><p >Speaking test</p></h2>
                <ul class="list-unstyled form-wizard-steps clearfix wrap">
                    <li class="active"><span>1</span></li>
                    <li><span>2</span></li>
                </ul>
            </div>
                <fieldset class="wizard-fieldset show">
                    <section>
                        <h2 class="part-number"> TASK 1</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear EIGHT short announcements or instructions. There is one question for each announcement or instruction. For each question, choose the right answer A, B, C or D. Then, on the answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer that you have chosen. </span>
                        </div>

                        <div style="margin-top: 10px">
                        @foreach($all_write1 as $key => $all_write1s)
                            
                            <div class="reading-text-wrapper text-en">
                                <div class="paragraph-p7">
                                    <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_write1s->topic_name}}</span></p>
                                    <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_write1s->topic_content}}</span></p>
                                </div>
                            </div>
                            @foreach($all_ques as $key => $all_quess)
                            @if($all_quess->topic_id==$all_write1s->topic_id)
                            <div class="">
                                <span class="question-num"> <?php echo $i; $i++; $index=0; ?></span>
                                <span class="question-content ">{{$all_quess->question_content}}</span>
                                <i class="glyphicon glyphicon-record"></i>
                            </div>
                            @endif
                            @endforeach 
                         @endforeach
                        </div>
                   </section>
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                    </div>
                </fieldset> 

                <fieldset class="wizard-fieldset">
                    <section>
                        <h2 class="part-number"> TASK 2</h2>
                        <div class="directions">
                            <span class="directions-label">Directions:</span>
                            <span>In this part, you will hear THREE conversations. The conversations will not be repeated. There are four questions for each conversation. For each question, choose the correct answer A, B, C or D.
                                <br>
                            Questions 9 to 12 refer to the following conversation.</span>
                        </div>
                          
                        <div style="margin-top: 10px">
                        @foreach($all_write2 as $key => $all_write2s)
                           
                            <div class="reading-text-wrapper text-en">
                                <div class="paragraph-p7">
                                    <p class="reading-text-paragraph" style="text-align:center"><span class="paragraph-sentence">{{$all_write2s->topic_name}}</span></p>
                                    <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{{$all_write2s->topic_content}}</span></p>
                                </div>
                               
                            </div>
                            @foreach($all_ques as $key => $all_quess)
                            @if($all_quess->topic_id==$all_write2s->topic_id)
                            <div class="mcq-wrapper">
                                <span class="question-num">  <?php echo $i;  $i++; $index=0; ?></span>
                                <span class="question-content ">{{$all_quess->question_content}}</span>
                                
                           {{--      <script>

                                    let audioIN = { audio: true };
                                    // audio is true, for recording

                                    // Access the permission for use
                                    // the microphone
                                    navigator.mediaDevices.getUserMedia(audioIN)

                                    // 'then()' method returns a Promise
                                    .then(function (mediaStreamObj) {

                                        // Connect the media stream to the
                                        // first audio element
                                        let audio = document.querySelector('audio');
                                        //returns the recorded audio via 'audio' tag

                                        // 'srcObject' is a property which
                                        // takes the media object
                                        // This is supported in the newer browsers
                                        if ("srcObject" in audio) {
                                        audio.srcObject = mediaStreamObj;
                                        }
                                        else { // Old version
                                        audio.src = window.URL
                                            .createObjectURL(mediaStreamObj);
                                        }

                                        // It will play the audio
                                        audio.onloadedmetadata = function (ev) {

                                        // Play the audio in the 2nd audio
                                        // element what is being recorded
                                        audio.play();
                                        };

                                        // Start record
                                        let start = document.getElementById('btnStart');

                                        // Stop record
                                        let stop = document.getElementById('btnStop');

                                        // 2nd audio tag for play the audio
                                        let playAudio = document.getElementById('adioPlay');

                                        // This is the main thing to recorde
                                        // the audio 'MediaRecorder' API
                                        let mediaRecorder = new MediaRecorder(mediaStreamObj);
                                        // Pass the audio stream

                                        // Start event
                                        start.addEventListener('click', function (ev) {
                                        mediaRecorder.start();
                                        // console.log(mediaRecorder.state);
                                        })

                                        // Stop event
                                        stop.addEventListener('click', function (ev) {
                                        mediaRecorder.stop();
                                        // console.log(mediaRecorder.state);
                                        });

                                        // If audio data available then push
                                        // it to the chunk array
                                        mediaRecorder.ondataavailable = function (ev) {
                                        dataArray.push(ev.data);
                                        }

                                        // Chunk array to store the audio data
                                        let dataArray = [];

                                        // Convert the audio data in to blob
                                        // after stopping the recording
                                        mediaRecorder.onstop = function (ev) {

                                        // blob of type mp3
                                        let audioData = new Blob(dataArray,
                                                    { 'type': 'audio/mp3;' });
                                            
                                        // After fill up the chunk
                                        // array make it empty
                                        dataArray = [];

                                        // Creating audio url with reference
                                        // of created blob named 'audioData'
                                        let audioSrc = window.URL
                                            .createObjectURL(audioData);

                                        // Pass the audio url to the 2nd video tag
                                        playAudio.src = audioSrc;
                                        }
                                    })

                                    // If any error occurs then handles the error
                                    .catch(function (err) {
                                        console.log(err.name, err.message);
                                    });
                                </script>
                                

                                <!--button for 'start recording'-->
                                <p>
                                    <button id="btnStart">START RECORDING</button>
                                             
                                    <button id="btnStop">STOP RECORDING</button>
                                    <!--button for 'stop recording'-->
                                </p>

                                <!--for record-->
                                <audio controls></audio>
                                <!--'controls' use for add
                                    play, pause, and volume-->

                                <!--for play the audio-->
                                <audio id="adioPlay" controls></audio>
                               
 --}}


                            </div>
                            @endif
                            @endforeach 
                        @endforeach
                        </div>
                    </section>
                    <div class="form-group clearfix">
                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                       {{--  <button  class="form-wizard-submit float-right">Submit  </button>  --}}
                       <button type="submit" class="btn btn-primary pro-button  w-100 float-right">Submit  </button>
                    </div>
                </fieldset> 
            </div>
        </section>
    
    </div>
    
    <hr class="faded" />
    <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>
        
    </form>





     <script type="text/javascript">
        $(document).ready(function(){
            $('#form_reading').hide()
            $('#form_writing').hide()
             $('#form_speaking').hide()
        });

        $( '.show_read' ).on('click',function(){
           if (confirm("Comfirm Reading Test")) {
                $('#form_reading').show();
                $('#form_listening').hide()
            }     
        });
        $( '.show_write' ).on('click',function(){
           if (confirm("Comfirm Writing Test")) {
                $('#form_reading').hide();
                $('#form_writing').show()
            }     
       });
        $( '.show_speak' ).on('click',function(){
           if (confirm("Comfirm Speaking Test")) {
                $('#form_speaking').show();
                $('#form_writing').hide()
            }     
       });
  

    </script>
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
