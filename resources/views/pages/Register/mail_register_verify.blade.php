

 @component('mail::message')
  
		Vertify email : {{ $data['email'] }}

	Please click VERIFY 
   
@component('mail::button', ['url' =>  $data['body'] ])
VERIFY  
@endcomponent
   
Thanks,<br>

@endcomponent