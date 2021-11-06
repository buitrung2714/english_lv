@extends('welcome')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script src="//lab.subinsb.com/projects/jquery/core/jquery-2.1.1.js"></script>
    <script src="//lab.subinsb.com/projects/jquery/voice/recorder.js"></script>
    <script src="//lab.subinsb.com/projects/jquery/voice/jquery.voice.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/recorderjs/0.1.0/recorder.js"></script>

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

audio::-webkit-media-controls-timeline {
  display: none !important;
}
audio {
    width: auto;
    min-width: 220px;
    max-width: 300px;
    

}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>

        <div class="all-title-box">
            <div class="container text-center">
                <h1> Lesson Sample <span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
            </div>
        </div>
        

        <div style ="text-align:center; margin-top: 10px">
            @foreach($data as $skill => $data_skill)
            @if(!empty($data[$skill]))
            <button type="button" class="btn btn-primary show_example_{{ $skill }}"> {{ $skill }} </button>
            @endif
            @endforeach
        </div>

        @if(!empty($data['Listening']) || !empty($data['Reading']))
          <button class="btn btn-info reviewBtn" style="position: fixed;">Review</button>
        @endif

            <form id="result_level" data-result_id="{{ $_GET['result'] }}" action="{{ URL::to('/results-example-test/'.$_GET['result']) }}" method="post">
        
            {{ csrf_field() }} 

            <input type="hidden" name="lesson_id" value="{{  $lesson_id  }}">

            @if(!empty($data['Listening']))

            <div id="form_listening" class="containerAnswer container mt-sm-5 my-1">
                <section class="wizard-section">    
                    <div class="form-wizard">
                        <div class="form-wizard-header ">
                            <h1><p>Listening Test</p></h1>
                            <ul class="list-unstyled form-wizard-steps clearfix wrap">
                                @foreach($data['Listening'] as $key_part => $part)

                                <li @if($key_part == 0) class="active" @endif><span style="font-size: 14px">{{ $part['part_name'] }}</span></li>

                                @endforeach
                            </ul>
                            <label class="switch">
                              <input type="checkbox" @if(!isset($_GET['ap']) || $_GET['ap'] == 1) checked @endif>
                              <span class="slider round"></span>
                            </label>
                        </div>
                        {{--      ================================================================================================ --}}
                        @php
                        $a = 1;
                        $num_part = count($data['Listening']);
                        $i_listen = 1;
                        @endphp

                        @foreach($data['Listening'] as $key => $all_part_listen)

                        <fieldset class="wizard-fieldset @if($key == 0) show  @endif">
                             <section>
                                <h2 class="part-number"> {{ $all_part_listen['part_name'] }}</h2>
                                <div class="directions">
                                    <span class="directions-label">Directions:</span>
                                    @if(isset($all_part_listen['part_des']))
                                    <span><b>{!! $all_part_listen['part_des'] !!}</b></span>
                                    @endif
                                </div>


                                @foreach($data['Listening'][$key]['topic'] as $key_topic => $all_topic_listen)

                                @if($key == 0)

                                <div class="mcq-wrapper" id="mau">

                                    @endif   

                                    <div @if($key != 0) class="py-2 h5 au " @endif>
                                        @if($all_topic_listen['topic_image'] != null)
                                        <img  style="text-align:center;  " align="center" width="75%" height="75%" src="/file/image/{{ $all_topic_listen['topic_image'] }}" alt="">
                                        @endif
                                        {{-- <p>Click on the play button to play a sound:</p>  --}}
        
                                        <audio  class="audio_listen" controls @if(!isset($_GET['ap'])) style="pointer-events: none" @else style="pointer-events: auto" @endif data-topic_id="{{ $all_topic_listen['topic_id'] }}">   
                                            <source src="/file/audio/{{ $all_topic_listen['topic_audio'] }}" type="audio/mpeg">
                                            <source src="/file/audio/{{ $all_topic_listen['topic_audio'] }}" type="audio/ogg">

                                        </audio>

                                            </div>

                                            @foreach($data['Listening'][$key]['topic'][$key_topic]['questions'] as $key_ques => $all_ques_listen)

                                            @php   $ans1 = array("(A)","(B)","(C)","(D)" );  @endphp

                                            @if($key != 0)
                                            <div class="mcq-wrapper">
                                                @endif

                                                <span  class="question-num"><?php echo $i_listen.'.'; $i_listen++; ?> </span>
                                                <span class="question-content empty-question-content ques"> {{ $all_ques_listen['question_content'] }} </span>

                                                <div class="options-wrapper">
                                                    @php $index=0; @endphp


                                                    @foreach($data['Listening'][$key]['topic'][$key_topic]['questions'][$key_ques]['answers'] as $key_ans => $answers)


                                                    <div class="option">

                                                        <input value="{{ $answers->answer_id }}" type='radio' data-id_question="{{ $all_ques_listen['question_id'] }}" name="nameListen[{{ $all_ques_listen['question_id'] }}]" data-no-ques="{{ $i_listen - 1 }}" data-skill="listen" data-answer="{{ $ans1[$index] }}" id="id[{{  $answers->answer_id  }}]"  />
                                                        <label for="id[{{  $answers->answer_id  }}]">{{$ans1[$index++]}}
                                                            {{-- .' '.$answers->answer_content }} --}}
                                                        </label>


                                                    </div>

                                                    @endforeach
                                                </div>

                                                @if($key != 0)
                                            </div>
                                            @endif

                                            @endforeach 
                                            <br>

                                            @if($key == 0)     
                                        </div>
                                        @endif

                                        @endforeach

                                    </section>


                                    <div class="form-group clearfix">

                                        @if($a == $num_part )

                                        {{-- 1 - 1 - 1 --}}

                                        @if(!empty($data['Writting']) && !empty($data['Speaking']) && !empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Reading"  >Reading </button>

                                        {{-- 1 - 1 - 0 --}}

                                        @elseif(!empty($data['Writting']) && !empty($data['Speaking']) && empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Writting"  >Writting </button>

                                        {{-- 1 - 0 - 1 --}}

                                        @elseif(!empty($data['Writting']) && empty($data['Speaking']) && !empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Reading"  >Reading </button>

                                        {{-- 1 - 0 - 0 --}}

                                        @elseif(!empty($data['Writting']) && empty($data['Speaking']) && empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Writting"  >Writting </button>

                                        {{-- 0 - 1 - 1 --}}

                                        @elseif(empty($data['Writting']) && !empty($data['Speaking']) && !empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Reading"  >Reading </button>

                                        {{-- 0 - 1 - 0 --}}

                                        @elseif(empty($data['Writting']) && !empty($data['Speaking']) && empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Speaking"  >Speaking </button>

                                        {{-- 0 - 0 - 1 --}}

                                        @elseif(empty($data['Writting']) && empty($data['Speaking']) && !empty($data['Reading']))

                                        <button type="button" class="form-wizard-submit float-right show_Reading"  >Reading </button>

                                        {{-- 0 - 0 - 0 --}}

                                        @elseif(empty($data['Writting']) && empty($data['Speaking']) && empty($data['Reading']))

                                        <button type="submit" class="btn btn-primary float-right">Submit</button>

                                        @endif

                                        @elseif ($a >= 1)

                                        <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>

                                        @endif  

                                        @if($a > 1)

                                        <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>

                                        @endif

                                    </div>

                                </fieldset>

                                @php  $a++ @endphp

                                @endforeach

                                {{-- 1 - 1 - 1 --}}

                                @if(!empty($data['Writting']) && !empty($data['Speaking']) && !empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Reading">
                                    Reading
                                </button>

                                {{-- 1 - 1 - 0 --}}

                                @elseif(!empty($data['Writting']) && !empty($data['Speaking']) && empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Writting">
                                    Writting
                                </button>

                                {{-- 1 - 0 - 1 --}}

                                @elseif(!empty($data['Writting']) && empty($data['Speaking']) && !empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Reading">
                                    Reading
                                </button>

                                {{-- 1 - 0 - 0 --}}

                                @elseif(!empty($data['Writting']) && empty($data['Speaking']) && empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Writting">
                                    Writting
                                </button>

                                {{-- 0 - 1 - 1 --}}

                                @elseif(empty($data['Writting']) && !empty($data['Speaking']) && !empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Reading">
                                    Reading
                                </button>

                                {{-- 0 - 1 - 0 --}}

                                @elseif(empty($data['Writting']) && !empty($data['Speaking']) && empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Speaking">
                                    Speaking
                                </button>

                                {{-- 0 - 0 - 1 --}}

                                @elseif(empty($data['Writting']) && empty($data['Speaking']) && !empty($data['Reading']))

                                <button type="button" class="btn btn-primary show_Reading">
                                    Reading
                                </button>

                                @endif

                            </div>
                        </section>
                    </div>

                    @endif


                    {{-- ================================================ --}}

                    @if(!empty($data['Reading']))    

                    <div id='form_reading' class="containerAnswer container mt-sm-5 my-1" >
                        <section class="wizard-section">
                            <div class="form-wizard">

                                <div class="form-wizard-header ">
                                    <h2><p >Reading test</p></h2>
                                    <ul class="list-unstyled form-wizard-steps clearfix wrap">

                                       @foreach($data['Reading'] as $key_part => $part)

                                       <li @if($key_part == 0) class="active" @endif><span style="font-size: 14px">{{ $part['part_name'] }}</span></li>

                                       @endforeach                       

                                   </ul>
                               </div>
                               @php
                               $a = 1;
                               $num_part = count($data['Reading']);

                               $i = 1;
                               $j_read = 10;
                               @endphp

                               @foreach($data['Reading'] as $key => $all_part_read)

                               <fieldset class="wizard-fieldset @if($key == 0) show  @endif">
                                <section>
                                    <h2 class="part-number"> {{ $all_part_read['part_name'] }}</h2>
                                    <div class="directions">
                                        <span class="directions-label">Directions:</span>
                                        @if(isset($all_part_read['part_des']))
                                            <span><b>{!! $all_part_read['part_des'] !!}</b></span>
                                        @endif
                                    </div>

                                    <div style="margin-top: 10px">
                                        @foreach($data['Reading'][$key]['topic'] as $key_topic => $all_topic_read)
                                        <div >
                                            <div><strong><h3><b>Questions 
                                                @php
                                                echo $i.'-'.$j_read;
                                                @endphp

                                            </b></h3>
                                        </strong></div>
                                    </div>
                                    <div class="reading-text-wrapper text-en ">
                                        <div class="paragraph-p7 topic">
                                            {{-- <p class="reading-text-paragraph ques" style="text-align:center"><span  class="paragraph-sentence">{{ $all_topic_read['topic_name'] }}</span></p> --}}
                                            <p class="reading-text-paragraph" style=""><span class="paragraph-sentence">{!! $all_topic_read['topic_content'] !!}</span></p>

                                            @if($all_topic_read['topic_image'] != null)
                                                <img  style="text-align:center;  " align="center" width="75%" height="75%" src="/file/image/{{ $all_topic_read['topic_image'] }}" alt="">
                                             @endif

                                        </div>

                                    </div>

                                    @foreach($data['Reading'][$key]['topic'][$key_topic]['questions'] as $key_ques => $all_ques_read)

                                    <div class="mcq-wrapper">

                                        <span class="question-num"> 

                                            @php
                                            echo $i;
                                            $i++;
                                            $index=0;
                                            $ans1 = array("(A)","(B)","(C)","(D)" );
                                            @endphp

                                        </span>

                                        <span class="question-content ques"> {{ $all_ques_read['question_content'] }} </span>

                                        <div class="options-wrapper">                                    

                                            @foreach($data['Reading'][$key]['topic'][$key_topic]['questions'][$key_ques]['answers'] as $key_ans => $answers)

                                            <div class="option">

                                                <input value="{{ $answers->answer_id }}" data-id_question="{{ $all_ques_read['question_id'] }}" type='radio' name="nameRead[{{ $all_ques_read['question_id'] }}]" data-no-ques="{{ $i - 1 }}" data-skill="read" data-answer="{{ $ans1[$index] }}" id="id[{{  $answers->answer_id  }}]"  />
                                                <label for="id[{{  $answers->answer_id  }}]">{{$ans1[$index++].' '.$answers->answer_content }}
                                                </label>


                                            </div>

                                            @endforeach
                                        </div>

                                    </div>  
                                    @endforeach 

                                    @endforeach
                                </div>
                            </section>

                            <div class="form-group clearfix">

                                @if($a == $num_part )

                                    {{-- 1 - 1  --}}

                                    @if(!empty($data['Writting']) && !empty($data['Speaking']))

                                    <button type="button" class="form-wizard-submit float-right show_Writting"  >Writting </button>

                                    {{-- 1 - 0  --}}

                                    @elseif(!empty($data['Writting']) && empty($data['Speaking']))

                                    <button type="button" class="form-wizard-submit float-right show_Writting"  >Writting </button>

                                    {{-- 0 - 1  --}}

                                    @elseif(empty($data['Writting']) && !empty($data['Speaking']))

                                    <button type="button" class="form-wizard-submit float-right show_Speaking"  >Speaking </button>

                                    {{-- 0 - 0  --}}

                                    @elseif(empty($data['Writting']) && empty($data['Speaking']))

                                    <button type="submit" class="btn btn-primary float-right"> Submit </button>  

                                    @endif

                                @elseif($a >= 1)

                                    <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>

                                @endif

                                @if($a > 1)

                                <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>

                                @endif
                            </div>

                        </fieldset>

                        @php 
                        $a++;
                        $j_read+=10; 
                        @endphp

                        @endforeach

                        {{-- 1 - 1 --}}

                        @if(!empty($data['Writting']) && !empty($data['Speaking']))

                        <button type="button" class="btn btn-primary show_Writting">
                            Writting
                        </button>

                        {{-- 1 - 0 --}}

                        @elseif(!empty($data['Writting']) && empty($data['Speaking']))

                        <button type="button" class="btn btn-primary show_Writting">
                            Writting
                        </button>

                        {{-- 0 - 1 --}}

                        @elseif(empty($data['Writting']) && !empty($data['Speaking']))

                        <button type="button" class="btn btn-primary show_Speaking">
                            Speaking
                        </button>                        

                        @endif

                    </div>

                </section>
            </div>

            @endif

            {{-- ===================================================== --}}


            @if(!empty($data['Writting']))

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
                                <h2 class="part-number">{{$all_part_write['part_name']}}</h2>
                                <div class="directions">
                                    <span class="directions-label">Directions:</span>
                                    @if(isset($all_part_write['part_des']))
                                        <span><b>{!! $all_part_write['part_des'] !!}</b></span>
                                    @endif
                                </div>

                                <div style="margin-top: 10px">
                                    @foreach($data['Writting'][$key]['topic'] as $key_topic => $all_topic_write)

                                    <div class="reading-text-wrapper text-en">
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
                                                <textarea data-id_question="{{ $all_ques_write['question_id'] }}" name="nameWrite[{{$all_ques_write['question_id']}}]" class="form-control " rows="4" style="background: #fff;" ></textarea>
                                                <label class="form-label" for="textAreaExample">Message</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                @endforeach 

                                @endforeach
                            </div>
                        </section>
                        <div class="form-group clearfix">

                            @if($a == $num_part)
                            
                            @if(empty($data['Speaking']))

                            <button type="submit" class="form-wizard-submit float-right ">Submit  </button>

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

                    <button type="button" class="btn btn-primary show_Speaking">Speaking Test   </button>

                    @endif

                </div>

            </section>

        </div>

        @endif

        {{-- ===================================================== --}}

        @if(!empty($data['Speaking']))

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
                                @if(isset($all_part_speak['part_des']))
                                    <span><b>{!! $all_part_speak['part_des'] !!}</b></span>
                                @endif
                            </div>

                            <div style="margin-top: 10px">
                                @foreach($data['Speaking'][$key]['topic'] as $key_topic => $all_topic_speak)

                                <div class="reading-text-wrapper text-en">
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
                                    <span>Click the record button to record</span><br>
                                    
                                    <span id="recording_{{$all_ques_speak['question_id']}}" style="color:red; display:none;">Recording...</span>
                                    <audio  class="audiosave" data-id_question="{{ $all_ques_speak['question_id'] }}" id="{{$all_ques_speak['question_id']}}" name="nameSpeak[{{$all_ques_speak['question_id']}}]"></audio>
                                    <div style="margin:10px;" class="col-10">

                                        <a  class="btn col-md-4 btn-primary pro-button w-100 record" id="{{$all_ques_speak['question_id']}}"> Record </a>
                                        <a class="btn col-md-3 btn-primary pro-button disabled w-100 one play" id="{{$all_ques_speak['question_id']}}"> Stop</a>

                                    </div>

                                </div>
                                <input type="hidden" name="nameSpeak[{{$all_ques_speak['question_id']}}]">
                                @endforeach 


                                @endforeach
                            </div>
                        </section>
                        <div class="form-group clearfix">
                         @if($a == $num_part)

                         <button type="button" id="submitsave" class="form-wizard-submit float-right " >Submit</button>

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

     @endif

     <hr class="faded" />
     {{-- 1 - 1 - 1 - 1  --}}

     @if(!empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 1 - 1 - 1 - 0  --}}

     @elseif(!empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 1 - 1 - 0 - 1  --}}

     @elseif(!empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 1 - 1 - 0 - 0  --}}

     @elseif(!empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 1 - 0 - 1 - 1  --}}

     @elseif(!empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>


     {{-- 1 - 0 - 1 - 0  --}}

     @elseif(!empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 1 - 0 - 0 - 1  --}}

     @elseif(!empty($data['Listening']) && empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 1 - 0 - 0 - 0  --}}

     @elseif(!empty($data['Listening']) && empty($data['Reading']) && empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 1 - 1 - 1  --}}

     @elseif(empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 1 - 1 - 0  --}}

     @elseif(empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 1 - 0 - 1  --}}

     @elseif(empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>


     {{-- 0 - 1 - 0 - 0  --}}

     @elseif(empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 0 - 1 - 1  --}}

     @elseif(empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 0 - 1 - 0  --}}

     @elseif(empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 0 - 0 - 1  --}}

     @elseif(empty($data['Listening']) && empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))

     <button type="button" id="submitsave" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     {{-- 0 - 0 - 0 - 0  --}}
     @elseif(empty($data['Listening']) && empty($data['Reading']) && empty($data['Writting']) && empty($data['Speaking']))

     <button type="submit" class="btn btn-primary pro-button  w-100 ">Submit  </button>

     @endif

 </form>

{{-- ======================================Review Trắc nghiệm====================================== --}}
     @if(!empty($data['Listening']) || !empty($data['Reading']))
     <div class="modal fade" id="reviewModal">
         <div class="modal-dialog modal-xl" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                         <span class="sr-only">Close</span>
                     </button>
                 </div>
                 <div class="modal-body container">
                     @php 
                        $arr_skill = [];
                        $count_listen = isset($i_listen) ? ($arr_skill['Listening'] = $i_listen -1) : null;
                        $count_read = isset($j_read) ? ($arr_skill['Reading'] = $j_read -10) : null;
                        echo count($arr_skill);
                     @endphp
                     <div class="row">
                        @foreach($arr_skill as $k_skill => $val)
                        @php 

                            $row = 0;
                             $val_max = $val >= 5 ? round($val / 5) : 1;
                            
                        @endphp
                        
                        @if($val != 0)
                         <div class="col-md-{{ count($arr_skill) == 2 ? 6 : 12 }}">
                             <label style="font-weight:bold;">{{ $k_skill }}</label>
                             <table class="table table-bordered text-center" data-skill-table="{{ $k_skill }}">  
                                @for($i = 0; $i <= $val_max; $i++)
                                <tr>

                                    @for($j = 0; $j <= 4 ; $j++)
                                        @if($row < $val)
                                        @php ++$row @endphp
                                        <td style="background-color: yellow" id="row_{{ $k_skill == 'Listening' ? 'listen' : 'read' }}_{{ $row }}">{{ $row }}.</td>
                                        @else
                                        @break
                                        @endif
                                    
                                    @endfor
                                </tr>  
                                @endfor

                             </table>
                         </div>
                         @endif
                         @endforeach

                     </div>
                 </div>
             </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
     </div><!-- /.modal -->
     @endif
     {{-- ======================================Review Trắc nghiệm====================================== --}}


 <script type="text/javascript">
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
                  setup:function(ed) {
                       ed.on("keyup", function(e){
                                
                            sessionStorage.setItem($(ed.targetElm).data('id_question'), tinymce.activeEditor.getContent())
                        });
                   },
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

            // ==============================XỬ LÝ SESSION STORAGE==============================

            //trắc nghiệm
            $('[type="radio"]').change(function(){
                skill = $(this).data('skill');
                question = $(this).data('no-ques');
                answer = $(this).data('answer');
                $(`#row_${skill}_${question}`).css('background-color','#fff');
                $(`#row_${skill}_${question}`).html(`<b>${question}</b>.${answer}`)
                sessionStorage.setItem($(this).data('id_question'), $(this).val());
            })

            //render bài viết
            if ($('textarea').length > 0) {

                $('textarea').each(function(i,v){

                    var id = $(this).data('id_question');
                     
                    $(this).html(sessionStorage.getItem(id));
                });
            }
            //render trắc nghiệm
            if ($('[type="radio"]').length > 0) {

                $('[type="radio"]').each(function(i,v){
                    var id = $(this).data('id_question')
                    skill = $(this).data('skill');
                    question = $(this).data('no-ques');
                    answer = $(this).data('answer');

                    if ($(v).val() == sessionStorage.getItem(id)) {
                        $(`#row_${skill}_${question}`).css('background-color','#fff');
                        $(`#row_${skill}_${question}`).html(`<b>${question}</b>.${answer}`)
                        $(v).prop('checked', true)
                    }
                    
                })
            }

            //render bài nói
            if ($('.audiosave').length > 0) {

                $('.audiosave').each(function(i,v){
                    var ques_id = $(this).attr('id');
                    
                    $(this).attr("src", sessionStorage.getItem(ques_id));
                    
                    if (typeof $(this).attr('src') !== "undefined") {
                        $(this).prop("controls",true)
                    }
                });
            }
            
            // ==============================XỬ LÝ SESSION STORAGE==============================

            // ==============================XỬ LÝ THỜI GIAN AUDIO==============================
            
            
            const arr_time = [];
            var i = 0;
             $('.audio_listen').on('loadedmetadata',function() {
                    
                    obj = new Object();
                    obj.topic = $($('.audio_listen')[i]).data('topic_id');     
                    obj.time = i == 0 ? 1 : $('.audio_listen')[i].duration;
                    obj.before = i == 0 ? 1 : $('.audio_listen')[i-1].duration + 3;
                    arr_time.push(obj)
                    
                    i++;
                });

             setTimeout(function(){
               
                if (sessionStorage.getItem('last-audio') !== null) {
                    $.each(arr_time,function(i,v){
                        if (v.topic == sessionStorage.getItem('last-audio')) {
                            arr_time[i].before = 1;
                            arr_time[i].time = 1;
                            arr_continue = arr_time.slice(i);
                        }
                    })
                }

                var testFunc = async function(){

                  const fx = ({topic,time,before}) =>
                    new Promise(resolve => setTimeout(resolve, (before * 1000) ,topic)) // delay
                    .then(function (data){
                        sessionStorage.setItem('last-audio',topic);
                        $(`[data-topic_id="${topic}"]`)[0].play();
                              
                    }) // do stuff

                  for (let {topic,time,before} of typeof arr_continue !== 'undefined' ? arr_continue : arr_time) {
                    // do stuff with el and pause before the next el;
                    let curr = await fx({topic,time,before});
                  };
                }; 

                if ((window.location.href).search('&ap') == -1) {
                    testFunc();
                }

             },3000);
                
            // ==============================XỬ LÝ THỜI GIAN AUDIO==============================

            // 1-1-1-1
            @if(!empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_reading').hide()
                $('#form_writting').hide()
                $('#form_speaking').hide()
            
            // 1-1-1-0
            @elseif(!empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_reading').hide()
                $('#form_writting').hide()
            
            // 1-1-0-1
            @elseif(!empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_reading').hide()
                $('#form_speaking').hide()
           
            // 1-1-0-0
            @elseif(!empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_reading').hide()
            
            // 1-0-1-1
            @elseif(!empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_writting').hide()
                $('#form_speaking').hide()
            
            // 1-0-1-0
            @elseif(!empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_writting').hide()
            
            // 1-0-0-1
            @elseif(!empty($data['Listening']) && empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_listening').show()
                $('#form_speaking').hide()
            
            // 0-1-1-1
            @elseif(empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_reading').show()
                $('#form_writting').hide()
                $('#form_speaking').hide()
            
            // 0-1-1-0
            @elseif(empty($data['Listening']) && !empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))
                $('#form_reading').show()
                $('#form_writting').hide()
            
            // 0-1-0-1
            @elseif(empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_reading').show()
                $('#form_speaking').hide()
            
            // 0-1-0-0
            @elseif(empty($data['Listening']) && !empty($data['Reading']) && empty($data['Writting']) && empty($data['Speaking']))
                $('#form_reading').show()
            
            // 0-0-1-1
            @elseif(empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_writting').show()
                $('#form_speaking').hide()
            
            // 0-0-1-0
            @elseif(empty($data['Listening']) && empty($data['Reading']) && !empty($data['Writting']) && empty($data['Speaking']))
                $('#form_writting').show()
            
            // 0-0-0-1
            @elseif(empty($data['Listening']) && empty($data['Reading']) && empty($data['Writting']) && !empty($data['Speaking']))
                $('#form_speaking').show()
            @endif
            
        

    $( '.show_Reading' ).on('click',function(){
        Swal.fire({
            toast: true,
            title: 'Move Reading Test',
            icon: 'question',
            backdrop: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'lightblue',
        }).then(function(result){
            if (result.isConfirmed) {
                $('.audio_listen').prop('muted',true);
                $('#form_reading').show(2000);
                $('#form_listening').hide();
                $('#form_writting').hide();
                $('#form_speaking').hide();
            }
        });    
    });
    $( '.show_Writting' ).on('click',function(){
        Swal.fire({
            toast: true,
            title: 'Move Writting Test',
            icon: 'question',
            backdrop: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'lightblue',
        }).then(function(result){
            if (result.isConfirmed) {
                $('.reviewBtn').hide();
                $('.audio_listen').prop('muted',true);
                $('#form_reading').hide();
                $('#form_listening').hide();
                $('#form_writting').show(2000);
                $('#form_speaking').hide();
            }
        });

    });
    $( '.show_Speaking' ).on('click',function(){
        Swal.fire({
            toast: true,
            title: 'Move Speaking Test',
            icon: 'question',
            backdrop: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'lightblue',
        }).then(function(result){
            if (result.isConfirmed) {
                $('.reviewBtn').hide();
                $('.audio_listen').prop('muted',true);
                $('#form_reading').hide();
                $('#form_listening').hide();
                $('#form_writting').hide();
                $('#form_speaking').show(2000);
            }
        });
    });

    $('[type="submit"]').click(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Do you want to finish?',
            icon: 'question',
            backdrop: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'lightblue',
        }).then(function(result){
            if (result.isConfirmed) {
                tinyMCE.triggerSave();
                $('#result_level').submit();
            }
        });
    })

    $('.show_example_Listening').on('click',function(){
        $('.reviewBtn').show();
        $('.audio_listen').prop('muted',false);
        $('#form_reading').hide();
        $('#form_listening').show(1000)
        $('#form_writting').hide();
        $('#form_speaking').hide();
    });
    $('.show_example_Reading').on('click',function(){
        $('.reviewBtn').show();
        $('.audio_listen').prop('muted',true);
        $('#form_listening').hide();
        $('#form_writting').hide();
        $('#form_reading').show(1000);
        $('#form_speaking').hide();
    });
    $('.show_example_Writting').on('click',function(){
        $('.reviewBtn').hide();
        $('.audio_listen').prop('muted',true);
        $('#form_reading').hide();
        $('#form_listening').hide()
        $('#form_writting').show(1000);
        $('#form_speaking').hide();
    });
    $('.show_example_Speaking').on('click',function(){
        $('.reviewBtn').hide();
        $('.audio_listen').prop('muted',true);
        $('#form_listening').hide();
        $('#form_reading').hide();
        $('#form_speaking').show(1000);
        $('#form_writting').hide();
    });

    $('.switch').children('[type="checkbox"]').change(function(){
        if ($(this).prop('checked') == false) {
            $(this).prop('checked',false);

            window.location = window.location.href + '&ap=0';

        }else{
            $(this).prop('checked',true);

            link = window.location.href;
            window.location = link.replace('&ap=0','');
            
        }
    });

    $('.reviewBtn').click(function(){

        $('#reviewModal').modal('toggle');
        $('#reviewModal table').each(function(i,v){
            var count_table_ques = 0;
            var total_ques = $(this).find('td').length;
            var skill = $(this).data('skill-table')
            $($(this).find('td')).each(function(k,val){
                str = $(val).text().trim();
                arr_str = str.split(".");
                if(arr_str[1] != ""){
                    ++count_table_ques;
                }
            })
            $(this).prev().html(`${skill} (${count_table_ques}/${total_ques})`)
        })
    })
    $('[data-dismiss="modal"]').click(function(){
        $('#reviewModal').modal('hide');
    })
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


    function restore(){
        $(".record").removeClass("disabled");
        $(".one").addClass("disabled");
        Fr.voice.stop();
    };

    $(document).on("click", ".record:not(.disabled)", function(event){
        event.preventDefault();
        var ques_id = $(this).attr('id');
        $('#recording_'+ques_id).show();
        elem = $(this);

        Fr.voice.record();

        elem.next().removeClass("disabled");
    });



    $(document).on("click", ".play:not(.disabled)", function(event){
        event.preventDefault();
        var ques_id = $(this).attr('id');
        $("audio#"+ques_id).attr("controls", 1);
        $('#recording_'+ques_id).hide();
        Fr.voice.export(function(base64){
                
                sessionStorage.setItem(ques_id, base64);
                $("audio#"+ques_id).attr("data-base", base64);
            }, "base64");

        Fr.voice.export(function(url){
            
            $("audio#"+ques_id).attr("src", url);
            $("audio#"+ques_id)[0].play();

        }, "URL");

        restore();

    });

    $(document).on("click","#submitsave",function(event){
        event.preventDefault();
        Swal.fire({
            title: 'Do you want to finish?',
            icon: 'question',
            backdrop: false,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'lightblue',
        }).then(function(result){
            if (result.isConfirmed) {
                token = $('[name="_token"]').val();

                var arrsrc = [];
                var routesavesrc = "{{URL::to('/save-src')}}";
                var src = $('.audiosave').map(function() {
                 var arrtamp = [];
                 var question_id = this.id;
                 var src = this.src;
                 
                 if (typeof sessionStorage.getItem(question_id) !== "undefined" && (sessionStorage.getItem(question_id) == $(this).attr('src'))) {
                    var base = sessionStorage.getItem(question_id);
                 }else{
                    var base = $(this).attr('data-base');
                 }

                arrtamp.push( question_id,src,base );
                
                arrsrc.push(arrtamp);
            }).get();
                var result_id = $('#result_level').data('result_id');

                $.ajax({

                    method: 'post',
                    url: routesavesrc,
                    data:{
                        arrsrc:arrsrc,
                        result_id:result_id,
                        _token: token,
                    },
                    success:function(data) {

                        tinyMCE.triggerSave();
                        $('#result_level').submit();

                    }
                });
            }
        });

    });
});
</script>

</body>
</html>
@endsection
