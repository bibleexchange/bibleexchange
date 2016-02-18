@extends('layouts.default')

@section('be_sub_banner')

<div id="sub_be_banner" class="row redBG" >
		<div class="col-xs-12">

			<h2><a href="{{$course->url()}}">{{$course->title}}</a>
				
				@if($currentUser && $course->user_id === $currentUser->id)
					<a href="/user/course-maker/{!!$course->id!!}" type="button" class="btn btn-link btn-xs update-icon" >
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <span class="text">edit</span>
					</a>
				@endif
			
			</h2>
			
				<div class="center">
					<small>{{$course->subtitle}}</small>
				</div>
			
			<div class="center">			
				<h4 style='text-align:center;'>&nbsp;{!! $previousAndNext or "" !!}</h4>
			</div>
		</div>
</div>
@stop

@section('content')

	@yield('window')

@stop