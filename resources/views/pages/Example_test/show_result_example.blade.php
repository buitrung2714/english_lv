
@if($check_write !== null && $fee > 0)

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('/frontend/css/bootstrap.min.css')}}">

    <link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/smart_wizard.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />

</head>

@else

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('/frontend/css/bootstrap.min.css')}}">

<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/smart_wizard.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />

@endif

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
    background-color: red;
}
.no_ans{
    background-color: orange;
}
.note_color {

    max-width: 780px; margin-left: auto; margin-right: auto;
}
/* .note_color table{
    text-align: center;
    } */
    .color{

        width: 10%;
    }



</style>
<br>
<div  >
    <table class="col-md-9 note_color" >
        <tr >
            <td class="color" style="background-color: green;" > </td>
            <td>Answer True</td>

            <td  class="color" style="background-color: red;"> </td>
            <td>Answer False</td>

            <td class="color" style="background-color: orange;"> </td>
            <td>Not choice Answer</td>
        </tr>
    </table>

</div>
<br> 
<div style ="text-align:center">
    @foreach($data as $skill => $data_skill)
    @if(!empty($data[$skill]))
    <button type="button" class="btn btn-primary show_{{ $skill }}"> {{ $skill }} </button>
    @endif
    @endforeach
</div>

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
            </div>
            {{--      ================================================================================================ --}}
            @php
            $a = 1;
            $num_part = count($data['Listening']);
            $i = 1;
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
                            <p>Click on the play button to play a sound:</p> 
                            <audio controls >   
                                <source src="/file/audio/{{ $all_topic_listen['topic_audio'] }}" type="audio/mpeg">
                                    <source src="/file/audio/{{ $all_topic_listen['topic_audio'] }}" type="audio/ogg">

                                    </audio>

                                </div>

                                @foreach($data['Listening'][$key]['topic'][$key_topic]['questions'] as $key_ques => $all_ques_listen)

                                @php   $ans1 = array("(A)","(B)","(C)","(D)" );  @endphp

                                @if($key != 0)
                                <div class="mcq-wrapper">
                                    @endif

                                    <span  class="question-num"><?php echo $i.'.'; $i++; ?> </span>
                                    <span class="question-content empty-question-content ques"> {{ $all_ques_listen['question_content'] }} </span>

                                    <div class="options-wrapper">
                                        @php $index=0; @endphp


                                        @foreach($data['Listening'][$key]['topic'][$key_topic]['questions'][$key_ques]['answers'] as $key_ans => $answers)


                                        <div class="option">

                                            <input value="{{ $answers->answer_id }}" disabled type='radio' 

                                            @if(($all_ques_listen['ans_id_stu'] != null) && ($answers->answer_id == $all_ques_listen['ans_id_stu']))

                                            checked 
                                            
                                            @endif

                                            name="nameListen[{{ $all_ques_listen['question_id'] }}]"  id="id[{{  $answers->answer_id  }}]"  />
                                            
                                            <label for="id[{{  $answers->answer_id  }}]"

                                                @if(($answers->answer_true == 1) && ($all_ques_listen['ans_id_stu'] != null))

                                                class="ans_true" 

                                                @endif

                                                @if(($answers->answer_true == 0) && ($all_ques_listen['ans_id_stu'] == $answers->answer_id))

                                                class="ans_false"

                                                @endif

                                                @if($all_ques_listen['ans_id_stu'] == null && $answers->answer_true == 1)
                                                class="no_ans"
                                                @endif
                                                >{{$ans1[$index++].' '.$answers->answer_content }}
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

                            <button type="button" class="btn btn-primary float-right" disabled>End</button>

                            @endif

                            @elseif ($a >=1)

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
                   $j = 10;
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
                                    echo $i.'-'.$j;
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

                                    <input value="{{ $answers->answer_id }}" disabled type='radio' 

                                    @if(($all_ques_read['ans_id_stu'] != null) && ($answers->answer_id == $all_ques_read['ans_id_stu']))

                                    checked 
                                    
                                    @endif

                                    name="nameRead[{{ $all_ques_read['question_id'] }}]"  id="id[{{  $answers->answer_id  }}]"  />

                                    <label for="id[{{  $answers->answer_id  }}]"

                                        @if(($answers->answer_true == 1) && ($all_ques_read['ans_id_stu'] != null))

                                        class="ans_true" 

                                        @endif

                                        @if(($answers->answer_true == 0) && ($answers->answer_id == $all_ques_read['ans_id_stu']))

                                        class="ans_false"

                                        @endif

                                        @if($all_ques_read['ans_id_stu'] == null && $answers->answer_true == 1)
                                        class="no_ans"
                                        @endif
                                        >{{$ans1[$index++].' '.$answers->answer_content }}
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

                    <button type="button" class="btn btn-primary float-right" disabled> End </button>  

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
            $j+=10; 
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
{{-- ============================================ --}}

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
                    <h2 class="part-number">{{  $all_part_write['part_name']  }}</h2>
                    <div class="directions">
                        <span class="directions-label">Directions:</span>
                        @if(isset($all_part_write['part_des']))
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
                                    <textarea class="tiny">{!! $all_ques_write['ans_task'] !!}</textarea>

                                    @if(($all_ques_write['mark'] != null) || ($all_ques_write['mark'] == '0.0'))

                                    <br><label class="form-label" for="textAreaExample">Teacher's comment:</label>

                                        @if(session()->has('id_gv'))

                                        <textarea class="form-control" cols="5" rows="5" style="background:#fff;border: 1px solid black">{{ $all_ques_write['note'] }}</textarea>

                                        @else

                                        <textarea class="form-control" cols="5" rows="5" disabled style="background:#fff;border: 1px solid lightgrey;">{{ $all_ques_write['note'] }}</textarea>

                                        @endif

                                    <br><label>Mark:</label>
                                    <input type="text" class="form-control" disabled value="{{ $all_ques_write['mark'] }}" style="background-color: #fff;border: 1px solid lightgrey">

                                    @endif

                                </div>
                            </div>

                        </div>

                    </div>

                    @endforeach 

                </div>
                @endforeach

            </section>
            <div class="form-group clearfix">

                @if($a == $num_part)

                @if(empty($data['Speaking']))

                <button type="button" class="btn btn-primary float-right" disabled>End</button>

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


                    @foreach($data['Speaking'][$key]['topic'] as $key_topic => $all_topic_speak)
                    
                    <div style="margin-top: 10px">
                        <div class="reading-text-wrapper text-en" data-part="{{ $all_part_speak['part_name'] }}" data-skill="Speaking">
                            <div class="paragraph-p7 topic" style="text-align:center;">
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

                            @if(($all_ques_speak['mark'] != null) || ($all_ques_speak['mark'] == '0.0'))

                            <br><label class="form-label" for="textAreaExample">Teacher's comment:</label>
                            
                            @if(session()->has('id_gv'))

                            <textarea class="form-control" cols="5" rows="5" style="background:#fff;border: 1px solid black">{{ $all_ques_speak['note'] }}</textarea>

                            @else

                            <textarea class="form-control" cols="5" rows="5" disabled style="background:#fff;border: 1px solid lightgrey">{{ $all_ques_speak['note'] }}</textarea>

                            @endif

                            <br><label>Mark:</label>
                            <input type="text" class="form-control" disabled value="{{ $all_ques_speak['mark'] }}" style="background-color: #fff;border: 1px solid lightgrey">

                            @endif

                        </div>

                        @endforeach 

                    </div>
                    @endforeach

                </section>
                <div class="form-group clearfix">

                   @if($a == $num_part)

                   <button type="button" class="btn btn-primary float-right" disabled>End</button>

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
{{-- ================================================ --}}


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

@if($check_write !== null && $fee > 0)

{{-- tinymce --}}
<script src="https://cdn.tiny.cloud/1/988pi62n14j4hn23yklqejb4lc4dymdxaedxt127biudf5w4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

@endif

<script type="text/javascript">
    $(document).ready(function(){

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

        //tinyMCE (quản lý soạn thảo văn bản cho thẻ <textarea>)
        tinymce.init({
            selector: '.tiny',
            plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
            readonly: true,
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
        
    });
$( '.show_Listening' ).on('click',function(){

    $('#form_reading').hide();
    $('#form_listening').show(1000)
    $('#form_writting').hide();
    $('#form_speaking').hide();
});
$( '.show_Reading' ).on('click',function(){
    $('#form_listening').hide();
    $('#form_writting').hide();
    $('#form_reading').show(1000);
    $('#form_speaking').hide();

});
$( '.show_Writting' ).on('click',function(){

    $('#form_reading').hide();
    $('#form_listening').hide()
    $('#form_writting').show(1000);
    $('#form_speaking').hide();

});
$( '.show_Speaking' ).on('click',function(){
    $('#form_listening').hide();
    $('#form_reading').hide();
    $('#form_speaking').show(1000);
    $('#form_writting').hide();
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
});
</script>