

 @component('mail::message')
  
	You were required recovery Password for email: {{ $data['email'] }}

	Please click RECOVERY 
   
@component('mail::button', ['url' =>  $data['body'] ])
RECOVERY
@endcomponent
   
Thanks,<br>

@endcomponent