@extends('welcome')
@section('content')

<style>
    .score-report{
        list-style: none;
        border: 1px solid;
        width: 60%;
        margin: 0 auto;
        padding: 10px;
        background-color: #fdfcfc;
        border: 2px solid #9298b6;

    }
    .score-report li {
        display: inline-block;
        vertical-align: top;
        text-align: center;
        width: 30%;
       
    }
  
    .score-report .personal-info {
        width: 40%;


    }
 
    .score-report .score-value {
    width: 50px;
    height: 45px;
    margin: 30px auto;
    
    font-size: 24px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #666;
    text-align: center;
}
   
  
    .score-report li.component-scores {
        border-left: 1.2px solid #333;
        border-right: 1.2px solid #333;
    }
    .score-report .score-label {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        background: #45407a;
        padding: 5px 10px;
        max-width: 130px;
        margin: 0 auto;
    }
    .result{
        margin-bottom: 10px;
    }


</style>

	<div class="all-title-box">
        <div class="container text-center">
            <h1> Results  Test<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
        </div>
    </div>
    <div style="text-align: center; color: #fa5b0f; font-size: 50px" >
        <p>Results Test</p>

    </div>
    <section>
        <div class=" result">
            <ul class="score-report ">
            <li class="personal-info col-md-4">
                <div class="name">{{ session()->get('student_name') }}</div>
                <div class="test-date">Test Date: <?php echo date("d/m/Y")?></div>
          {{--       <?php
        var_dump($practice)
        ?> --}}
            </li>
            <li class="component-scores col-md-4">
                <div class="listening-score-wrapper">
                    <div class="score-label">LISTENING</div>
                    <div class="score-value">{{$tampListen}}
                        
                    </div>
                   
                </div>
                <div class="reading-score-wrapper">
                    <div class="score-label">READING</div>
                    <div class="score-value">{{$tampRead}}
                    </div>
                </div>
            </li>
            <li class="col-md-4 ">
                <div class="score-label">TOTAL SCORE</div>
                <div style="width: 70px;height: 60px;font-size: 36px;" class="score-value">{{$total}}</div>
            </li>
            
          
        </ul>
        </div>
        
       
         
    </section>
        <hr class="faded" />
        <div style="text-align: center; margin-bottom: 10px "  > 
            {{-- <a href="" ><button  value="{{$code}}" class="btn btn-primary pro-button w-100">View Results Test  </button> </a> --}}
            <input id="btnViewResult" class="viewss btn btn-primary" type="button" name="view" value="View Results Test " >
           

            
        </div>
        <div id="viewResult"  >..</div>
   
  
    <script >
        $(document).ready(function(){
            //setup token ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // $('#btnViewResult').click(function(){

            //     $("#viewResult").load("{{URL::to('/show-result-example/'.$result_id)}}");
            // });
            $('#viewResult').hide()
            $('#btnViewResult').on('click', function(e){
                e.preventDefault();
                $('#viewResult').toggle(1000)
                $.ajax({
                    url: "{{URL::to('/show-result-example/'.$result_id)}}",
                    method: "get",
                    //data: $('#add_type_test_form').serialize(),
                     success:function(data){
                        //console.log(data);

                        $("#viewResult").html(data);
                        //$('#viewResult').modal('toggle');
                        
                     }
                });
            });
           
            sessionStorage.clear();
           
        });
    </script>
    



@endsection
