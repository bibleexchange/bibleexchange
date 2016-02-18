<div class="course-preview">
	
	<div class="public">
		
		<span class="badge">{!! $course->studies()->count() !!}</span>
		
		@if($course->isPublic())
		<a class="btn btn-xs btn-primary" href="{!! $course->url() !!}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;&nbsp;View</a>
		
		@else
		<a class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a>
		
		@endif
		
		@if($currentUser && $currentUser->id === $course->user_id)
		<a class="btn btn-xs btn-success" href="{!! $course->editUrl() !!}">Edit</a>
		@endif
	</div>
	
	<img class="main-image" src="{!! $course->defaultImage->src !!}" alt="{!! $course->defaultImage->alt_text !!}" id="{!! $course->defaultImage->name !!}">
	
	<div class="title public{!! $course->public !!}">{!! $course->title !!}</div>
	
	<div class="description">{!! $course->description !!}</div>
	
</div>