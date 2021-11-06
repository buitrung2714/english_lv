@extends('admin.layout.layout')
@section('admin_content')

<style>
.topic_question td:nth-child(odd){
	background: #786fbf;
}
.topic_question td:nth-child(even){
	background: #f05960;
}
</style>

<div class="agile-grids">
	<div class="social grid row">
		<div class="grid-info">
			<div class="col-md-3 top-comment-grid">
				<div class="comments likes">
					<div class="comments-icon">
						<i class="fa fa-user" style="font-size:4em;"></i>
					</div>
					<div class="comments-info likes-info">
						<h3>{{ $report['student'] }}</h3>
						<a>Students</a>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-3 top-comment-grid">
				<div class="comments">
					<div class="comments-icon">
						<i class="fa fa-book" style="font-size:4em;"></i>
					</div>
					<div class="comments-info">
						<h3>{{ $report['results'] }}</h3>
						<a>Total Result</a>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-3 top-comment-grid">
				<div class="comments tweets">
					<div class="comments-icon">
						<i class="fa fa-align-center" style="font-size:4em;"></i>
					</div>
					<div class="comments-info tweets-info">
						<h3>{{ $report['structure'] }}</h3>
						<a>Structures</a>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>

			<div class="col-md-3 top-comment-grid">
				<div class="comments views">
					<div class="comments-icon">
						<i class="fa fa-money" style="font-size:4em;"></i>
					</div>
					<div class="comments-info views-info">
						<h3>${{ $report['money'] }}</h3>
						<a>Revenue</a>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>

			<div class="clearfix"> </div>
		</div>
	</div>


	<div class="col-md-4 charts-right">
		<!-- area-chart -->
		<div class="area-grids">
			<div class="area-grids-heading">
				<h3>Result of Test</h3>
			</div>
			<div id="graph4"></div>
			<script>
				
			</script>

		</div>
		<!-- //area-chart -->
	</div>
	<div class="col-md-8 chart-left">
		<!-- updating-data -->
		<div class="agile-Updating-grids">
			<div class="area-grids-heading">
				<h3>Top 5 Structure </h3>
			</div>
			<div id="graph1"></div>
		</div>
		<!-- //updating-data -->
	</div>
	<div class="clearfix"> </div>

	<br>

	<div class="row">
		
		<div style="height: 130px;
		width: 200px;
		background-color: #fff; margin-left:15px" class="area-grids col-md-3 text-left">

		<div class="row">
			<div class="col-md-4 text-center" style="width:30px;height: 20px; background-color: green;margin-left: 15px;"></div>
			<div class="col-md-6 text-center" >Skill</div>
		</div>

		<div class="row">
			<div class="col-md-4 text-center" style="width:30px;height: 20px; background-color: #998b45;margin-left: 15px;"></div>
			<div class="col-md-6 text-center" >Part</div>
		</div>

		<div class="row">
			<div class="col-md-4 text-center" style="width:30px;height: 20px; background-color: #786fbf;margin-left: 15px;"></div>
			<div class="col-md-6 text-center" >Topic</div>
		</div>

		<div class="row">
			<div class="col-md-4 text-center" style="width:30px;height: 20px; background-color: #f05960;margin-left: 15px;"></div>
			<div class="col-md-6 text-center" >Question</div>
		</div>

	</div>

	<br>

	@if(isset($data_part))
	<div class="col-md-9 text-right" style="bottom:23px">
		<table class="table table-bordered text-center" style="color: #fff;">
			<tr style="background-color: #00bcd4;">

				@php 
				$total = 0; 
				foreach($data_skill as $count_data){
					$total += ($count_data['count_part'] * 4);
				}

				@endphp

				<th colspan="{{ $total }}">DATA</th>

			</tr>
			<tr style="background-color: green;">
				@foreach($data_skill as $skill)

				<td colspan="{{ $skill['count_part'] * 2 }}">{{ $skill['skill_name'] }}</td>

				@endforeach
			</tr>
			<tr style="background-color: #998b45">
				@foreach($data_part as $part)

				<td colspan="2">{{ $part['part_name'] }}</td>

				@endforeach
			</tr>
			<tr class="topic_question">
				@foreach($data_part as $detail)

				<td>{{ $detail['topics'] }}</td>
				<td>{{ $detail['questions'] }}</td>

				@endforeach
			</tr>
		</table>
	</div>

	@endif
</div>


</div>

@endsection

@section('javascript')

<script>
	$(document).ready(function(){

		// ============================BAR============================
		@if(isset($like_struc))
		var data_tmp = @php echo json_encode($like_struc)  @endphp;
		var all_total = [];
		$.each(data_tmp, function(i,v){
			all_total.push(v.total);
		});

		var largest = Math.max.apply(Math, all_total);
		largest += 3;
		
		@endif

		//area
		Morris.Bar({
		  // ID of the element in which to draw the chart.
		  element: 'graph1',
		  // Chart data records -- each entry in this array corresponds to a point on
		  // the chart.
		  
		  @if(isset($like_struc))
		  data: @php echo json_encode($like_struc)  @endphp,
		  ymin: "auto 0",
		  ymax: largest,
		  numLines: largest >= 5 ? 6 : 2,

		  @else
		  
		  ymin: "auto 0",
		  ymax: 0,
		  numLines: 1,
		  data: [{filter_name: 0,total:0}],
		  @endif
		  xLabelAngle: 40,
		  fillOpacity: 0.6,
		  hideHover: 'auto',
		  parseTime: false,
		  // The name of the data record attribute that contains x-values.
		  xkey: 'filter_name',
		  // A list of names of data record attributes that contain y-values.
		  ykeys: ['total'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Turns'],
		 
		  yLabelFormat: function(y){ return y != Math.round(y)?'':y; }
		});

		// ============================DONUT============================
		Morris.Donut({
			element: 'graph4',
			
			@if(isset($kq))
			data: @php echo json_encode($kq)  @endphp,

			@else

			data: [
			{value: 100, label: 'No Data', formatted: '0%' },
			],
			@endif
			formatter: function (x, data) { return data.formatted; }
		});
	});
</script>

@endsection