@extends('layouts.default')

@section('content')

    <div id="sub_be_banner" class="row redBG">
		<div class="col-xs-12">
			<h1>Lessson Editor</h1>
		</div>
    </div>
    
    <nav id="lesson-editor" class="navbar navbar-default navbar-fixed-bottom">
	  <div class="container">
	    <a type="button" class="btn btn-md" href="/user/lessons">
			  Index
			</a>
			
			<a type="button" class="btn btn-md" data-toggle="collapse" 
		   data-target="#create-lesson">
			  <span class="glyphicon glyphicon-plus"></span> Create Lesson
			</a>
				                
		    <a type="button" class="btn btn-md" data-toggle="collapse" 
			   data-target="#create-course">
			  <span class="glyphicon glyphicon-plus"></span> Create Course
			</a>
			
			<div id="create-lesson" class="collapse @if ($errors->count() >= 1 ) in @endif">	
				{!! $errors->first('title', '<small style=\'color:red;\'>*:message</small><br>') !!}
					
					{!! Form::open(['class'=>'','url'=>'user/lessons','autocomplete'=>'off']) !!}
	
						{!! Form::text('title',null,['placeholder'=>'title']) !!}
					
						{!! Form::submit('create',['class'=>'btn btn-info']) !!}
					
					{!! Form::close() !!}
			</div>	
			<div id="create-course" class="collapse @if ($errors->count() >= 1 ) in @endif">
			 	{!! Form::open(['url'=>'user/courses']) !!}
			 		<div class="form-group">
					{!! Form::label('course_title') !!}
					{!! Form::text('course_title') !!}
					{!! $errors->first('course_title', '<li style="color:red;">*:message</li>') !!}
					</div>
					<div class="form-group">
					{!! Form::label('course_subtitle') !!}
					{!! Form::text('course_subtitle') !!}
					{!! $errors->first('course_subtitle', '<li style="color:red;">*:message</li>') !!}
					</div>
					<div class="form-group">			
					{!! Form::label('course_shortname') !!}
					{!! Form::text('course_shortname') !!}
					{!! $errors->first('course_shortname', '<li style="color:red;">*:message</li>') !!}
					</div>
					<div class="form-group">			
					{!! Form::submit('new',['class'=>'btn btn-info']) !!}						
					</div>
				{!! Form::close() !!}
			</div>	
			
	  </div>
	</nav>    	
         
	@yield('window')

@stop