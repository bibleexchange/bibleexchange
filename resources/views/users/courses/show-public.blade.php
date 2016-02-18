@extends('users.public')

@section('window')	

	<div id="sub_be_banner" class="row greenBG" >
		<div class="col-xs-12">

			<h2><a href="{{$course->profileUrl($user->username)}}">{{$course->title}}</a></h2>
			
				<div class="center">
					<small>{{$course->subtitle}}</small>
				</div>
			
			<div class="center">			
				<h4 style='text-align:center;'>&nbsp;{!! $previousAndNext or "" !!}</h4>
			</div>
		</div>
</div>

		@foreach ($course->lessons()->published()->get() as $lesson)
	
			@include('layouts.partials.lessonObject',['routebyprofile'=>'on'])
		
		@endforeach
@stop