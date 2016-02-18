@extends('courses.common')

@section('window')
	
	<div class="row">

	<div class="col-md-4 sidebar">
		
		<div class="update-image">
			<img src="{!!$course->defaultImage->src!!}" alt="{!!$course->defaultImage->alt_text!!}">			
		</div>
		
		<hr>
		
		<a href="{!!$course->rssUrl()!!}" class="btn btn-info btn-md" >Atom RSS Feed</a>
			
	</div>

	<div class="col-sm-8">

		<hr>

		@foreach($course->sections AS $section)
			<h2>Section {!! $section->orderBy!!}: {!! $section->title !!} ({!!$section->studies->count()!!})</h2>

				<p>{!! $section->description !!}</p>

					@foreach($section->studies AS $study)
					
						<!-- INCLUDE: studies.partials.study-preview -->
						@include('studies.partials.study-preview')
					
					@endforeach

		@endforeach
		
	</div>
	
</div>

@stop