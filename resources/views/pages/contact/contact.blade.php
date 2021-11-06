@extends('welcome')
@section('content')

<div class="all-title-box">
  <div class="container text-center">
     <h1>Contact<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
 </div>
</div>

<div id="contact" class="section wb">
    <div class="container">
        <div class="section-title text-center">
            <h3>Need Help? Sure we are Online!</h3>
            <p class="lead">Let us give you more details about the special offer website you want us. Please fill out the form below. <br>We have million of website owners who happy to work with us!</p>
        </div><!-- end title -->

        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="contact_form">
                    <div id="message"></div>
                    <form id="contactform">
                        {{ csrf_field() }}
                        <div class="row row-fluid">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                @if((session()->get('student_id')) && !(session()->get('id_gv')))
                                <input type="text" name="name" id="name" value="{{ session()->get('student_name') }}" class="form-control" placeholder="Name">
                                @elseif(!(session()->get('student_id')) && (session()->get('id_gv')))
                                <input type="text" name="name" id="name"  class="form-control" value="{{ session()->get('name_gv') }}" placeholder="Name">
                                @else
                                <input type="text" name="name" id="name"  class="form-control" placeholder="Name">
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                @if((session()->get('student_id')) && !(session()->get('id_gv')))
                                <input type="email" name="email" id="email" value="{{ session()->get('student_email') }}" class="form-control" placeholder="Your Email">
                                @elseif(!(session()->get('student_id')) && (session()->get('id_gv')))
                                <input type="email" name="email" id="email" value="{{ session()->get('email_gv') }}" class="form-control" placeholder="Your Email">
                                @else
                                <input type="email" name="email" id="email" class="form-control" placeholder="Your Email">
                                @endif
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <textarea class="form-control" name="comments" id="comments" rows="6" placeholder="Give us more details.."></textarea>
                            </div>
                            <div class="text-center col-lg-12 col-md-12 col-sm-12">
                                <button type="submit" value="SEND" id="submit" class="btn btn-light btn-radius btn-brd grd1 btn-block">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- end col -->
				{{-- <div class="col-xl-6 col-md-12 col-sm-12">
					<div class="map-box">
						<div id="custom-places" class="small-map"></div>
					</div>
				</div> --}}
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    @endsection

    @section('javascript')

    <script>

        $('[type="submit"]').click(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to send?',
                icon: 'question',
                backdrop: false,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: 'orange',
            }).then(function(result){
                if (result.isConfirmed) {

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
                      title: 'Processing...'
                  })

                    $.post("{{ URL::to('/contact-control') }}", $('#contactform').serialize(),function(response){
                        if(response.status == 1){
                            Swal.fire({
                                title: response.success,
                                icon: 'success',
                                backdrop: false,
                                confirmButtonColor: 'orange'
                            }).then(function(){
                                $('#contactform')[0].reset();
                            });
                        }else{
                            var a = new Array();
                            $.each(response.fail,function(i,v){
                                a.push(v+'\n');
                            });
                            str = a.toString();

                            Swal.fire({
                                title: 'Oops...Something wrong!',
                                html: str.replaceAll(',','<br>'),
                                icon: 'error',
                                backdrop: false,
                                confirmButtonColor: 'orange'
                            });
                        }
                    });
                }
            }) 
        });

        
    </script>

    @endsection

    

