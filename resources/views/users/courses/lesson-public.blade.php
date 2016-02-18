@extends('users.public')
@section('window')
	
	<div id="sub_be_banner" class="row greenBG" >
		<div class="col-xs-12">

			<h2><a href="{{$course->url()}}">{{$course->title}}</a></h2>
			
				<div class="center">
					<small>{{$course->subtitle}}</small>
				</div>
			
			<div class="center">			
				<h4 style='text-align:center;'>&nbsp;{!! $previousAndNext or "" !!}</h4>
			</div>
		</div>
</div>
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
			@include('layouts.partials.lesson')
			
			<hr>
			@if($lesson->nextLesson !== null && $lesson->nextLesson->published == 1)
			<a href="{!!$lesson->nextLesson->profileUrl($lesson->instructor->username)!!}" class="btn btn-success">next lesson</a>
			
			@else
			<a href="{!!$lesson->course->profileUrl($lesson->instructor->username)!!}" class="btn btn-info">back to course</a>
			
			@endif
			<hr>
			
			
		</div>
	</div>
	
@stop