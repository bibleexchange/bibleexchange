@extends('recordings.common')

@section('window')

<div class="row create" style="clear:both;">
	<div class="container">
	<div class="col-md-8 col-md-offset-2">
	
	@include('partials.forms.recording-editor')
	
		@if(Session::has('error'))
		<p class="errors">{{ Session::get('error') }}</p>
		@endif
	
	</div>
	</div>
</div>

@stop