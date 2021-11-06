
@extends('/welcome')

@section('content')
<style type="text/css">
	.pass_show{position: relative} 

.pass_show .ptxt { 

position: absolute; 

top: 50%; 

right: 10px; 

z-index: 1; 

color: #f36c01; 

margin-top: -10px; 

cursor: pointer; 

transition: .3s ease all; 

} 

.pass_show .ptxt:hover{color: #333333;} 
.form-gap {
    padding-top: 70px;
}

</style>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="all-title-box">
	  	<div class="container text-center">
	   	<h1>Forgot Password<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
	</div>
</div>

<div class="form-gap"></div>
<div class="container ">
	
	<form id="form_new_pass" action="{{ URL::to('/new-pass') }}" method="post">
		@csrf
		<?php
			
			$email = $_GET['email'];
			$token = $_GET['token'];
		?>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-sm-4 ">

	            <input type="email" name="email" value="{{$email}}" hidden="hidden">
	            <input type="text" name="token" value="{{$token}}" hidden="hidden">
			    <label id="pass_empty">New Password</label>

	            <div class="form-group pass_show"> 
	                <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="New Password"> 
	                <label id="pass_err" style="color:red; display:none" >*Please enter new password</label>
	            </div> 
			    <label>Confirm Password</label>
	            <div class="form-group pass_show"> 
	                <input type="password" id="confirm_pass" class="form-control" name="confirm_pass" placeholder="Confirm Password"> 
	               
	            </div> 
	            <label id="confirm_err" style="color:red; display:none" >*Please confirm password </label>
	            <label id="corfirm_fail" style="color:red; display:none" >*Password do not match. </label>
	            
		
			<div>
	        	<input name="recover-submit" id="recover_submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="">
	      	</div>
		</div>
	</form>
	
</div>

@endsection




@section('javascript')
<script type="text/javascript">
	$(document).ready(function(){
		$('.pass_show').append('<span class="ptxt">Show</span>');  
		$('#recover_submit').click(function(e) {
		
			var pass_new_tamp = $('#new_pass').val();
			var confirm_pass = $('#confirm_pass').val();
			console.log(pass_new_tamp,confirm_pass);
			if(pass_new_tamp.trim() == ""){
				 $('#pass_err').show();
			} 
			if(confirm_pass.trim() == ""){
				 $('#confirm_err').show();
			}

			if(pass_new_tamp != confirm_pass ){
				$('#confirm_err').hide();
				$('#corfirm_fail').show();
			}
			else if(pass_new_tamp == confirm_pass && pass_new_tamp.trim() != ""){
				$('#form_new_pass').submit();
			}
		})
	});
		  

	$(document).on('click','.pass_show .ptxt', function(){ 
		$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
		$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

	});  




</script>


@endsection