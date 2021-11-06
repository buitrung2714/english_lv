
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
	   	<h1>Verify Account<span class="m_1"></span></h1>
	</div>
</div>

<div class="form-gap"></div>
<div class="container ">
	
	<form id="form_new_pass" action="{{ URL::to('/add-user-verify') }}" method="post">
		
		@csrf
		<?php
			
			$email = $_GET['email'];
			$token = $_GET['token'];
		?>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-sm-4 ">
	
	            <input type="text" name="token" value="{{$token}}" hidden="hidden">
	            <label id="">Email</label>
	            <div class="form-group "> 

	                <input readonly="readonly" type="email" id="email" name="email" value="{{$email}}" placeholder="{{$email}}" class="form-control" > 
	            </div> 
	            <label id="">Password</label>
	            <div class="form-group pass_show"> 
	                <input type="password" id="password" name="password" value="" class="form-control" placeholder="Enter Password"> 
	            </div> 
	
			<div>
	        	<input type="submit" name="register-submit"   class="btn btn-lg btn-primary btn-block" value="Login Now" >
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
			$('#pass_empty').empty();
			e.preventDefault();
			var pass_new_tamp = $('#new_pass').val();
			//console.log(pass_new_tamp,'abc');
			if(pass_new_tamp != 0){
				//console.log('aaaaaaaaaaa');
				 $('#form_new_pass').submit();
			}
			else{
				var error_pass = `<div id="pass_empty" class="alert alert-danger" role="alert">  <h5> Please enter a password  </h5></div>`
				$('#pass_empty').append(error_pass);
				//console.log('123');
			}
		})
		});
		  

		$(document).on('click','.pass_show .ptxt', function(){ 

		$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

		$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

		

		});  
</script>


@endsection