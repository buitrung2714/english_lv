@extends('welcome')

@section('content')
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" 
rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/
libs/bootswatch/4.5.2/materia/bootstrap.min.css">

<style>
.hidden {
    display: none;
    transition: width 2s;

}
.content {
  border-radius: 5px; 
  border: 1px solid #bbb;
  padding: 5px; margin: 5px; 
  float: left;
}

#filter {
    clear: left;
}
/* ====================== */


.qty .count {
    color: #000;
    display: inline-block;
    vertical-align: top;
    font-size: 25px;
    font-weight: 700;
    line-height: 30px;
    padding: 0 2px;
    min-width: 35px;
    text-align: center;
}
.qty .plus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: black;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    border: solid 1px;
    background-color: #e6e5e5;
}
.qty .minus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: black;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    /* background-clip: padding-box; */
    border: solid 1px;
    background-color: #e6e5e5;
}
div {
    text-align: center;
}
.minus:hover{
    background-color: #CD9B9B !important;
}
.plus:hover{
    background-color: #CD9B9B !important;
}
/*Prevent text selection*/
span{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
input{  
    border: 0;
    width: 2%;
}
nput::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input:disabled{
    background-color:white;
    color: black;
}

.skillcss{
    font-size: 16px;
    height: 50px;
    width: 100px;
    background: #8B636C;
    margin: 5px;

    border: solid 2px;
    border-color: #CD9B9B;
    border-radius: 5px;
    color:#fff;
    box-shadow: 0 0 1px #CD9B9B;
    -webkit-transition-duration: 0.2s;
    -webkit-transition-timing-function: linear;
    box-shadow:0px 0 0 #8B636C  inset;
}
.skillcss:hover{
    box-shadow:0 0 0  25px #CD9B9B  inset;
    -webkit-transform: scale(1);
    background: #CD9B9B;
    color: black ;
    border-color: #CD9B9B;
    
}

.checkskill{
    text-align: left;
}
h2{
    text-align: center;
}
.list-group{
    border-right: solid 1px;
    /* padding:5px; */
}
/* .list-group-item{
    padding: 0px 0px;
}
*/
.form-control{
    background-color: #e6e5e5;
    width: 40%;
    height: 30px;
    border-radius: 7px;

    
    display: block;
    margin: 7px auto;

}
input:disabled {

    text-align: center;
    background-color: #e6e5e5;
    width: 40%;
    height: 30px;
    border-radius: 7px;

    font-size: 20px;
    font-weight: bold;
    display: block;
    margin: 7px auto;
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


.labelcss{
   margin: 7px auto;
   font-style: italic;
}
.errorcss{
    margin: 7px 0px 0px -21px;
    color: red;
}

.list-structure{
    /* border: solid 1px black; */
    max-width: 80%;
    text-align: center;
    margin: 10px auto;
    padding: 15px;
}
.partcss1{
    background:#C50023;
    
}
.partcss2{
    background:#9c27b0 ;
}
.partcss3{
    background:#ff9800 ;
}
.partcss4{
    background:#4caf50 ;
}

.partcss1:hover{
    background:#8E1E20;

}
.partcss2:hover{
    background:#663366;
}
.partcss3:hover{
    background:#976D00;
}
.partcss4:hover{
    background:#9C9900;
}

.btn-lg, .btn-group-lg>.btn {
    padding: 0.3rem 0.5rem;
    font-size: 0.8rem;
    line-height: 1.5;
    border-radius: 0.3rem;
}
#example{
   padding: 0rem;
}
textarea[disabled], textarea[disabled]::placeholder, textarea.form-control[disabled], textarea.form-control[disabled]::placeholder, input.form-control[disabled], input.form-control[disabled]::placeholder, input[type=text][disabled], input[type=text][disabled]::placeholder, input[type=password][disabled], input[type=password][disabled]::placeholder, input[type=email][disabled], input[type=email][disabled]::placeholder, input[type=number][disabled], input[type=number][disabled]::placeholder, [type=text].form-control[disabled], [type=text].form-control[disabled]::placeholder, [type=password].form-control[disabled], [type=password].form-control[disabled]::placeholder, [type=email].form-control[disabled], [type=email].form-control[disabled]::placeholder, [type=tel].form-control[disabled], [type=tel].form-control[disabled]::placeholder, [contenteditable].form-control[disabled], [contenteditable].form-control[disabled]::placeholder {
    color: #000;
}
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #aaa;
    border-radius: 3px;
    padding: 5px;
    background-color: transparent;
    margin-left: 3px;
    width: 100%;
}
ul{
 list-style: none;
} 
ul li{
    font-weight: bold;
}

/* .dis-am-topic:hover{
    cursor:pointer;
} */
.dis-am-topic{
    pointer-events: none;
    /* cursor: not-allowed; */

}
</style>
{{-- <style type="text/css">    
#container {
    margin-right: -300px;
    float:left;
    width:100%;
}
#content {
    margin-right: 320px; /* 20px added for center margin */
}
#sidebar {
    width:300px;
    float:left
}

</style> --}}




<div class="all-title-box">
    <div >
        <h1>Exercise Test<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
    </div>
</div >

<form id="form_data" data-route="{{asset('/start-exercise')}}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-12">
        <div class="col-md-8 table" >

            <h2>Result Structure</h2>

            <table id="tblstruc">
                <tr id="trthead">  
                    <th>Skill</th>
                    <th>Part</th>
                    <th>Level</th>
                    <th>Amount Of Topic</th>
                    <th>Total Amount Question</th>
                    <th id="submit">
                        <button   value="" class="btn btn-primary pro-button w-100">Submit  </button>
                        <div id="paypal"></div>
                    </th>
                </tr>
            </table>

        </div>

    </div>
</form>

<br>

 <h2>Select Filter Structure<i data-toggle="modal" data-target=".bd-example-modal-xl" style="color:red; cursor: pointer;padding-left: 10px;" class="fa fa-info-circle" aria-hidden="true"></i></h2>

{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> --}}

<div class="modal fade bd-example-modal-xl " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <span style="padding: 20px; font-size:40px;"> <b>Filter manual</b>  </span>
            <img src="file/help/User_manual.png" alt="">
        </div>
    </div>
</div>

