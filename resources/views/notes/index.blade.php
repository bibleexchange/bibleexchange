@extends('layouts.user') 
@section('window')

	@include('notes.partials.feed')

@stop

@section('scripts')
	<!-- INCLUDE: notes.partials.note-js -->
	<script>@include('notes.partials.note-js')</script>	
@stop