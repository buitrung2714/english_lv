

 @component('mail::message')
# Hello {{ $data['student'] }}, 
  
	Congratulations! You passed the test with a good result.
	Your result: {{ $data['total'] }}
   
@component('mail::button', ['url' => route('show_result', ['result_id' => $data['result_id']]) ])
Result
@endcomponent
   
Thanks,<br>

@endcomponent