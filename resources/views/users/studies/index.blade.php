@extends('layouts.user')

@section('content')

		<div id="sub_be_banner" class="row greenBG">
			<div class="col-xs-12">
				<h1>
					<a class="pull-left" href="{!! url('/user/course-maker/'.Session::get('last_edited_course_id')) !!}" style="text-decoration: none;">
						<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><sup> last course</sup>
					</a>
					{!! $page->title !!}
				</h1>
			</div>
		</div>
	

	<span class="pull-left" style="padding-top:15px;">
		@if(Input::has('q'))
			Would you like to start a new study on "<a href="/user/study-maker/{!!Input::get('q')!!}/create">{{Input::get('q')}}</a>" ?	
		@else
			<a href="{!!url('/user/study-maker/BLANK/create')!!}" class="btn btn-md btn-primary">Create New Study</a>
		@endif
	</span>
	

	
	{!!Form::open(['route'=>'go_to_user_study','id'=>'go-to-study'])!!}
		{!! Form::text('query') !!}
		{!! Form::submit('study it!',['class'=>'btn btn-warning']) !!}
	{!!Form::close()!!}
	
	<div class="row" style="clear:both">
		<div class="col-xs-12">
			@include('studies.partials.studies-index')
			<center>{!! $studies->appends(Input::except('page'))->render() !!}</center>
		</div>
	</div>
	
@stop