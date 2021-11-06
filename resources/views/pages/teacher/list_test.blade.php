@extends('welcome')
@section('content')

<div class="container">
	<nav aria-label="breadcrumb" class="mt-3">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">List Test</li>
		</ol>
	</nav>


	<div style="font-size: 30px; color: orange; margin-top: 20px" >
		<b><center>LIST TEST</center></b>
		<center>
			<button class="btn btn-success newBtn">New({{ count($data) }})</button>
			<button class="btn btn-info remarkBtn">Re-Mark({{ count($remark) }})</button>
		</center>
	</div>
	<br/>

	{{-- cập nhật thành công --}}
	@if(session()->has('success'))
	<div class="alert alert-success">
		<p>{{ session()->get('success') }}</p>
	</div>
	@endif

	{{-- cập nhật thành công --}}
	@if(session()->has('error'))
	<div class="alert alert-danger">
		<p>{{ session()->get('error') }}</p>
	</div>
	@endif
</div>
<div class="container">
	<div class="table_new">
	<table class="table table-bordered table-responsive" style="display:table;">
		<thead style="background-color: #28a745; color: white;">
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Type</th>
				<th>Time</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $k => $detail)
			<tr>
				<td>{{ ++$k }}</td>
				<td>{{ $detail['student'] }}</td>
				<td>{{ $detail['type'] }}</td>
				<td>{{ $detail['time'] }}</td>
				<td>
					<a href="{{ URL::to('/show-test/'.$detail['result_id']) }}" class="btn btn-warning">Mark</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>

	<div class="table_remark">
	<table class="table table-bordered table-responsive" style="display:table">
		<thead style="background-color: #17a2b8; color: white;">
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Type</th>
				<th>Time</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($remark as $key => $detail_remark)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $detail_remark['student'] }}</td>
				<td>{{ $detail_remark['type'] }}</td>
				<td>{{ $detail_remark['time'] }}</td>
				<td>
					<a href="{{ URL::to('/show-test/'.$detail_remark['result_id']) }}" class="btn btn-warning">Mark</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
</div>
@endsection

@section('javascript')
@if(session()->has('success'))
<script>
	Swal.fire({
		icon: 'success',
		title: "{{ session()->get('success') }}",
		showConfirmButton: true,
		confirmButtonColor: 'orange',
		backdrop:false,
	})
</script>
@endif

@if(session()->has('error'))
<script>
	Swal.fire({
		icon: 'error',
		title: "Fail !",
		showConfirmButton: true,
		confirmButtonColor: 'orange',
		backdrop:false,
	})
</script>
@endif

<script>
	$(document).ready(function(){
		$('table').DataTable({
			responsive: true,
			autoWidth: false,
			columnDefs: [
			{"className": "dt-center", "targets": "_all"}
			],
		});

		$('.table_remark').hide();

		$('.newBtn').click(function(){

			$('.table_remark').hide();
			$('.table_new').show();
		});

		$('.remarkBtn').click(function(){

			$('.table_remark').show();
			$('.table_new').hide();
		});
	});
</script>
@endsection