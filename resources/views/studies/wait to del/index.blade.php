@extends('studies.common')

@section('window')

	{!!Form::open(['route'=>'go_to_study','id'=>'go-to-study'])!!}
		{!! Form::text('query') !!}
		{!! Form::submit('study it!',['class'=>'btn btn-warning']) !!}
	{!!Form::close()!!}
	
	<div class="row" style="clear:both">

		<div class="col-md-8 col-md-offset-2">
			<!-- partials.course-carousel -->
			@include('partials.courses-carousel')
			
			<hr>
			
			@include('studies.partials.studies-index')
			<center>{!! $studies->render() !!}</center>
		</div>
	</div>
	
@stop