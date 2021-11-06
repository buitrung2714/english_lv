@extends('welcome')
@section('content')


<style>
.welcome{
    color: #fa5b0f; 
    
}
.descrip{
    font-size: 30px;
}
.descrip-time{
    font-size: 30px;
    color:#fa5b0f ;
}

</style>

   
    <div class="all-title-box">
        <div class="container text-center">
            <h1>  Input Test<span class="m_1">Welcome English Club.</span></h1>
        </div>
    </div>

    <div style="text-align: center; " >
        <p><h1 class="welcome">Hi @if(session()->get('student_name')) {{session()->get('student_name')}} @endif , Welcome to English Club</h1> </p>
        <p class="descrip">Small test to assess the English learning journey </p>
        <p class="descrip-time" >Finish Within 30 minutes</p>
        
    </div>
    <div class="containerAnswer container mt-sm-5 my-1">
        <div class="row ">
            <div class="col-md-4"> </div>
            <div class="col-md-4"> 
                <a data-href ="{{ URL::to('/show-random-example/'.$filter_input_test->filter_id) }}" data-id="{{ $filter_input_test->filter_id }}" class="btn-lg btn-primary startBtn" style="margin-left: 80px; padding: 10px 100px; cursor: pointer; border-radius: 10px;"> Start </a>
            </div>
    
        </div>
    </div>

@endsection

@section('javascript')
<script>
    $('.startBtn').click(function(){
        $(this).css("pointer-events", "none");
        var url = $(this).data('href');
        var id = $(this).data('id');
        $.get("{{ URL::to('/random-example') }}/" + id + '?fee={{ $fee }}', function(response){
            window.location = url + `?result=${response.result_id}&lesson=${response.lesson_id}&timer={{ time() }}`;
        })
    })
</script>
@endsection

