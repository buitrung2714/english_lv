<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

	@foreach($data as $key_skill => $detail)
	<div>
		@if(count($data[$key_skill]) > 0)
			<h2 style="text-align:center;">{{ $key_skill }}</h2>
		@endif

		@php 
			$i = 1; 
		@endphp
		
		@foreach($data[$key_skill] as $key_part => $part)
			<h3>{{ $part['part_name'] }}:</h3>
			@if($part['part_des'] != null)
				<span><b>{!! $part['part_des'] !!}</b></span>
			@endif
			@foreach($data[$key_skill][$key_part]['topic'] as $key_topic => $topic)

				@if($key_skill != 'Listening')
					<p>{!! $topic['topic_content'] !!}</p>
				@endif

				@foreach($data[$key_skill][$key_part]['topic'][$key_topic]['questions'] as $key_ques => $question)
					<p><b>{{ $i++.'. '.$question['question_content'] }}</b></p>

					@if($key_skill == 'Listening' || $key_skill == 'Reading')
						@php 
						$ans = array('A','B','C','D'); 
						@endphp
						@foreach($data[$key_skill][$key_part]['topic'][$key_topic]['questions'][$key_ques]['answers'] as $key_ans => $answer)
							<p style="margin-left:10px">{{ $ans[$key_ans].'. '.$answer->answer_content }}</p>
						@endforeach
					@endif

				@endforeach
			@endforeach
		@endforeach
	</div>
	@endforeach

</body>
</html>