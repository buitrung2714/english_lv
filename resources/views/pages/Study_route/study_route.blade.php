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
  width: 100%;
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
 /*  width: 50%; */
  border-color: #4c5a7d;
}
.form-wizard-steps li.active_fee::after,  .form-wizard-steps li.activated::after {
  background-color: #4c5a7d;
  left: 50%;
 /*  width: 50%; */
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
.wrap{
    display: flex;
    justify-content: center;
  
}
.form-wizard .form-wizard-header {
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
.active_fee span{
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
.active_fee span a{
    text-align: center;
    color: #fff;
}


@keyframes glowing {
    0% { background-color: #4c5a7d ; box-shadow: 0 0 3px #4c5a7d ; }
    50% { background-color: #28a745; box-shadow: 0 0 10px #28a745; }
    100% { background-color: #4c5a7d ; box-shadow: 0 0 3px #4c5a7d ; }
}

@keyframes glowing_fee {
    0% { background-color: #4c5a7d ; box-shadow: 0 0 3px #4c5a7d ; }
    50% { background-color: #ff9800 ; box-shadow: 0 0 10px #ff9800 ; }
    100% { background-color: #4c5a7d ; box-shadow: 0 0 3px #4c5a7d ; }
}
 
.active span {
    -webkit-animation: glowing 1500ms infinite;
    -moz-animation: glowing 1500ms infinite;
    -o-animation: glowing 1500ms infinite;
    animation: glowing 1500ms infinite;
}
.active_fee span{
    -webkit-animation: glowing_fee 1500ms infinite;
    -moz-animation: glowing_fee 1500ms infinite;
    -o-animation: glowing_fee 1500ms infinite;
    animation: glowing_fee 1500ms infinite;
}
.welcome{
    color: #fa5b0f; 
    
}
.descrip{
    text-align: center;
    font-size: 30px;
}
.list-route{
    text-align: center;
    font-size: 30px;
}
.sub-title-test h1{
    text-align: center;
    font-family: fantasy;
    color: black;
    
    margin-top: 70px;
}
.sub-title-test span p{
    text-align: center;
    font-family: none;
    color: black;
    text-transform: none;
    margin-top: 70px;
}




div.table{

    display: block;
    margin: 2px auto;
}


table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  

}
td,th{
    border: 1px solid #CD9B9B;

}
.tblstruc td, th {
  /* border: 1px solid #CD9B9B; */
  padding:  0rem    ;
  height: 50px;
  line-height: 50px;
}

.tblstruc tr, td{

   padding: 0rem    ;
   height: 40px;
   line-height: 40px;

}

table.dataTable tbody th, table.dataTable tbody td {
   padding: 0rem;
}

table.dataTable tbody th, table.dataTable tbody td {
   padding: 0rem;
}


tr:nth-child(odd) {
  background-color: #dddddd;
}
tr th:nth-child(6){
    background-color: #fff;
    border: 0px ;

}
/* #submit{
  border: 0px ;
  padding: 8px;
  background-color: ;
}
*/
.table th, .table td {
    padding: 0rem;
    padding-left: 0.7rem;
    padding-right: 0.7rem;
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
       <h1>Study Route<span class="m_1">Welcome to English Club</span></h1>
    </div>
</div >
<div class="container">
    <div class="sub-title-test">
        <h1 class="text-center">My English learning journey</h1>
        <div id="divRoute">
        @if($finished != [])
            @foreach($finished as $k => $finisheds)
            <?php $new_route =0; ?>
                @if($finisheds['total_mark'] !== null && $finisheds['route_id'] != null)
                    <?php 
                        
                        $s = $finisheds['created_at'];
                        $dt = new DateTime($s);
                        $date = $dt->format('m/d/Y'); 
                    ?>
                    <div><h5 >Start date: {{$date}}</h5></div>
                    <div id="easy-filter-radio" class="row">
                        <div class="col-md css">
                            <div class="form-wizard-header ">
                                <ul  class="route-test list-unstyled form-wizard-steps clearfix wrap">
                                    
                                    <?php $index =0;$flag =0;?>
                                    @foreach($data_detail_routes as $k => $detail_route)
                                        <?php $index++;  ?>
                                        
                                        @if($index == 1)

                                            @if($detail_route['skill_name'] != null)
                                            
                                            <li class="route_test active_fee" data-id="{{ $detail_route['filter_id'] }}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li> 

                                            @else
                                                <li class="route_test active" data-id="{{ $detail_route['filter_id'] }}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li>
                                            @endif

                                        @elseif($level_route >= $index && $index > 1)

                                            @if($detail_route['skill_name'] != null)
                                            
                                            <li class="route_test active_fee" data-id="{{ $detail_route['filter_id'] }}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li> 

                                            @else
                                                <li class="route_test active" data-id="{{ $detail_route['filter_id'] }}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li>
                                            @endif
                                        

                                        @elseif($flag == 1)

                                            <?php $flag =0; ?>
                                            
                                            @if($detail_route['skill_name'] != null)
                                            
                                            <li class="route_test active_fee" data-id="{{ $detail_route['filter_id'] }}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li> 

                                            @else
                                                <li class="route_test active" data-id="{{ $detail_route['filter_id'] }}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li>
                                            @endif
                                        
                                        @else
                                            <li data-url="{{asset('/show-random-example/'.$detail_route['filter_id'])}}"><span><a  class="test">{{$detail_route['detail_route_level']}}</a></span></li>
                                        @endif  
                                        
                                        @if($detail_route['GPA_route'] >= 5 && $detail_route['detail_route_level'] == count($data_detail_routes))
    
                                            <?php $new_route =1 ;break; ?>
                                        @elseif($detail_route['GPA_route'] >= 5  )
                                            <?php $flag =1; ?>
                                        @endif
                                    @endforeach
                                  
                                </ul>
                            </div>
                        </div>
                    </div>
                @elseif($finisheds['total_mark'] !== null && $finisheds['route_id'] == null)
                    
                    <button class="choice_route btn btn-primary pro-button w-100" >Select Study Route</button>
                @else
                    <span><p class="descrip">Study route pendding... </p></span>
                @endif
                @if($new_route ==1 )
                <?php $new_route = 0; ?>
                <div id="divChoice_route" style=" margin-top:10px ;">
                    <span><p class="descrip">Start new study route  </p></span>
                    <button  class="choice_route btn btn-primary pro-button w-100" >Select Study Route</button>
                </div>
                @endif
            @endforeach   
        @else
            <div style="text-align: center; " >
                <p><h3 >Hi @if(session()->get('student_name')) {{session()->get('student_name')}} @endif , Welcome to English Club</h3> </p>
                <button id="route"  class="btn btn-primary pro-button w-100" >Start Study Route</button>
            </div>
        @endif
        </div>
        <div class="modal fade" id="RouteModal" tabindex="-1" role="dialog" aria-labelledby="RouteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RouteModalTitle">Study Route</h5>
                        <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ol class="list-route">Select Study Route 
                            @foreach($list_routes as $k => $list_route)
                            <li><a href="{{ URL::to('/start-route/'.$list_route->route_id) }}">{{$list_route->route_name}}</a></li>
                            <span style="text-transform: initial;    font-size: x-large;">{!! $list_route->route_des!!}</span>
                            @endforeach
                        </ol> 
                    </div>
                 
                </div>
            </div>
        </div>


        @if($finished != [])

            @foreach($data_detail_routes as $k => $detail_route)
            <div class="modal fade" id="list_results_{{$detail_route['filter_id']}}" tabindex="-1" role="dialog" aria-labelledby="list_resultsTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="list_resultsTitle">Study Route</h5>
                            <button type="button" class="close close-detail-result" id="{{$detail_route['filter_id']}}" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-md-4"></div>
                            <div style="margin-bottom:10px" class="col-md-4 ">

                                @if($detail_route['skill_name'] != null)
                                <form id="payment" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_cart">
                                    <input type="hidden" name="upload" value="1">
                                    <input type="hidden" name="business" value="sb-s0hzi6951842@business.example.com">

                                    @foreach($detail_route['skill_name'] as $key => $skill)
                                        <input type="hidden" name="item_name_{{ $key + 1 }}" value="{{ $skill }}">
                                        <input type="hidden" name="amount_{{ $key + 1 }}" value="0.50">
                                        <input type="hidden" name="tax_{{ $key + 1 }}" value="0.05">
                                    @endforeach

                                    <input type="hidden" name="no_note" value="1">
                                    <input type="hidden" name="return" id="cancel_return" value="{{ URL::to('/study-route?filter='.$detail_route['filter_id'].'&fee='.(count($detail_route['skill_name']) * 0.50).'&route='.$detail_route['route_id']) }}" />
                                    <input type="hidden" name="cancel_return" id="cancel_return" value="{{ URL::to('/study-route') }}" />

                                </form>

                                <button class="startBtn active_fee btn btn-primary" data-fee="{{ count($detail_route['skill_name']) * 0.50 }}" data-url="{{asset('/show-random-example/'.$detail_route['filter_id'])}}" data-id="{{ $detail_route['filter_id'] }}" data-route="{{ $detail_route['route_id'] }}">Start</button> 

                                @else
                                    <button class="startBtn active btn btn-primary" data-fee="0" data-url="{{asset('/show-random-example/'.$detail_route['filter_id'])}}" data-id="{{ $detail_route['filter_id'] }}" data-route="{{ $detail_route['route_id'] }}">Start</button> 
                                @endif

                            </div>
                            </div>
                            @if(count($detail_route['list_results'] )>0)
                            <table id="tblDetail_results">
                                <tr id="trdetail">
                                    <td>No</td>
                                    <td>Date test</td>
                                    <td>Total mark</td>
                                </tr>
                                @foreach($detail_route['list_results'] as $k =>$list_result)
                                <tr>
                                    
                                        <td>{{ $k + 1 }}</td>
                                        <td>
                                        <?php 
                            
                                            $s = $list_result['created_at'];
                                            $dt = new DateTime($s);
                                            echo $date = $dt->format('m/d/Y'); 
                                        ?>
                                    
                                        <td>@if($list_result['total_mark']===null) Grading... @else {{$list_result['total_mark']}}  @endif</td>
                                   
                                </tr>
                                 @endforeach
                            </table>
                            @endif
                                
                        </div>
                     
                    </div>
                </div>
            </div>
            @endforeach
        @endif

    </div>
 </div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

@endsection

@section('javascript')

<script>
    
    $(document).ready(function() {

        @if(isset($_GET['fee']) && isset($_GET['route']) && isset($_GET['filter']))
            $.get("{{ URL::to('/random-example') }}/" + "{{ $_GET['filter'] }}" + '?fee=' + "{{ $_GET['fee'] }}"  + '&route=' + "{{ $_GET['route'] }}", function(response){
                window.location = "{{ URL::to('/show-random-example') }}/{{ $_GET['filter'] }}" + `?result=${response.result_id}&lesson=${response.lesson_id}&timer={{ time() }}`
            })
        @endif

        $('.choice_route').click(function () {
           $('#RouteModal').modal('show');
        });
        $('.close-detail-result').click(function(){
            
            $('#list_results_'+this.id).modal("hide");
        })
        $('#route').click(function () {
            window.location.href = '{{asset('/input-route')}}'; 
        })
        $('.route_test').click(function () {

            var id = $(this).data('id');
            
            $('#list_results_' + id).modal('toggle')
        })

        $('.startBtn').click(function () {
            selector_this = this;
            var url = $(this).data('url');
            var fee = $(this).data('fee');
            var id = $(this).data('id');
            var route = $(this).data('route');

            if (fee == 0) {

                Swal.fire({
                    title: 'Do you want to start ?',
                    showConfirmButton: true,
                    showDenyButton: true, 
                    confirmButtonColor: 'orange',
                    confirmButtonText: 'Now!',
                    denyButtonText: 'Not Now!'
                }).then(function(result){
                    if (result.isConfirmed) {
                        $.get("{{ URL::to('/random-example') }}/" + id + '?fee=' + fee  + '&route=' + route, function(response){
                            window.location = url + `?result=${response.result_id}&lesson=${response.lesson_id}&timer={{ time() }}`
                        })
                    }
                })

            }
            else{
                Swal.fire({
                    icon: 'question',
                    title: 'The Test has fee. Do you want to start?',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonColor: 'orange',
                }).then(function(result){
                    if (result.isConfirmed) {
                        $(selector_this).prev().submit();
                    }
                })
            }
        })

        $('#close').click(function(){
            
            $('#RouteModal').modal("hide");
        })
    });
</script>

@endsection