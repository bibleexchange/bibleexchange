<?php 
if(isset($routebyprofile))
{
	$course_url = $c->profileUrl($username);
	$lesson_count = $c->lessons()->published()->count();
}else{
	$course_url =$c->url();
	$lesson_count = $c->lessons()->published()->approved()->count();
}
?>
<div class="col-md-12 tileImage {{$colors[$i]}}" >
	<h2><a href="{{$course_url}}" title="{{$c->title}}">{{$c->present()->title}}</a></h2>
	<p class="lesson-count">{{$lesson_count}} {{Helpers::pluralize('Lesson', $lesson_count)}}</p>

	<div class="lesson-block-meta hidden-xs hidden-sm">

		<div class="lesson-block-excerpt">
			<p>{{ $c->subtitle }}</p>    
		</div>
		<p class="lesson-date">updated: {{ $c->present()->updated_at }}</p>
	</div>

</div>