<div class="col-12" >
    <div class="row">
        <div >
            <ul  class="list-group list-group-flush">
                <li class="list-group-item ">
                    <div class=" checkskill custom-control custom-checkbox">
                        <input type="checkbox" class=" custom-control-input" id="check_all" >
                        <label class=" custom-control-label" for="check_all">Check All</label>
                    </div>
                    @foreach($allSkill as $k => $allSkills)
                    <div class=" checkskill custom-control custom-checkbox">
                        <input type="checkbox" class="check_skill custom-control-input" id="{{$allSkills->skill_id}}" name="{{$allSkills->skill_name}}" >
                        <label class=" custom-control-label" for="{{$allSkills->skill_id}}">{{$allSkills->skill_name}}</label>
                        
                    </div>
                    @endforeach
                </li>
            </ul>
        </div>

        <div class="col-md ">
            <div class="btn-group btn-group-toggle mb-3 d-flex flex-column flex-md-row abc" id="choiceSkill">
                <label class="btn  skillcss" id="all_part">
                    <input type="checkbox"  name="options"   > all
                </label>
            </div>
            <?php $classPartcss = array("partcss1","partcss1","partcss2","partcss3","partcss4"); $in=0;?>
            @foreach($allSkill as $k => $allSkills) 
            <?php $in++ ?>
            <div class="all-part hidden" style="padding:5px;" id="divskill{{$allSkills->skill_id}}"  >
                <div  class="row">
                    <p style="width: 50px;">{{$allSkills->skill_name}}</p>
                    @foreach($allpart as $k => $allparts)
                    @if($allSkills->skill_id==$allparts->skill_id)
                    
                    <div class="col-md  " {{-- style="display:none;" --}}>
                        <button  class="{{$classPartcss[$in]}} btn btn-primary pro-button w-100 btnpart" id="{{$allparts->part_id}}" name="{{$allparts->part_name}}" data-skill_name="{{$allSkills->skill_name}}" data-amount_ques="{{$allparts->part_amount_ques_per_topic}}" data-skill_id="{{$allSkills->skill_id}}">{{$allparts->part_name}} </button> 

                        <div class="selpart " id="sel_part_{{$allparts->part_id}}">
                            <div  class="row">
                                <label class="labelcss col-md">Level: </label>
                                <select class="col-md-6 form-control mySelectBox resetSel{{$allSkills->skill_id}}" id="sel_id{{$allparts->part_id}}" >
                                    <option class="option_level" disabled="disabled" id="{{$allparts->part_id}}" value="random_level" data-level_name="random_level" selected="selected"> Choice Level</option>

                                    @foreach($allLevel as $k => $allLevels)
                                    <option  class="option_level" id="{{$allparts->part_id}}" value="{{$allLevels->level_id}}" data-level_name="{{$allLevels->level_name}}">{{$allLevels->level_name}}
                                    </option>
                                    @endforeach
                                </select>

                                <label class="errorcss col-md"  id="error{{$allparts->part_id}}"></label>

                                
                            </div>
                            <div class="row">
                                <label class="labelcss col-md">Amount Topic </label>
                                <div class="qty mt-1 col-md-6"  >
                                    <span  class="minus dis-am-topic  amount-topic{{$allparts->part_id}}" id="{{$allparts->part_id}}">-</span>
                                    <input  type="number" data-part_id="{{$allparts->part_id}}" disabled="disabled" class="count resetAmount_topic{{$allSkills->skill_id}}" id="part_{{$allparts->part_id}}" name="qty" value="1">
                                    <span  class="plus dis-am-topic amount-topic{{$allparts->part_id}}"  id="{{$allparts->part_id}}">+</span>
                                </div>
                                <label class=" col-md"  id="">Topic Max: {{$allparts->part_topic_max}}</label>
                                <label class="errorcss col-md" id="error_amount{{$allparts->part_id}}"></label>

                            </div>
                            <div class="row">

                                <label class="labelcss col-md">Amount Ques </label>
                                <input class="col-md-6 resetAmout_ques{{$allSkills->skill_id}}"  type=" text" id="amout_ques{{$allparts->part_id}}" name="lname" value="{{$allparts->part_amount_ques_per_topic}}" disabled style="color: black;">
                                <label class="errorcss col-md"></label>

                            </div>

                        </div>


                    </div>
                    
                    @endif
                    @endforeach
                </div>

            </div>
            @endforeach
        </div>

    </div>
</div>
<br>
<br>
<br>
<hr style="background-color:background; heght:5px">


