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

.changepass>td>a{

	color: #428bca ;
	text-decoration: none;

}
.inputpass{
	display: none;
}
.name1{
	width: 35%;
}
.none{
	width: 30%;
}


</style>

<div class="container">
	<div class="breadcrumbs">
		
		<div style="font-size: 30px; color: orange; margin-top: 20px" >
			<b><center>MY PROFILE</center></b>
		</div>
		<br/>
	</div>
	@foreach($cus as $key => $cus)
	<form action="{{URL::to('/update-student/'.$cus->student_id)}}" method="post" >
		@csrf

		<div >
			<table class="table">
				<tr>
					<td class="name1">Email</td>
					<td>:</td>
					<td>{{$cus->student_email}}</td>
					<td class="none"></td>
				</tr>
				<tr class="changepass">
					<td class="name1">Password</td>
					<td>:</td>
					<td width="150" ><a href="#" id="changepw">Change</a></td>
					<td class="inputpass">
						<table>
							<tr>
								<td><input id="old_pass"  type="password" placeholder="Old Password" ></td>
								<td><label id="old_pass_err" style="color:red; display: none; " >*Password  incorrect </label></td>
							</tr>
							<tr>
								<td><input id="new_pass" class="inputpass" type="password" name="pass"  placeholder="New Password "></td>
								<td><label id="pass_err" style="color:red; display: none; " >*Password is empty. </label></td>
							</tr>
							<tr>
								<td><input id="confirm_pass" class="inputpass" type="password" name="pass"  placeholder="Confirm Password "></td>
								<td><label id="confirm_err" style="color:red; display: none; " >*Password is empty. </label></td>
							</tr>
							<tr>
								<td><label id="corfirm_fail" style="color:red; display: none; " >*Password do not match. </label></td>
								
							</tr>
						</table>
							
					</td>
					
					
				</tr>
			
				<tr>
					<td class="name1">Name</td>
					<td>:</td>
					<td><input type="text" name="name" value="{{$cus->student_name}}" id="user_name"></td>
					<td><input type="text" hidden="hidden" value="{{$cus->student_id}}" id="user_id"></td>
					
					<td><label id="name_err" style="color:red; display: none; " >*Name cannot exceed 50 characters </label></td>
					
				</tr>
				

			</table>
		</div>
			{{-- <div class="col-md-3"></div>
			<div class="col-md-5"></div> --}}
			<div class=" col-md-2 justify-content-center " style="margin-bottom: 20px">
				<input id="update_user" type="submit" value="Update" name="update"  class="btn btn-warning">
			</div>
			<div class="col-md-5"></div>
		</form>
		@endforeach
	</div>



	@endsection


	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	@section('javascript')

	@if(session()->has('success'))

	<script>
		Swal.fire({
			title: "{{ session()->get('success') }}",
			icon: 'success',
			timer: 1500,
			showConfirmButton: false,
		})
	</script>
	{{ session()->remove('success') }}
	@endif

	<script type="text/javascript">

		$('#update_user').click(function(e){

			e.preventDefault();
			if($('.inputpass').is(":visible")){
				var pass_new_tamp = $('#new_pass').val();
				var confirm_pass = $('#confirm_pass').val();
				var old_pass = $('#old_pass').val();
				var user_id =$('#user_id').val();
				$.ajax({
					type: 'get',
	                url:'{{asset('/check-old-pass')}}',
	                data:{
	                    old_pass:old_pass,
	                    user_id:user_id
	                },
	                success:function function_name(data) {
	                	if(data==1){
	                		$('td #old_pass_err').hide();
	                		if(pass_new_tamp.trim() == "" ){
								$('td #pass_err').show();
								
							}
							if(confirm_pass.trim() == ""){
								$('td #confirm_err').show();
								
							}

							if(pass_new_tamp != confirm_pass ){
								$('td #pass_err').hide();
								$('td #confirm_err').hide();
								$('td #corfirm_fail').show();
								
							}
							else if(pass_new_tamp == confirm_pass && pass_new_tamp != ''){
								$('td #old_pass_err').hide();
								Swal.fire({
								title: 'Do you want to change?',
								icon: 'question',
								showConfirmButton: true,
								showCancelButton: true,
								confirmButtonColor: 'orange'
								}).then(function(result){
									if (result.isConfirmed) {
										$('[method="post"]').submit();
									}
								});
							}
	                	}else{
	                		$('td #old_pass_err').show();
	                	}
	                }
				});
				
			}else {
				
				Swal.fire({
				title: 'Do you want to change?',
				icon: 'question',
				showConfirmButton: true,
				showCancelButton: true,
				confirmButtonColor: 'orange'
				}).then(function(result){
					if (result.isConfirmed) {
						$('[method="post"]').submit();
					}
				});
			}
			
		
		});

		$(document).on('click','#changepw', function(event) {
			event.preventDefault();
			$('.inputpass').toggle(500);
			$('td #corfirm_fail').hide();
			$('td #old_pass_err').hide();
		})

		$(document).on('input','#user_name',function(){
	        var student_email = $(this).val();
	        if(student_email.length > 50){
	        	
	            $('td #name_err').show();
	            $('#update_user').hover(function() {
	                $(this).css('cursor','not-allowed');
	                $(this).attr('disabled','disabled');
	            });
	        }else{
	            $('td #name_err').hide();
	            $('#update_user').prop("disabled", false);
	            $('#update_user').hover(function() {
	                $(this).css('cursor','auto');
	                $(this).prop("disabled", false);
	            });
	            
	        }
	        
	    });
	</script>
	@endsection