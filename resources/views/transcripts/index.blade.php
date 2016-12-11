@extends('layouts.admin')

@section('window')

	@foreach($students AS $student)

	<li><a href="/admin/transcripts/{{$student->id}}">{{ $student->fullname }}</a></li>
	
	@endforeach

@stop