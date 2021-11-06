

 @component('mail::message')
# Hello, 
  
	Name : {{ $data['name'] }}
	Message: {{ $data['comments'] }}

@endcomponent