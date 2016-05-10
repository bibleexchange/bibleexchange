@extends('layouts.admin')

@section('window')

<table width="100%">
<tr style="border:none;">
	<td rowspan='38' width="275px" style="padding:5px;">
		<img src="/assets/be_logo.png" width="150px" style="margin:auto auto; text-align:center; display:block;">
		
		<h4>Deliverance Bible Institute / Bible exchange</h4>
		<h4>Student Transcript</h4>
		
		<p>1008 Congress Street Portland, Maine 04102
		<br>207-774-8192
		<br>info@deliverance.me
		<br>http://bible.exchange
		</p>
		
		<p>
			<strong>Student: </strong>{{$userWithTranscripts->fullname}}<br>
			<strong>GPA: </strong>{{$userWithTranscripts->transcriptInfo()->careerGPA}}<br>
			<strong>Credits: </strong>{{$userWithTranscripts->transcriptInfo()->careerCredits}}
		</p>
		<br><br><br><br>
		<p>Dated: {{\Carbon::now() }}</p>
		
	</td>
		<th>Completed</th><th>Course Name</th><th>Credits</th><th>GPA</th><!--<th>Credits x GPA = QP</th>-->
		
</tr>

@foreach($userWithTranscripts->transcripts AS $t)
<tr>
	<td>{{Carbon::parse($t->created_at)->toDateString()}}</td><td>{{$t->course->title}}</td><td>{{$t->credits_attempted}}</td><td>{{$t->gpa}}</td><!--<td>{{$t->totalgpa}}</td>-->
</tr>
@endforeach

</table>
@stop