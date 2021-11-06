
@extends('/welcome')

@section('content')


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style>
.form-gap {
  padding-top: 70px;
}
.forgot-pass{
  text-align: center;

}
.form-forgot{
  border: 1px solid;

}


</style>
<div class="all-title-box">
  <div class="container text-center">
   <h1>Forgot Password<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
 </div>
</div>
<div class="form-gap"></div>

<div class="row forgot-pass">
  <div class="col-md-4"></div>
  <div class="col-md-4 col-md-offset-4 form-forgot">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="text-center">
          <h3><i class="fa fa-lock fa-4x"></i></h3>
          <h2 class="text-center">Forgot Password?</h2>
          <p>You can reset your password here.</p>
          @if(session()->get('update_pass_fail'))
          <div class="alert alert-danger" role="alert">
           {{session()->get('update_pass_fail')}}
           {{session()->put('update_pass_fail','')}}
         </div>
         @endif


          {{--  @if(session()->has('error_forgot'))
                <div class="alert alert-danger" role="alert">
                     {{session()->get('error_forgot')}}
                  </div>
              @elseif(session()->has('forgor_success'))
                  <div class="alert alert-success" role="alert">
                     {{session()->get('forgor_success')}}
                    </div>
                    @endif --}}
                    <div class="panel-body">

                      <form id="register-form" action="" role="form" autocomplete="off" class="form" method="post">
                        @csrf
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                            <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                          </div>
                        </div>
                        <div class="form-group">
                          <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                        </div>

                        {{--   <input type="hidden" class="hide" name="token" id="token" value="">  --}}
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endsection

          @section('javascript')

          <script>
            $(document).ready(function(){
              $('#register-form').submit(function(e){
                e.preventDefault();

                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  confirmButtonColor: '#00bcd4',
                  timer: 7000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

                Toast.fire({
                  icon: 'success',
                  title: 'Email is sending!'
                })

                $.post("{{url('/recover-pass')}}", $('#register-form').serialize(), function(response){
                  if (response.status == 0) {
                    Swal.fire({
                      icon: 'error',
                      backdrop: false,
                      title: response.mess,
                      showConfirmButton: true,
                      confirmButtonColor: 'orange',
                    });
                  }else{
                    Swal.fire({
                      icon: 'success',
                      backdrop: false,
                      title: response.mess,
                      showConfirmButton: true,
                      confirmButtonColor: 'orange',
                    });
                    $('#register-form')[0].reset();
                  }
                });
              })

            })
          </script>

          @endsection