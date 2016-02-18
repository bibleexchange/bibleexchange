@extends('courses.common')
@section('window')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
			@include('layouts.partials.lesson')
			
			<hr>
			@if($lesson->nextLesson !== null && $lesson->nextLesson->approved == 1)
			<a href="{!!$lesson->nextLesson->defaultURL!!}" class="btn btn-success">next lesson</a>
			
			@else
			<a href="/{!!$lesson->course->slug!!}" class="btn btn-info">back to course</a>
			
			@endif
			<hr>
			
			
		</div>
	</div>
	
@stop