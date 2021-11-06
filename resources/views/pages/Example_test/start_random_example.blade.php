@extends('welcome')
@section('content')

{{-- <script>
    setTimeout(function () {
        alert("Het gio");
    },3000)
</script> --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box
}



.containerAnswer {
    background-color: #555;
    color: #ddd;
    border-radius: 10px;
    padding: 20px;
    font-family: 'Montserrat', sans-serif;
  max-width: 1200px 
    
}
/* .cpart{
    text-align: center;
} */
.containerAnswer>h2 {
    font-size: 32px;
  
}
.containerAnswer .part  {
    
    text-align: center;
}
/* .containerAnswer>div:first-child  {
    
    text-align: center;
} */



/* //phan trang */
.wrapper {
    height: 10vh;
    display: flex;
    justify-content: center;
    align-items: center
}
.page-link {
    position: relative;
    display: block;
    color: #673AB7 !important;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #673AB7 !important
}

.page-link:hover {
    z-index: 2;
    color: #fff !important;
    background-color: #673ab7;
    border-color: #024dbc
}

.page-link:focus {
    z-index: 3;
    outline: 0;
    box-shadow: none
}
.navigation{

}
.page-link {
    position: relative;
    display: block;
    color: #673AB7 !important;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #673AB7 !important
}

.page-link:hover {
    z-index: 2;
    color: #fff !important;
    background-color: #673ab7;
    border-color: #024dbc
}

.page-link:focus {
    z-index: 3;
    outline: 0;
    box-shadow: none
}

.part-number{
    margin-bottom: 20px;
    text-align: left;
    font-weight: bold; 
    font-size: 30px;
    text-decoration: underline;   
}
.directions-label{
    font-weight: 700;
}   
.mcq-wrapper{
    margin-bottom: 30px;
    display: inline-block;
    vertical-align: top;
    width: 48%;
    max-width: 50%;
    padding: 10px 15px;
} 

.image{
    vertical-align: middle;
    border-style: none;
}
.question-content .test-content
{
    display: inline-block;
    margin-bottom: 10px;
}
/* answer */
.options-wrapper{
    margin: 0 0 0 25px;
}
.faded{
        clear: both;
    float: none;
    width: 85%;
    height: 1px;
    margin: 60px auto;
    border: none;
    background: #ddd;
}

/* part6 */    
.mcqg-wrapper{
    margin: 30px 0;
}

.mcqg-wrapper>strong{
    font-weight: 700;
    color: #1f1f1f;
}    
.paragraph-p7{
    margin: 30px 0;
    padding: 30px 60px;
    background-size: 100% 100%;
    background-repeat: no-repeat;
    border: 2px solid #ebebeb;
    border-radius: 5px;
}

</style>

   
    <div class="all-title-box">
        <div class="container text-center">
            <h1>  Example Test<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
        </div>
    </div>
    @if($filter_status==1)
    <div style="text-align: center; color: #fa5b0f; font-size: 50px" >
        <p>Finish Within 160 minutes</p>
        
    </div>
    @endif

    <div class="containerAnswer container mt-sm-5 my-1">

            <div class="row ">
                <div class="col-md-4"> </div>
                <div class="col-md-4"> 
                    <a data-url="{{ URL::to('/show-random-example/'.$filter_id) }}" class="btn-lg btn-primary startBtn" style="margin-left: 80px; padding: 10px 100px; border-radius: 10px;cursor: pointer;"> Start </a>
                    
            </div>
        
    </div>

@endsection

@section('javascript')

<script>
    $('.startBtn').click(function(){
        var url = $(this).data('url');

        window.location = url + `?result={{ $_GET['result'] }}&lesson={{ $_GET['lesson'] }}&timer=` + "{{ time() }}";
            
    })
</script>

@endsection
   