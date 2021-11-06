@extends('welcome')
@section('content')

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.2/materia/bootstrap.min.css">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" 
rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/
libs/bootswatch/4.5.2/materia/bootstrap.min.css">


<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.2/materia/bootstrap.min.css">

<style>

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    padding: 20px;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border-radius: 6px;
    -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1)
}
.sub-title-test{
    text-align: center;
    font-family: roboto-medium;
    color: black;
    text-transform: uppercase;
    margin-top: 70px;


}
.col-md-4 {
    margin-top: 20px;
}
.hidden{
    display: none;

}


.form-wizard-steps {
  margin: auto;
  align-content: center;
  align-items: center;
  margin-bottom: 15px;
}
.form-wizard-steps li {
  width: 12%;
  float: left;
  position: relative;
}
.form-wizard-steps li::after {
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
.form-wizard-steps li span {
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
.form-wizard-steps li:last-child::after {
  width: 50%;
}
.form-wizard-steps li.active span, .form-wizard-steps li.activated span {
  background-color: #4c5a7d;
  color: #ffffff;
}
.form-wizard-steps li.active::after,  .form-wizard-steps li.activated::after {
  background-color: #4c5a7d;
  left: 50%;
  width: 50%;
  border-color: #4c5a7d;
}
.form-wizard-steps li.activated::after {
  width: 100%;
  border-color: #4c5a7d;
}
.form-wizard-steps li:last-child::after {
  left: 0;
}
.form-wizard .form-wizard-steps li {
    width: 12%;
    float: left;
    position: relative;
}
.wrap
{
    display: flex;
    justify-content: center;

    }.form-wizard .form-wizard-header {
      text-align: center;
      align-items: center;
  }
  .active span{
    background-color: #CD9B9B;

/*   -webkit-border-radius: 50%;
 
border-radius: 50%; */


color: #FFFFFF;

cursor: pointer;

display: inline-block;

font-family: Arial;   

/*   font-size: 20px;
   
padding: 5px 10px; */

text-align: center;

text-decoration: none;

}
.active span a{
    text-align: center;
    color: #fff;



}

@-webkit-keyframes glowing {
  0% { background-color: #004A7F; -webkit-box-shadow: 0 0 3px #004A7F; }
  50% { background-color: #0094FF; -webkit-box-shadow: 0 0 10px #0094FF; }
  100% { background-color: #004A7F; -webkit-box-shadow: 0 0 3px #004A7F; }
}

@-moz-keyframes glowing {
  0% { background-color: #004A7F; -moz-box-shadow: 0 0 3px #004A7F; }
  50% { background-color: #0094FF; -moz-box-shadow: 0 0 10px #0094FF; }
  100% { background-color: #004A7F; -moz-box-shadow: 0 0 3px #004A7F; }
}

@-o-keyframes glowing {
  0% { background-color: #004A7F; box-shadow: 0 0 3px #004A7F; }
  50% { background-color: #0094FF; box-shadow: 0 0 10px #0094FF; }
  100% { background-color: #004A7F; box-shadow: 0 0 3px #004A7F; }
}

@keyframes glowing {
  0% { background-color: #004A7F; box-shadow: 0 0 3px #004A7F; }
  50% { background-color: #0094FF; box-shadow: 0 0 10px #0094FF; }
  100% { background-color: #004A7F; box-shadow: 0 0 3px #004A7F; }
}

.active span {
  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;
}

</style>

<?php
$re = Session::get('re');
if($re){
    echo '<script language="javascript">';
    echo 'alert("Log in to continue testing!!!!!!")';  
    echo '</script>';
    Session::put('re',null);
}

?>




<div class="all-title-box">
    <div class="container text-center">
        <h1>Exam of test<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
    </div>
</div >
<div class="container">
    <div class="sub-title-test">
        <h3>Test</h3>
        <div class="row random ">

            <div class="col-md-4"> 
                {{-- <a data-url="{{asset('/start-random-example/'.$standard_strucs->filter_id)}}"><button  class="btn btn-primary pro-button w-100">Beginner</button> </a> --}}
            </div>

            @if($standard_strucs!=null)

            <div class="col-md-4">  

                <form id="payment" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_cart">
                    <input type="hidden" name="upload" value="1">
                    <input type="hidden" name="business" value="sb-s0hzi6951842@business.example.com">
                    <input type="hidden" name="item_name_1" value="Writting">
                    <input type="hidden" name="amount_1" value="0.50">
                    <input type="hidden" name="tax_1" value="0.05">
                    <input type="hidden" name="item_name_2" value="Speaking">
                    <input type="hidden" name="amount_2" value="0.50">
                    <input type="hidden" name="tax_2" value="0.05">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="return" id="cancel_return" value="{{ URL::to('/example-test/?fee=1&filter_id='.$standard_strucs->filter_id) }}" />
                    <input type="hidden" name="cancel_return" id="cancel_return" value="{{ URL::to('/example-test') }}" />

                    <button type="submit" class="btn btn-primary pro-button w-100" style="background: orange;">Examine</button>
                </form>

            </div>

            @endif
            
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {

       sessionStorage.clear();     
        
        $('[type="submit"]').click(function(e){
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'The Test has fee. Do you want to continue?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: 'orange',
            }).then(function(result){
                if (result.isConfirmed) {
                    $('#payment').submit();
                }
            });
        })

        //nếu đã thanh toán thành công
        @if(isset($_GET['fee']) && isset($_GET['filter_id']))

            url = "{{ URL::to('/start-random-example/'.$_GET['filter_id']) }}"

            $.get("{{ URL::to('/random-example/'.$_GET['filter_id']) }}?fee={{ $_GET['fee'] }}", function(response){
                
                if (typeof response.error === "undefined") {
                    Swal.showLoading();
                    window.location = url + `?result=${response.result_id}&lesson=${response.lesson_id}`;
                }else{
                    Swal.fire({
                        icon: 'error',
                        toast: true,
                        title: `${response.error}`,
                        position: 'top-end',
                        showConfirmButton: true,
                        confirmButtonColor: 'orange',
                    })
                }
            })

        @endif

    })
</script>


@endsection