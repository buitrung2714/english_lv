@extends('admin.layout.layout')
@section('admin_content')

<style>
	table>thead{
		background: #00bcd4;
		color: #fff;
	}

</style>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::previous() }}">Back</a></li>
		<li class="breadcrumb-item active" aria-current="page">Help</li>
	</ol>
</nav>

<div class="grids">
	<div class="progressbar-heading grids-heading">
		<h2>About Excel</h2>
	</div>

	<div class="asked">
		<div class="questions">
			<h5>1.Import Excel:</h5>
			<br><span style="font-weight:bold">Save as:</span>
			<p style="color: red; font-weight: bold;border: 2px solid red;">File Name: Skill_Part_Level.xlsx </p><br>
			<img src="/file/help/import_excel.png" alt="No Image" width="1075" height="200"><br><br>
			<span style="font-weight:bold;">Description:</span>
			<table class="table table-bordered table-responsive text-center">
				<thead>
					<tr>
					<th></th>
					<th>A</th>
					<th>B</th>
					<th>C</th>
					<th>D</th>
					<th>E</th>
					<th>F</th>
					<th>G</th>
					<th>H</th>
					<th>I</th>
					<th>J</th>
					<th>K</th>
				   </tr>
				</thead>
				<tbody>
					<tr>
						<th style="background-color: #549465;color: #fff;">Topic New</th>
						<td>Topic Name</td>
						<td>Path Audio in PC</td>
						<td>Content</td>
						<td>Path Image in PC</td>
						<td>Question</td>
						<td>Mark</td>
						<td>Answer A</td>
						<td>Answer B</td>
						<td>Answer C</td>
						<td>Answer D</td>
						<td>True for A,B,C,D ( 1 -> 4 )</td>
					</tr>
					<tr>
						<th style="background-color: #549465;color: #fff;">Topic Available</th>
						<td>Topic Name</td>
						<td>Use Path Audio in PC for change. Unless change use Topic's Link Drive or Empty</td>
						<td>Content</td>
						<td>Use Path Image in PC for change. Unless change use Topic's Link Drive or Empty</td>
						<td>Question</td>
						<td>Mark</td>
						<td>Answer A</td>
						<td>Answer B</td>
						<td>Answer C</td>
						<td>Answer D</td>
						<td>True for A,B,C,D ( 1 -> 4 )</td>
					</tr>
				</tbody>
			</table><br>
			
			<span style="font-weight:bold;">Rules:</span><br>
			<div style="width: 380px; height: 200px; border: 2px solid red; padding: 12px;">
				<b>Skill:</b><br>
				<span>Listening: A, B, E, F, G, H, I, J, K <b>* NOT EMPTY *</b></span><br>
				<span>Reading: A, C, E, F, G, H, I, J, K <b>* NOT EMPTY *</b></span><br>
				<span>Writting: A, C, E, F <b>* NOT EMPTY *</b></span><br>
				<span>Speaking: A, C, E, F <b>* NOT EMPTY *</b></span><br>
				<b>Warning:</b><br>
				<span>Question <b>NOT</b> duplicate in a Topic</span><br>
				<span>Answer <b>NOT</b> duplicate in a Question</span><br>
			</div>
		</div><br>
		<div class="questions">
			<h5>2.Export Excel:</h5><br>
			
			<div style="width: 170px; height: 110px; border: 2px solid black; padding: 8px; display: inline;" class="text-left">
				<span>Skill: Chose skill</span><br>
				<span>Part: Chose Part</span><br>
				<span>Level: Chose Level</span><br>
				<span><b>Click DOWNLOAD</b></span><br>
			</div>
			<img src="/file/help/export_excel.png" alt="No Image" style="margin-left: 140px" width="500" height="400">
		</div>				    
	</div>
</div>	

@endsection