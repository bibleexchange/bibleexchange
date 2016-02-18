@extends('studies.common')

@section('window')

<div class="row create">
	<div class="container">
	<div class="col-md-8 col-md-offset-2">
	
		@include('studies.forms.study-editor')
	
		@if(Session::has('error'))
		<p class="errors">{{ Session::get('error') }}</p>
		@endif
	
	@include('partials.upload-file')
	
	<hr>
		@include('studies.partials.article-tips')
	</div>
	</div>
</div>
	
@stop

@section('scripts')

	@parent

	@include('studies.partials.study-editor-js')

@stop