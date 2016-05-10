@extends('layouts.default')

@section('be_sub_banner')

<div id="sub_be_banner" class="row redBG" >
<span class="hidden">from Bible Exchange, the place to share and grow your knowledge and love for the Bible</span>
</div>

<div class="textbook" >
		<div class="h1-box">
	
			@if( ! isset($creating))
			<small class="pull-right">
				 @if (Auth::check() && Auth::user()->hasRole('be_editor'))
				<a href="/recording/edit/{{$recording->id}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="{!!$recording->url()!!}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
				&nbsp;&nbsp;&nbsp;
				@endif
			</small>
			@endif
		<h1 id="{{$recording->present()->urlTitle}}">
		

		
		@if( isset($creating))<small>ADD A NEW RECORDING TO BE</small><br><br> @endif
		{!! $page->title !!}
			<div class="center">
				<small><!--  subtitle --></small>
			</div>
			
			<small class="pull-left">
				@if( ! isset($creating) && $recording->updated_at !== null)
				Updated: {!! $recording->updated_at !!}
				@endif
			</small>
		</h1>
	
		<div class="h1-underline"></div>
		<div class="h1-underline"></div>
		<div class="h1-underline"></div>
		
	</div>	

</div>

@stop

@section('content')

<div id="studies">
	
	{!!Form::open(['url'=>'/recordings/search','id'=>'go-to-recording'])!!}
		{!! Form::text('query') !!}
		{!! Form::submit('search',['class'=>'btn btn-warning']) !!}
	{!!Form::close()!!}

	@yield('window')
</div>
@stop