<div class="list-structure">
    <h2>Result List</h2>
    
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr class="resultcss">
                <th>No </th>
                <th>Stuture</th>
                <th>Created At</th>
                <th>Total Mark</th>

                <th>Rebuild</th>


            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
            @if($list_lesson_id != null)

                @foreach($list_lesson_id as $k => $list_lesson_ids)
                <tr class="resultcss" >
                    <td style="width: 20px"><?php echo ++$i ?></td>
                    <td >
                        @if($list_lesson_ids['filter_status']==0)
                            User Structure
                        @elseif($list_lesson_ids['lesson_status'] == 2)
                            Route Test
                        @elseif(($list_lesson_ids['filter_status']==1) && ($list_lesson_ids['lesson_status'] == 0))
                            Standard Structure
                        @elseif(($list_lesson_ids['filter_status']==2) || ($list_lesson_ids['lesson_status'] == 1))
                            Lesson Sample
                        @elseif(($list_lesson_ids['filter_status']==3))
                            Input Route
                        @endif
                    </td>
                    <td>{{ date("d/m/Y H:i:s", strtotime($list_lesson_ids['created_at'])) }}</td>
                    
                    @if($list_lesson_ids['total_mark'] === null && $list_lesson_ids['unfinish'] == 1)

                        <td>Unfinished</td>

                    @elseif(($list_lesson_ids['skill_fee'] != null) && ($list_lesson_ids['total_mark'] === null) && ($list_lesson_ids['fee'] > 0)) 

                        <td>Grading...</td>

                    @else

                        <td>{{$list_lesson_ids['total_mark']}}</td>

                    @endif
                    
                    <td> 
                        <a id="{{$list_lesson_ids['result_id']}}" data-result_status="{{$list_lesson_ids['result_status']}}" data-total_mark="{{$list_lesson_ids['total_mark']}}" data-filter_status="{{$list_lesson_ids['filter_status']}}" data-fee="{{ $list_lesson_ids['fee'] }}" data-lesson_status="{{ $list_lesson_ids['lesson_status'] }}" class="detail-result btn btn-info  btn-lg">
                            More!
                        </a>

                 {{-- =======================================KỸ NĂNG MIỄN PHÍ======================================= --}}
                       
                       @if($list_lesson_ids['skill_fee'] == null)

                        <a class="btnRe btn btn-success btn-lg" data-status="0" data-id="{{ $list_lesson_ids['filter_id'] }}" data-result_id="{{$list_lesson_ids['result_id']}}" data-lesson_id="{{ $list_lesson_ids['lesson_id'] }}" data-route_id="{{ $list_lesson_ids['route_id'] }}">
                            <span class="glyphicon glyphicon-edit"></span> Re-Examine
                        </a>

                    {{-- =======================================KỸ NĂNG THU PHÍ======================================= --}}

                      @else

                        <form class="payment" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" style="display:inline;"> 
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="upload" value="1">
                            <input type="hidden" name="business" value="sb-s0hzi6951842@business.example.com">

                            @foreach($list_lesson_ids['skill_fee'] as $k => $item)

                                <input type="hidden" name="item_name_{{ $k + 1 }}" value="{{ $item }}">
                                <input type="hidden" name="amount_{{ $k + 1 }}" value="0.50">
                                <input type="hidden" name="tax_{{ $k + 1 }}" value="0.05">
                            
                            @endforeach

                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="no_note" value="1">

                            @if($list_lesson_ids['route_id'] == null)

                                <input type="hidden" name="return" id="cancel_return" value="{{ URL::to('/exercise-test?filter_id='.$list_lesson_ids['filter_id'].'&fee='.count($list_lesson_ids['skill_fee']) * 0.50) }}" />

                            @else
                                <input type="hidden" name="return" id="cancel_return" value="{{ URL::to('/exercise-test?filter_id='.$list_lesson_ids['filter_id'].'&fee='.count($list_lesson_ids['skill_fee']) * 0.50).'&route='.$list_lesson_ids['route_id'] }}" />

                            @endif

                              <input type="hidden" name="cancel_return" id="cancel_return" value="{{ URL::to('/exercise-test') }}" />
                            
                            <button type="submit" data-status="1" data-id="{{ $list_lesson_ids['filter_id'] }}" data-result_id="{{$list_lesson_ids['result_id']}}" data-fee="{{ $list_lesson_ids['fee'] }}" data-lesson_id="{{ $list_lesson_ids['lesson_id'] }}" class="btnRe btn btn-warning btn-lg" style="color: #444;">Re-Examine</button>

                        </form>

                      @endif

                    {{-- =======================================KỸ NĂNG THU PHÍ======================================= --}}

                        <a  id="{{$list_lesson_ids['filter_id']}}"  class="btnRebuild btn btn-danger btn-lg">
                            <span class="glyphicon glyphicon-edit"></span> Rebuild
                        </a>


                    </td>

                </tr>

                @endforeach

            @endif
            
        </tbody>
    </table>


 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Modal Header</h4>
            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>
        <div class="modal-body">
            <div id="fluent_mark"></div>
            <div id="re_mark"></div>
            <table id="tblDetail_results">
                <tr id="trdetail">
                    <td>Skill Name</td>
                    <td>Mark Skill</td>
                </tr>
            </table>
            
        </div>

    </div>

</div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

  <script type="text/javascript" >

@if(session()->has('success'))
    Swal.fire({
        icon: 'success',
        title: '{{ session()->get('success') }}',
        showConfirmButton: true,
        confirmButtonColor: 'orange',
    });
@endif

