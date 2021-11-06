<!DOCTYPE html>
<html lang="en">

<!-- Basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">   

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Site Metas -->
<title>English Club</title>  
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">

<!-- Site Icons -->
<link rel="shortcut icon" href="{{asset('/frontend/images/favicon.ico')}}" type="image/x-icon" />
<link rel="apple-touch-icon" href="{{asset('/frontend/images/apple-touch-icon.png')}}">
{{-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'> --}}
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('/frontend/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('/frontend/css/timeline.min.css')}}">
<link rel="stylesheet" href="{{asset('/frontend/css/font-awesome.css')}}">
<link rel="stylesheet" href="{{asset('/frontend/css/flaticon.css')}}">
<!-- Site CSS -->
<link rel="stylesheet" href="{{asset('/frontend/css/style.css')}}">
<!-- ALL VERSION CSS -->
<link rel="stylesheet" href="{{asset('/frontend/css/versions.css')}}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{asset('/frontend/css/responsive.css')}}">
{{-- sadsd --}}
<link rel="stylesheet" href="{{asset('/frontend/css/bootstrap.min.css')}}">
{{-- dataTable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>

<link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}">
{{-- sweetalert.css --}}
<link rel="stylesheet" href="{{asset('frontend/css/sweetalert.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/bootstrap-side-modals.css')}}">
<!-- Modernizer for Portfolio -->
<script src="{{asset('/frontend/js/modernizer.js')}}"></script>
{{-- bootstrap.bundle.min.js --}}
<script src="{{asset('/frontend/js/bootstrap.bundle.min.js')}}"></script>
<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/smart_wizard.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.smartWizard.min.js"></script>
{{-- jquery.min.js --}}
<script src="{{asset('/frontend/js/jquery.min.js')}}"></script>
{{-- bootstrap.min.css --}}

<script src="{{asset('/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
{{-- alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <link rel="stylesheet" href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'> --}}


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
      <style>
      .img-bg-01{
        background: url("{{asset('/frontend/images/img-01.jpg')}}") no-repeat center;
        background-size: cover;
    }
    .img-bg-02{
        background: url("{{asset('/frontend/images/img-02.jpg')}}") no-repeat center;
        background-size: cover;
    }
    .img-bg-03{
        background: url("{{asset('/frontend/images/img-03.jpg')}}") no-repeat center;
        background-size: cover;
    }
    .img-bg-04{
        background: url("{{asset('/frontend/images/img-04.jpg')}}") no-repeat center;
        background-size: cover;

    }
    .all-title-box{
        background: url("{{asset('/frontend/images/banner.jpg')}}")no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-position: center;
        min-height: 300px;
    }

    a.google-plus {
        background: #db4c3e;
        border: 1px solid #db4c3e
    }
    a.google-plus:hover {
        background: #bd4033;
        border-color: #bd4033
    }
    .login{
        text-align: center;
    }
</style>
</head>
<body class="host_version"> 

    <!-- Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header tit-up">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body customer-box">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li><a class="active" href="#Login" data-toggle="tab">Login</a></li>
                    <li><a href="#Registration" data-toggle="tab">Registration</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="Login">
                     <form role="form" class="form-horizontal" action="{{asset('/login-user')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" id="email1" name="email" placeholder="email" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" type="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                    Submit
                                </button>
                                <a class="for-pwd" href="{{asset('/forgot-pass')}}">Forgot your password?</a>
                            </div>
                        </div>
                    </form>
                    <div class="row login">
                        {{-- <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6"> <a href="#" class="btn btn-primary facebook"> <span>Login with Facebook</span> <i class="fa fa-facebook"></i> </a> </div> --}}
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6"> <a href="{{asset('/redirect')}}" class="btn btn-primary google-plus"> Login with Google <i class="fa fa-google-plus"></i> </a> </div>
                    </div>
                </div>
                <div class="tab-pane" id="Registration">
                    <form role="form" class="form-horizontal" action="{{asset('/add-user')}}" method="post">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="user_name" class="form-control" required="" name="name"  placeholder="Name" type="text">
                                <label id="name_err" style="color:red; display:none" >*Name cannot exceed 50 characters </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12"> 
                                <input class="form-control" id="email"  name="email"  placeholder="Email" type="email">
                                <label id="email_exits" style="color:red; display:none" >*Email exits</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" id="password" required="" name="password"  placeholder="Password" type="password">
                                <label id="pass_err" style="color:red; display:none" >*Password cannot exceed 50 characters</label>
                            </div>
                        </div>
                        <div class="row">                           
                            <div class="col-sm-10">
                                <button type="submit" id="adduser"  class="btn btn-light btn-radius btn-brd grd1" name="registration" value="registration">
                                    Save &amp; Continue
                                </button>
                                <button type="button" class="btn btn-light btn-radius btn-brd grd1">
                                Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- LOADER -->
<div id="preloader">
    <div class="loader-container">
        <div class="progress-br float shadow">
            <div class="progress__item"></div>
        </div>
    </div>
</div>
<!-- END LOADER --> 

<!-- Start header -->
<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="logo" href="{{asset('/home')}}">
                <h2 style="color:#eea412"><strong>English Club </strong> </h2>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbars-host">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{asset('/')}}">Home</a></li>

                    @if(session()->get('student_id'))
                    <li class="nav-item"><a class="nav-link" href="{{asset('/study-route')}}">Learning</a></li>
                    <li class="nav-item dropdown"><a class="nav-link" href="{{asset('/exercise-test')}}">Exercise</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-a">
                            <a class="dropdown-item" href="{{asset('/lesson-sample')}}">Lesson Sample</a>

                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{asset('/example-test')}}">Exams Test</a></li>
                    @endif

                    @if(session()->has('id_gv'))
                    <li class="nav-item"><a class="nav-link" href="{{asset('/list-test')}}">List Test</a></li>
                    @endif

                    {{-- <li class="nav-item"><a class="nav-link" href="{{asset('/news')}}">News</a></li> --}}

                    <?php
                    $cus_id = Session::get('student_id');
                ?>
                <?php
                if(isset($cus_id)){
                ?>
                
                <li class="nav-item"><a class="nav-link" href="{{asset('/profile/'.$cus_id)}}">Profile</a></li>
                <?php
            }
        ?>
        <li class="nav-item"><a href="{{ URL::to('/contact') }}" class="nav-link">Contact</a></li>

    </ul>
    <ul class="nav navbar-nav navbar-right">
        <?php
        $cus_id = Session::get('student_id');
    ?>
    <?php
    if(isset($cus_id) || session()->has('id_gv')){
    ?>
    <li>
        <a class="hover-btn-new log orange" onclick="logout()"><span>Logout</span></a>
    </li>
    <?php
}else{
?>
<li>
  <a class="hover-btn-new log orange" href="#" data-toggle="modal" data-target="#login"><span>Login</span></a>
</li>
<?php
}
?>
</a></li>
</ul>
</div>
</div>
</nav>
</header>
<!-- End header -->

@yield('content')

<div class="modal modal-bottom fade" id="bottom_modal" tabindex="-1" role="dialog" aria-labelledby="bottom_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <h5 class="modal-title" >Study Route</h5>
                <button type="button" class="close close-route" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2 block"><img src="/frontend/images/apple-touch-icon.png" alt=""></div>
                    <div class="col-md-4  ">
                       
                        <span  ><h5 >Welcome  @if(session()->get('student_name'))  {{session()->get('student_name')}} @endif </h5></span>
                        <span  >Do you want start English learning journey ?</span>
                       
                        
                    </div>

                    <div class="col-md-3 block"><button type="button" id="no_route" class="no btn btn-secondary close-route" >No, Thank you</button></div>
                    <div class="col-md-3 block"><button type="button" id="route" class="no btn btn-primary" >My Study Route</button></div>
                </div>

            </div>
            <div class="modal-footer modal-footer-fixed d-none">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

</div><!-- end section -->

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>About US</h3>
                    </div>
                    <p> Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis dis montes.</p>   
                    {{-- <div class="footer-right">
                        <ul class="footer-links-soi">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-github"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul><!-- end links -->
                    </div>  --}}                     
                </div><!-- end clearfix -->
            </div><!-- end col -->

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Information Link</h3>
                    </div>
                    <ul class="footer-links">
                        <li><a href="{{asset('/home')}}">Home</a></li>
                        <li><a href="{{ URL::to('/contact') }}">Contact</a></li>
                    </ul><!-- end links -->
                </div><!-- end clearfix -->
            </div><!-- end col -->

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Contact Details</h3>
                    </div>

                    <ul class="footer-links">
                        <li><a href="mailto:#">testemailwebclothing@gmail.com</a></li>
                        
                        <li>+61 3 8376 6284</li>
                    </ul><!-- end links -->
                </div><!-- end clearfix -->
            </div><!-- end col -->

        </div><!-- end row -->
    </div><!-- end container -->
</footer><!-- end footer -->

{{-- <div class="copyrights">
    <div class="container">
        <div class="footer-distributed">
            <div class="footer-center">                   
                <p class="footer-company-name">All Rights Reserved. &copy; 2021 <a href="#">English Club</a> Design By : <a href="https://html.design/">html design</a></p>
            </div>
        </div>
    </div><!-- end container -->
</div><!-- end copyrights --> --}}

<a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- ALL JS FILES -->
<script src="{{asset('/frontend/js/all.js')}}"></script>
<!-- ALL PLUGINS -->
<script src="{{asset('/frontend/js/custom.js')}}"></script>
<script src="{{asset('/frontend/js/timeline.min.js')}}"></script>

<script src="{{asset('/frontend/js/sweetalert.min.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

{{-- tinymce --}}
<script src="https://cdn.tiny.cloud/1/988pi62n14j4hn23yklqejb4lc4dymdxaedxt127biudf5w4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

@yield('javascript')

@if(session()->has('login_success'))

@if(session()->has('student_id') && !session()->has('id_gv'))
@php $name = session()->get('student_name') @endphp
<script type="text/javascript">
     $(document).ready(function () {
        $(window).on('load', function() {
            $('#bottom_modal').modal('show');
        });
        $('#route').click(function () {
            window.location.href = '{{asset('/input-route')}}';
        })
    });
</script>
@elseif(!session()->has('student_id') && session()->has('id_gv'))
@php $name = session()->get('name_gv') @endphp
@endif
<script>
    $(document).ready(function(){
        Swal.fire({
            position: 'top-start',
            toast: true,
            icon: 'success',
            title: "Welcome {{ $name }}",
            showConfirmButton: false,
            timer: 3000,
        });
    })  
</script>

{{ session()->remove('login_success') }}
@endif

@if(session()->has('fail'))
<script>
    $(document).ready(function(){
        Swal.fire({
            toast: true,
            position: 'top-start',
            icon: 'error',
            title: "{{ session()->get('fail') }}",
            showConfirmButton:false,
            timer:3000,
        });
    })  
</script>

{{ session()->remove('fail') }}
@endif

@if(session()->has('add_success'))
<script>
    $(document).ready(function(){
        Swal.fire({
            icon: 'success',
            title: "{{ session()->get('add_success') }}",
            showConfirmButton: false,
            timer: 1500,
        });
    })  
</script>

{{ session()->remove('add_success') }}
@endif


@if(session()->has('add_fail'))
<script>
    $(document).ready(function(){
        Swal.fire({
            toast: true,
            position: 'top-start',
            icon: 'error',
            title: "{{ session()->get('add_fail') }}",
            showConfirmButton:false,
            timer:3000,
        });
    })  
</script>

{{ session()->remove('add_fail') }}
@endif


@if(session()->has('email_send'))
<script>
    $(document).ready(function(){
        Swal.fire({
            toast: true,
            position: 'top-start',
            icon: 'success',
            title: "{{ session()->get('email_send') }}",
            showConfirmButton:false,
            timer:3000,
        });
    })  
</script>

{{ session()->remove('email_send') }}
@endif

<script>
    function logout(){
        Swal.fire({
            icon: 'question',
            title: 'Do you want to sign out?',
            showConfirmButton: true,
            showCancelButton: true,
            backdrop: false,
            confirmButtonColor: 'orange',
        }).then(function(result){
            if (result.isConfirmed) {
                window.location = "{{URL::to('/logout-user')}}";
            }
        });
    }

    $(document).on('click','.close-route',function () {
            $('#bottom_modal').modal('hide');
    })

    $('.nav-link').each(function(i,v){
        var link = $(this).attr('href');

        if (link == window.location.href) {
            $(this).parent().addClass('active')
        }
    })

    $(document).on('input','#email',function(){
        var student_email = $(this).val();

        $.ajax({
            type:'post',
            url: '{{asset('/check-email')}}',
            data:{
                student_email:student_email,
                _token:$('[name=_token]').val(),
            },
            success:function(data) {
                if(data['email_exits'] == 1){
                    $('#email_exits').show();
                }else if(data['email_exits'] == 0){
                    $('#email_exits').hide();
                }
                   // console.log(data['email_exits']);
               }
           });
    });

    $(document).on('input','#user_name',function(){
        var student_email = $(this).val();
        if(student_email.length > 50){
            $('#name_err').show();

            $('#adduser').hover(function() {
                $(this).css('cursor','not-allowed');
                $(this).attr('disabled','disabled');
            });
        }else{
            $('#name_err').hide();
            $('#adduser').prop("disabled", false);
            $('#adduser').hover(function() {
                $(this).css('cursor','auto');
                $(this).prop("disabled", false);
            });
            
        }
        
    });
    $(document).on('input','#password',function(){
        var pass = $(this).val();
        if(pass.length > 50){
            $('#pass_err').show();
        }else{
            $('#pass_err').hide();
        }
    });

</script>

</body>
</html>