$(document).ready(function(){
    sessionStorage.clear();
    
    $('#paypal').hide()

    //nếu đã thanh toán thành công ========>>>>>> LÀM LẠI BÀI HỌC TÍNH PHÍ
    @if(isset($_GET['fee']) && isset($_GET['filter_id']))

        url = "{{ URL::to('/start-random-example/'.$_GET['filter_id']) }}"

        @if(!isset($_GET['route']))
            url_ajax = "{{ URL::to('/random-example/'.$_GET['filter_id']) }}?fee={{ $_GET['fee'] }}";
        @else
            url_ajax = "{{ URL::to('/random-example/'.$_GET['filter_id']) }}?fee={{ $_GET['fee'] }}&route={{ $_GET['route'] }}";
        @endif

        $.get(url_ajax , function(response){
            
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
        
        // ========>>>>>> LÀM LẠI BÀI HỌC TÍNH PHÍ

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    error_level = new Array();
    
    $('.btnRe').click(function(e){
        e.preventDefault();
        
        //nếu bài miễn phí
        if ($(this).data('status') == 0) {
            
            var fil_id = $(this).data('id');
            var result_id = $(this).data('result_id');
            var type_lesson = $(this).parents().parents().children('td:nth-child(2)');
            var lesson_id = $(this).data('lesson_id');
            var status_mark = $(this).parents().parents().children('td:nth-child(4)');
            var route = $(this).data('route_id');

            if($(type_lesson).text().trim() != 'Lesson Sample'){

                Swal.fire({
                    icon: 'question',
                    title: 'Are you want to Re-Exam?',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonColor: 'orange', 
                }).then(function(result){
                    if (result.isConfirmed) {

                        if ($(status_mark).text() == 'Unfinished') {
                            window.location.href = "{{ URL::to('/show-random-example/') }}/" + fil_id +'?result=' + result_id + '&lesson=' + lesson_id + '&timer={{ time() }}';
                        }else{

                                if ($(type_lesson).text().trim() == 'Input Route') {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Input Route use only once !',
                                        showConfirmButton: true,
                                        confirmButtonColor: 'orange',
                                    })
                                }

                                url = "{{ URL::to('/start-random-example') }}/";

                                if (route != "") {
                                    url_ajax = "{{ URL::to('/random-example') }}/"+fil_id+"?fee=0&route=" + route;
                                }
                                else{
                                    url_ajax = "{{ URL::to('/random-example') }}/"+fil_id+"?fee=0";
                                }
                                
                                $.get(url_ajax, function(response){
                                if (typeof response.error === "undefined") {
                                    window.location = url + fil_id + `?result=${response.result_id}&lesson=${response.lesson_id}`;
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
                        }
                    }
                });
                
            }else{
                //nếu bài học mẫu đã hoàn thành
                if ($(status_mark).text().trim() != 'Unfinished') {
                    Swal.fire({
                        icon: 'warning',
                        title: $(type_lesson).text().trim() + ' only use once !',
                        showConfirmButton: true,
                        confirmButtonColor: 'orange'
                    })
                }
                //nếu bài học mẫu chưa hoàn thành
                else{
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you want to Re-Exam?',
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: 'orange',
                    }).then(function(result){
                        if (result.isConfirmed) {
                            window.location = "{{ URL::to('/show-lesson-sample') }}/" + lesson_id + '?result=' + result_id;
                        }
                    }) 
                }
            }
        }
        //nếu bài có tính phí
        else{
            var ar_err = [];
            var flag = 0;
            var form_payment = $(this).parents();
            var fil_id = $(this).data('id');
            var result_id = $(this).data('result_id');
            var type_lesson = $(this).parents().parents().parents().children('td:nth-child(2)');
            var lesson_id = $(this).data('lesson_id');
            var fee = $(this).data('fee');
            var status_mark = $(this).parents().parents().parents().children('td:nth-child(4)');

            $.ajax({
                type: 'POST',
                url:'{{asset('/detail-result')}}',
                data:{
                    result_id:result_id
                },
                success: function(response){
                    
                    $.each(response,function(i,v){
                        if ((v.skill_name == 'Listening' || v.skill_name == 'Reading') && v.mark === null) {
                            ar_err.push(v.mark);
                        }
                    });

                    //nếu đã thu phí nhưng chưa hoàn thành bài học
                    if ($(status_mark).text().trim() == 'Unfinished') {
                        Swal.fire({
                            icon: 'question',
                            title: 'Are you want to Re-Exam?',
                            showConfirmButton: true,
                            showCancelButton: true,
                            confirmButtonColor: 'orange',
                        }).then(function(res){
                            if (res.isConfirmed) {

                                //nếu khac bài hoc mẫu
                                if ($(type_lesson).text().trim() != 'Lesson Sample') {
                                    window.location = "{{ URL::to('/show-random-example/') }}/" + fil_id +'?result=' + result_id + '&lesson=' + lesson_id + '&timer={{ time() }}';
                                }
                                //nếu là bài học mẫu
                                else{
                                    window.location = "{{ URL::to('/show-lesson-sample') }}/" + lesson_id + '?result=' + result_id;
                                }
                            }
                        })
                    }
                    else{
                        //nếu là cấu trúc người học
                        if($(type_lesson).text().trim() == 'User Structure'){
                            Swal.fire({
                                icon: 'question',
                                title: 'Need you mark by Teacher?',
                                showConfirmButton: true,
                                showDenyButton: true,
                                confirmButtonColor: 'orange',
                                denyButtonText: 'No',
                            }).then(function(result){
                                if (result.isConfirmed) {

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Please pay to continue !',
                                        showDenyButton: true,
                                        confirmButtonText: 'Now!',
                                        confirmButtonColor: 'orange',
                                        denyButtonText: 'Not Now!',
                                    }).then(function(re){
                                        if (re.isConfirmed) {
                                            $(form_payment).submit();
                                        }
                                    })
                                    
                                }
                                else{
                                    Swal.fire({
                                        title: 'Do you want to start?',
                                        showDenyButton: true,
                                        confirmButtonText: 'Now!',
                                        confirmButtonColor: 'orange',
                                        denyButtonText: 'Not Now!',
                                    }).then(function(res){
                                        if (res.isConfirmed) {
                                             url = "{{ URL::to('/start-random-example') }}/";

                                             $.get("{{ URL::to('/random-example') }}/"+fil_id+"?fee=0", function(response){
                                                if (typeof response.error === "undefined") {
                                                    window.location = url + fil_id + `?result=${response.result_id}&lesson=${response.lesson_id}`;
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
                                        }
                                    })
                                }
                            });
                        }
                        //nếu là cấu trúc chuẩn
                        else if($(type_lesson).text().trim() == 'Standard Structure' || $(type_lesson).text().trim() == 'Route Test'){
                            
                            Swal.fire({
                                    icon: 'warning',
                                    title: 'The Test has fee. Please pay to continue !',
                                    showConfirmButton: true,
                                    showCancelButton: true,
                                    confirmButtonColor: 'orange',
                                }).then(function(re){
                                if (re.isConfirmed) {
                                    $(form_payment).submit();
                                }
                            })
                        }
                        //nếu là bài học mẫu hoặc đầu vào có điểm
                        else if($(type_lesson).text().trim() == 'Lesson Sample' || $(type_lesson).text().trim() == 'Input Route'){

                            Swal.fire({
                                icon: 'warning',
                                title: $(type_lesson).text().trim() + ' only use once !',
                                showConfirmButton: true,
                                confirmButtonColor: 'orange'
                            })
                        }
                    }
                }
            });
        }
    });

    $('.detail-result').click(function(){

        $('#myModal').modal("show");
        var result_id = $(this).attr('id');
        var fee = $(this).data('fee');
        var filter_status = $(this).data('filter_status');
        var lesson_status = $(this).data('lesson_status');
        var result_status = $(this).data('result_status');
        var total_mark = $(this).data('total_mark')
        
    $.ajax({
        type: 'POST',
        url:'{{asset('/detail-result')}}',
        data:{
            result_id:result_id
        },
        success:function(data) {
            
            var tampSkill = '';
            var mark = 0;
            var num_skill=0;

            $("#tblDetail_results  tr").not($('#trdetail')).empty();
            $(data).each(function() {

                var skill_name= this['skill_name'];

                if(skill_name != tampSkill ){
                    num_skill++;
                    mark = this['mark'];
         
                    if(mark == null && fee > 0){

                        //nếu là kỹ năng nói, viết
                         if (skill_name == 'Writting' || skill_name == 'Speaking') {
                            mark = 'Grading...';
                         }
                         //nếu kỹ năng nghe đọc
                         else{
                            mark = 0; 
                         }

                    }else if(mark == null && fee == 0){
                        mark = 0;
                    }
                    
                    var td_detail_result = $(`<tr>
                     <td>`+skill_name+`</td>
                     <td id="`+skill_name+`">`+mark+`</td>
                     </tr>`)
                    $("#tblDetail_results").append(td_detail_result);
                    tampSkill= skill_name;

                    }else if(skill_name == tampSkill){
                        var marktamp = this['mark'];
                        
                        if(marktamp === null){ marktamp=0; }

                        if (marktamp !== null && $('td#'+skill_name).text() != 'Grading...') {
                           
                            mark = (parseFloat($('td#'+skill_name).text()) + marktamp).toFixed(2);

                            $('td#'+skill_name).html(mark);
                        }         
                    }
                });
            
            if(filter_status == 1 && lesson_status == 0){
                $("#fluent_mark ").empty();

                if(typeof total_mark == 'string' && total_mark == ""){
                    
                    var dtb = 'Grading...'
                }else if (total_mark >= 0) {
                    var dtb = (total_mark / num_skill).toFixed(1);
                    
                 }

                var fluent = '';
                if(dtb < 4){
                    fluent = 'No Rank'
                }else if(dtb >= 4 && dtb <6){
                    fluent = 'B1';
                }else if(dtb >=6 && dtb <8.5){
                    fluent = 'B2';
                }else if(dtb >=8.5 && dtb <10){
                    fluent = 'C1';
                }

                var ul_fluent_mark = $(`<ul class="menu-mark">
                    <li>Avarage Mark: `+ dtb +`</li>
                    <li>Fluent in English: `+ fluent +` </li>
                    </ul>`)
                $("#fluent_mark").append(ul_fluent_mark);
            }else{
                $("#fluent_mark").empty();
            }

            //tạo yêu cầu chấm lại bài
            if(result_status == 1){
                $("#re_mark").html(`<button class="btn btn-primary" disabled id="remarkBtn" data-id="${result_id}" style="padding: 10px;color: #fff">Request...</button><br><br>`)
            }else if (result_status == 2) {
                $("#re_mark").html(`<button class="btn btn-secondary" disabled id="remarkBtn" data-id="${result_id}" style="padding: 10px;">Done</button><br><br>`)
            }else if ((fee > 0) && (typeof total_mark != 'string' && total_mark != "")) {
                $("#re_mark").html(`<a class="btn btn-primary" id="remarkBtn" data-id="${result_id}" style="padding: 10px;color: #fff">Re-mark</a><br><br>`)
            }else{
                 $("#re_mark").empty()
            }
        }
    });
});

    //khi chọn phúc khảo bài
    $(document).on('click','#remarkBtn',function(){
        var result_id = $(this).data('id');

        Swal.fire({
            icon: 'question',
            title: 'Do you want to re-mark?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: 'orange',
        }).then(function(result){
            if (result.isConfirmed) {
                window.location = "{{ URL::to('/remark') }}/" + result_id;
            }
        });
    });


    $('.close').click(function(){
       $('#myModal').modal("hide");
   })

    $('#example').DataTable();
    $(document).on('click','.btnRebuild',function(event){
            var filter_id = $(this).attr('id');
            $('.dis-am-topic').css("pointer-events", "auto");
            $.ajax({
                type: 'POST',
                url:'{{asset('/rebuild')}}',
                data:{
                    filter_id:filter_id
                },
                success:function(data){
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you want to rebuild structure?',
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: 'orange',
                    }).then(function(result){
                        if(result.isConfirmed){
                            error_level=[];
                            $(".errorcss").empty(); 
                            $(".check_skill").each(function() {
                                this.checked=false;
                                $('label').remove('#'+this.id);
                            });
                            $('.all-part').hide();
                            $("#tblstruc  tr").not($('#trthead')).empty();
                            $('.selpart').hide();
                            var tamp='';
                            $(data['filter_part']).each(function() {

                                var part_id = this['part_id'];
                                var skill_id = this['skill_id'];
                                var skill_name = this['skill_name'];
                                var part_name = this['part_name'];
                                var filter_topic_level = this['filter_topic_level'];
                                var filter_part_amount_topic = this['filter_part_amount_topic'];
                                var level_name = '';

                                //check skill
                                $(data['all_level']).each(function(){
                                    if(this['level_id'] == filter_topic_level){
                                        level_name = this['level_name'];
                                    }
                                })

                                $('input#'+this['skill_id']).prop("checked", true);

                                if(skill_id != tamp){
                                    tamp =skill_id;
                                    var skill = $(' <label class="btn  skillcss skill" id="'+skill_id+'"><input type="checkbox" checked name="options">'+this['skill_name']+'</label>');
                                    $("#choiceSkill").append(skill);
                                }

                                $("#check_all").prop("checked", false);

                                //show div btnPart
                                $('.all-part'+'#divskill'+skill_id).show();
                                $("#all_part").css('background','#CD9B9B');

                                //chonj part show
                                $('#sel_part_'+part_id).show();
                                //combobox
                                $('#sel_id'+part_id+' option').each(function() {
                                    $(this).removeAttr('selected');
                                    if($(this).data('level_name').trim() == level_name){
                                        $(this).attr("selected","selected");
                                    }
                                    
                                });
                                //amount topic
                                $('#part_'+part_id).val(filter_part_amount_topic);
                                //amount ques
                                var total_ques = $('#amout_ques'+part_id).val($('#amout_ques'+part_id).attr('value')*filter_part_amount_topic).val();
                                var tblpart = $(`<tr id="`+skill_id+part_id+`" class="`+skill_id+`">
                                    <td  >`+skill_name+`</td > 
                                    <td name="`+part_id+`" id="part_name`+part_id+`">`+part_name+`</td> 
                                    <td name="`+filter_topic_level+`" id="part_level`+part_id+`">`+level_name+` </td> 
                                    <td name="`+filter_part_amount_topic+`" id="amountOfTopic`+part_id+`">`+filter_part_amount_topic+`</td> 
                                    <td id="totalQ`+part_id+`">`+total_ques+`</td> 
                                    //                  </tr>`)
                              
                                $("#tblstruc").append(tblpart);

                            });
                            var isAllChecked = 0;
                            $(".check_skill").each(function() {
                                if (!this.checked)
                                    isAllChecked = 1;
                            });
                            if (isAllChecked == 0) {
                                $("#check_all").prop("checked", true);
                            }
                        }
                    });   
                }
            });
        });

        $('.selpart').hide();
        $(document).on('click','.plus',function(){
            selector_this = this;
            var amout_ques =$('#amout_ques'+this.id).attr('value');
            var amount_topic = $('#part_'+this.id).val(parseInt($('#part_'+this.id).val()) + 1 ).val();
            var total_ques =$('#amout_ques'+this.id).val(amout_ques * amount_topic ).val();

            var route = "{{URL::to('/check-filter')}}";
            var part_id = $(this).attr('id');
            var level_id = $('#part_level'+this.id).attr('name');
            if(level_id!='random_level'){
                $.ajax({
                    type: 'POST',
                    url: route,
                    data:{
                        level_id:level_id,
                        part_id:part_id,
                    },
                    success:function(data) {
                        part_id =data['part_id']*1;
                        if($(selector_this).prev().val() > data['amountMax'] ){

                            $('#error_amount'+data['part_id']).html('*Amount max data');

                            var part_id = data['part_id']*1;
                            if(error_level.length > 0)
                            {
                                    // c    onsole.log(1);
                                    $.each(error_level , function(index, val) { 
                                        if(jQuery.inArray(part_id, error_level) === -1) {
                                            error_level.push(part_id);
                                        } 
                                    });
                            }else{ 
                                    error_level.push(part_id);
                            }
                        }else if(data['check']!=0){
                            $('#amountOfTopic'+data['part_id']).html(amount_topic);
                            $('#amountOfTopic'+data['part_id']).attr('name', amount_topic);
                            $('#totalQ'+data['part_id']).html(total_ques);
                            $("#error_amount"+data['part_id']).empty();
                            
                        }
                        if(data['check']==0 && $(selector_this).prev().val() < data['amountMax']){
                            $('#amountOfTopic'+data['part_id']).html(amount_topic);
                            $('#amountOfTopic'+data['part_id']).attr('name', amount_topic);
                            $('#totalQ'+data['part_id']).html(total_ques);
                            $("#error_amount"+data['part_id']).empty();
                           
                        }else if(data['check'] < amount_topic){
                            $('#error_amount'+data['part_id']).html('*Amount max data');
                            if(error_level.length > 0){
                                $.each(error_level , function(index, val) { 
                                    if(jQuery.inArray(part_id, error_level) === -1) {
                                         error_level.push(part_id);
                                    } 
                                });
                            }else{ 
                                error_level.push(part_id);
                            }
                            
                        }
                        //moi them
                        if(data['check']<amount_topic)
                        {
                            $('#error_amount'+data['part_id']).html('*Amount max data');
                            if(error_level.length > 0){
                                $.each(error_level , function(index, val) { 
                                    if(jQuery.inArray(part_id, error_level) === -1) {
                                        error_level.push(part_id);
                                     } 

                                 });
                            }else{ 
                                error_level.push(part_id);
                            }
                        }
                    }
                });

            }else{
                $('#amountOfTopic'+this.id).html(amount_topic);
                $('#amountOfTopic'+this.id).attr('name', amount_topic);
                $('#totalQ'+this.id).html(total_ques);
            }
        });

        $(document).on('click','.minus',function(){
            var amount_topic =$('#part_'+this.id).val(parseInt($('#part_'+this.id).val()) - 1 ).val();
            var amout_ques =$('#amout_ques'+this.id).attr('value');
            (amount_topic == 0) ? amount_topic=1 : amount_topic;
            var total_ques =$('#amout_ques'+this.id).val(amout_ques * amount_topic ).val();
            var route = "{{URL::to('/check-filter')}}";
            var part_id = $(this).attr('id');
            var level_id = $('#part_level'+this.id).attr('name');
            if(level_id!='choice'){
                $.ajax({
                    type: 'POST',
                    url: route,
                    data:{
                        level_id:level_id,
                        part_id:part_id,
                    },
                    success:function(data) {
                        part_id = data['part_id']*1;
                        if(amount_topic > data['amountMax'] ){

                            $('#error_amount'+data['part_id']).html('*Amount max data');
                        }else if(amount_topic<= data['amountMax']){
                            $("#error_amount"+data['part_id']).empty();

                            $('#amountOfTopic'+data['part_id']).html(amount_topic);
                            $('#amountOfTopic'+data['part_id']).attr('name', amount_topic);
                            $('#totalQ'+data['part_id']).html(total_ques);

                            const  valueToRemove = data['part_id'] ;
                            error_level = error_level.filter(item => !valueToRemove.includes(item));
                        } 
                        else if(data['check']!= 0){
                            $('#amountOfTopic'+data['part_id']).html(amount_topic);
                            $('#amountOfTopic'+data['part_id']).attr('name', amount_topic);
                            $('#totalQ'+data['part_id']).html(total_ques);
                            $("#error_amount"+data['part_id']).empty();
                        }
                        if(data['check']<amount_topic)
                        {
                            $('#error_amount'+data['part_id']).html('*Amount max data');
                            if(error_level.length > 0){
                                $.each(error_level , function(index, val) { 
                                    if(jQuery.inArray(part_id, error_level) === -1) {
                                        error_level.push(part_id);
                                     } 
                                 });
                            }else{ 
                                error_level.push(part_id);
                            }
                        }
                    }
                });
            }
            else{
                $('#amountOfTopic'+this.id).html(amount_topic);
                $('#amountOfTopic'+this.id).attr('name', amount_topic);
                $('#totalQ'+this.id).html(total_ques);
            }
            if ($('#part_'+this.id).val() == 0) {
                $('#part_'+this.id).val(1);
                $('#amout_ques'+this.id).val(amout_ques);
            }
        });

                    $("#check_all").change(function() {
                        if (this.checked) {
                            $(".check_skill").each(function() {
                                $('label').remove('#'+this.id);
                                this.checked=true;
                                var skill = $(' <label class="btn  skillcss skill" id="'+this.id+'"><input type="checkbox"  name="options">'+this.name+'</label>');
                                $("#choiceSkill").append(skill);
                            });
                        }else {
                            error_level=[];
                            $(".errorcss").empty(); 
                            $('.mySelectBox').each(function () {
                                $(this).prop('selectedIndex',0);
                            });
                            $('.count').each(function () {
                                var val = $(this).attr('value');
                                $(this).val(val);
                            })
                            $('.amount_ques').each(function () {
                                var val = $(this).attr('value');
                                $(this).val(val);
                            })
                            $(".check_skill").each(function() {
                                this.checked=false;
                                var id ='skill_'+this.id;
                                $('label').remove('#'+this.id);
                            });
                            $('.selpart').hide();
                            $(".all-part").hide();
                            
                            $("#tblstruc  tr").not($('#trthead')).each(function () {
                                $(this).remove();
                            });
                        }
                    });

                    $(".check_skill").click(function () {

                        if ($(this).is(":checked")) {
                            var isAllChecked = 0;
                            var skill = $(' <label class="btn  skillcss skill" id="'+this.id+'"><input type="checkbox" checked name="options">'+this.name+'</label>');
                            $("#choiceSkill").append(skill);


                            $(".check_skill").each(function() {

                                if (!this.checked)
                                    isAllChecked = 1;
                            });

                            if (isAllChecked == 0) {
                                $("#check_all").prop("checked", true);
                            }     
                        }
                        else {
                            $("#check_all").prop("checked", false);
                            var id ='skill_'+this.id;
                            $('label').remove('#'+this.id);
                            $('#divskill'+this.id).hide();
                            $('tr').remove('.'+this.id);


                            $('.resetAmout_ques'+this.id).each(function() {

                                var amout_ques = $(this).attr('value');
                                var valueToRemove = $(this).attr('id').substr(10)

                                $(this).val(amout_ques);
                                
                                error_level = error_level.filter(item => !valueToRemove.includes(item));
                                $("#error"+valueToRemove).empty();  
                                $('#error_amount'+valueToRemove).empty();  

                            }); 
                            var amount_topic = $('.resetAmount_topic'+this.id).val(1).val();

                            $('.resetSel'+this.id).prop('selectedIndex',0);           

                        }

                    });

                    $(document).on('click','.skill',function(){
                        $(".all-part").show();
                        $(".all-part").not($('#divskill'+this.id)).hide();
                        $(this).css('background','#CD9B9B');
                        $(".skillcss").not($(this)).css('background-color','#8B636C');
                        $("#all_part").css('background','#8B636C');

                    });
                    $(document).on('click','#all_part',function(){
                        $(".skillcss").css('background','#8B636C');
                        $(this).css('background','#CD9B9B');

            $(".check_skill").each(function() {
                if ($(this).is(":checked")) {
                    $('#divskill'+this.id).show();
                }
                else if(!this.checked){
                    $('#divskill'+this.id).hide();
                } 
            });


        });

      $(document).on('click','.btnpart',function(){
        var skill_id = $(this).data('skill_id');
        var skill_name = $(this).data('skill_name');
        var amount_ques = $(this).data('amount_ques');

        if($('#sel_part_'+this.id).is(":hidden"))
        {
            $('#sel_part_'+this.id).show(700);
            var tblpart = $(`<tr id="`+skill_id+this.id+`" class="`+skill_id+`">
            <td  >`+skill_name+`</td > 
            <td name="`+this.id+`" id="part_name`+this.id+`">`+this.name+`</td> 
            <td name="choice" data-part_id="`+this.id+`" id="part_level`+this.id+`"> </td> 
            <td name="1" id="amountOfTopic`+this.id+`">1</td> 
            <td id="totalQ`+this.id+`">`+amount_ques+`</td> 
            </tr>`)

            $("#tblstruc").append(tblpart);
        }
        else{
            $('#sel_part_'+this.id).hide();
            $('tr').remove('#'+skill_id+this.id);
            //reset btnPart
            var amout_ques =$('#amout_ques'+this.id).attr('value');
            var amount_topic = $('#part_'+this.id).val(1).val();
            var total_ques =$('#amout_ques'+this.id).val(amout_ques * amount_topic ).val();

            //xoa error sau reset
            const  valueToRemove = this.id;
            error_level = error_level.filter(item => !valueToRemove.includes(item));
            $('#sel_id'+this.id).prop('selectedIndex',0);
            $("#error"+this.id).empty();
            $('#error_amount'+this.id).empty();
        }

    });


    $(document).on('change','.mySelectBox',function(){
        $('#'+this.id+' option').each(function(){
            if($(this).is(':selected')){
                var amount_topic = $('#part_'+this.id).val();
                var part_id = $(this).attr('id');
                var level_name =$(this).data('level_name');
                var level_id=$(this).val();
                var part_name = $(this).data('part_name');
                var skill_name=$(this).data('skill_name');
                $('.amount-topic'+part_id).css("pointer-events", "auto");
                var route = "{{URL::to('/check-filter')}}";
                $.ajax({
                    type: 'POST',
                    url: route,
                    data:{
                        level_id:level_id,
                        part_id:part_id,
                        level_name:level_name
                    },
                    success:function(data) {
                        part_id=data['part_id']*1;
                        if(data['check']==0){
                            $('#error'+data['part_id']).html('*No data');
                            $('.amount-topic'+part_id).css("pointer-events", "none");
                            if(error_level.length > 0){
                                $.each(error_level , function(index, val) { 
                                    if(jQuery.inArray(part_id, error_level) === -1) {
                                        error_level.push(part_id);
                                    } 
                                });
                            }else{
                                    error_level.push(part_id);
                            }

                        }else if(data['check']>0 && data['check']==amount_topic){
                           
                            if(amount_topic <= data['amountMax']){
                                $('#part_level'+data['part_id']).attr('name',data['level_id']);
                                $('#part_level'+data['part_id']).html(data['level_name']);
                                $("#error"+data['part_id']).empty();
                                $('.amount-topic'+part_id).css("pointer-events", "auto");
                                const  valueToRemove = data['part_id'];
                                error_level = error_level.filter(item => !valueToRemove.includes(item));
                            }
                        }
                        if(data['check']>0 && data['check']<amount_topic){
                            $('#error_amount'+data['part_id']).html('*Amount max data'); 
                            $('#part_level'+data['part_id']).attr('name',data['level_id']);
                            $('#part_level'+data['part_id']).html(data['level_name']);
                            $("#error"+data['part_id']).empty();
                            $('.amount-topic'+part_id).css("pointer-events", "auto");
                            if(error_level.length > 0){
                               $.each(error_level , function(index, val) { 
                                    if(jQuery.inArray(part_id, error_level) === -1) {
                                        error_level.push(part_id);
                                    } 
                                });
                           }else{ 
                                error_level.push(part_id);
                            }
                        }else if(data['check']!=0 && data['check']>=amount_topic){
                            if(amount_topic <= data['amountMax']){
                                $('#part_level'+data['part_id']).attr('name',data['level_id']);
                                $('#part_level'+data['part_id']).html(data['level_name']);
                                $("#error"+data['part_id']).empty();
                                $('#error_amount'+data['part_id']).empty(); 
                                $('.amount-topic'+part_id).css("pointer-events", "auto");
                                const  valueToRemove = data['part_id'];
                                error_level = error_level.filter(item => !valueToRemove.includes(item));
                            }else{
                                $('#part_level'+data['part_id']).attr('name',data['level_id']);
                                $('#part_level'+data['part_id']).html(data['level_name']);
                                $("#error"+data['part_id']).empty();
                            }
                        }
                    }
                });
            }
        });
    });

        $( "#form_data" ).submit(function(event) {

        event.preventDefault();
         var ar_skill_paypal = [];

        var values =[];
        var index=0;
        
        
        $('#tblstruc tr').each((index, tr)=> {
            index++;
            if(index>1){   
             var tamp =[];

             // ==========================Xử lý thanh toán PAYPAL==========================
             
             skill_paypal = $(tr).children('td:first').html();

             if (skill_paypal == 'Writting' || skill_paypal == 'Speaking') {

                if (ar_skill_paypal.indexOf(skill_paypal) === -1) {
                    ar_skill_paypal.push(skill_paypal);
                }

             }

             // ==========================Xử lý thanh toán PAYPAL==========================

                $(tr).children('td').each ((index, td) => {
                   var part_id = $(td).data('part_id');
                   if($(td).attr('name') == 'choice'){
              
                        if(error_level.length > 0){                            
                            $.each(error_level , function(index, val) { 
                                if(jQuery.inArray(part_id, error_level) === -1) {
                                    error_level.push(part_id);
                                } 
                            });
                        }else{ 
                            error_level.push(part_id);
                        }
                    }else{
                        tamp.push($(td).attr('name'));
                    }
                });     
                values.push(tamp);
            } 
        });
        
         if(values.length>0)
         {
            var routesubmit = $('#form_data').data('route');
             if( error_level == ""){

                // ==========================thanh toán PAYPAL==========================
                var flag = 0;

                if(ar_skill_paypal.length > 0){

                        $('#paypal').empty()
                        //array -> JSON
                        items = new Array();

                        $.each(ar_skill_paypal, function(i,v){
                            var skill_obj = new Object();
                            skill_obj.name = v;
                            skill_obj.quantity = 1;
                            skill_obj.price = 0.50;
                            skill_obj.tax = 0.05;
                            skill_obj.currency = 'USD';
                            items.push(skill_obj);
                        });
                       

                        Swal.fire({
                                icon: 'question',
                                title: 'Need you mark '+ ar_skill_paypal.toString() +' by Teacher?',
                                showConfirmButton: true,
                                showDenyButton: true,
                                confirmButtonColor: 'orange',
                                denyButtonText: 'No',
                            }).then(function(result){
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title:'Please pay to continue !',
                                        html: '<img src="/file/help/paypal.png" alt="No Image" width="250px" height="50px">',
                                        showConfirmButton: true,
                                        confirmButtonColor: 'orange',
                             
                                    }).then(function(res){
                                        if (result.isConfirmed) {
                                            $('#paypal').show()
                                        }
                                    }) 
                                }else{

                                    Swal.fire({
                                        title: 'Do you want to start?',
                                        showDenyButton: true,
                                        confirmButtonText: 'Now!',
                                        confirmButtonColor: 'orange',
                                        denyButtonText: 'Not Now!',
                                    }).then(function(re){
                                        if (re.isConfirmed) {
                                            $.ajax({
                                            type: 'POST',
                                            url:routesubmit,
                                            data:{
                                                values:values
                                            },
                                            success:function(data) {

                                                   url = "{{ URL::to('/start-random-example') }}/"

                                                    $.get("{{ URL::to('/random-example') }}/"+data+"?fee=0", function(response){
                                                    if (typeof response.error === "undefined") {
                                                        window.location = url + data + `?result=${response.result_id}&lesson=${response.lesson_id}`;
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
                                                    
                                               }
                                           });
                                        }
                                    })
                                }
                            })

                           

                            paypal.Button.render({
                            // Configure environment
                            env: 'sandbox',
                            client: {
                              sandbox: 'AdfpRH1MVePU9wKrJTu0BlXt4NfWIZxsQ_0XE6HHaxoxcPflJrSA484DyTs1FSbMm8LT_e3yIjBKTRI8',
                              production: 'EMYu2TNOEYHn3Sm8j6FRce9K0zXB7cVtIB3JpGfaXv8DseIw0oOashc7YvEwJwlZC3nZuL-_EejXcB_T',
                          },
                            // Customize button (optional)
                            locale: 'en_US',
                            style: {
                              size: 'medium',
                              color: 'black',
                              shape: 'pill',
                          },

                            // Enable Pay Now checkout flow (optional)
                            commit: true,

                        // Set up a payment
                            payment: function(data, actions) {
                              return actions.payment.create({
                                transactions: [{
                                  amount: {
                                    total: (ar_skill_paypal.length * 0.50) + (ar_skill_paypal.length * 0.05),
                                    currency: 'USD',
                                    details: {
                                      subtotal: ar_skill_paypal.length * 0.50,
                                      tax: ar_skill_paypal.length * 0.05,
                                      
                                    }
                                  },
                                  
                                  payment_options: {
                                    allowed_payment_method: 'INSTANT_FUNDING_SOURCE'
                                  },
                                  
                                  item_list: {
                                    items: items,
                                   
                                  }
                                }],
                                application_context: {
                                  shipping_preference: 'NO_SHIPPING'
                                }
                
                              });
                            },


                            // Execute the payment
                            onAuthorize: function(data_paypal, actions) {
                              return actions.payment.execute().then(function() { 

                                $.ajax({
                                type: 'POST',
                                url:routesubmit,
                                data:{
                                    values:values
                                },
                                success:function(data) {

                                       url = "{{ URL::to('/start-random-example') }}/";

                                       $.get("{{ URL::to('/random-example') }}/"+data+"?fee=" + (ar_skill_paypal.length * 0.50), function(response){
                                        if (typeof response.error === "undefined") {
                                            window.location = url + data + `?result=${response.result_id}&lesson=${response.lesson_id}`;
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

                                   }
                               });

                            });
                          },

                          onCancel: function(data_paypal, actions){
                            $('#paypal').empty();
                          },
                        }, '#paypal');

                       }
                       //nếu là kỹ năng đọc, nghe
                       else{
                            $('#paypal').hide()
                            flag = 1;
                            
                        }
                         
                        // ==========================thanh toán PAYPAL==========================

                //KHÔNG DÙNG KỸ NĂNG NGHE, ĐỌC HOẶC KHÔNG CHẤM ĐIỂM

                if (flag == 1) {

                    Swal.fire({
                        title: 'Do you want to start?',
                        showDenyButton: true,
                        confirmButtonText: 'Now!',
                        confirmButtonColor: 'orange',
                        denyButtonText: 'Not Now!',
                    }).then(function(result){
                        if (result.isConfirmed) {
                            $.ajax({
                            type: 'POST',
                            url:routesubmit,
                            data:{
                                values:values
                            },
                            success:function(data) {

                                   url = "{{ URL::to('/start-random-example') }}/"

                                    $.get("{{ URL::to('/random-example') }}/"+data+"?fee=0", function(response){
                                        if (typeof response.error === "undefined") {
                                            window.location = url + data + `?result=${response.result_id}&lesson=${response.lesson_id}`;
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
                               }
                           });
                        }
                    })
                }
                
            }else {

                var routes = "{{URL::to('/check-err')}}";
                $.ajax({
                    method: 'POST',
                    url: routes,
                    data:{

                        error_level:error_level
                    },
                    success:function(data) {
                        var err_part = [];
                        $.each(data,function() {
                            err_part.push(this['part_name']);
                        })
            
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Please choice filter part '+err_part.join(", "),
                            backdrop: false,
                            confirmButtonColor: 'orange',
                        })
                         
                    }

                });   
            }
        }else if(values.length<=0){
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Please Choose Structure !!!!!!!!!!!!!!!',
                backdrop: false,
                confirmButtonColor: 'orange',
            })   
        }
    });
    
        $('select.form-control').combobox();
    });
</script>

@endsection

