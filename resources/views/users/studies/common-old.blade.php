@extends('layouts.default')

@section('content')

    <div id="sub_be_banner" class="row redBG">
		<div class="col-xs-12">
			<h1>Lessson Editor</h1>
		</div>
    </div>

    <div id="lesson-editor-wrapper" class="@if (Request::is('user/lessons')) no @else toggled @endif">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="/user/lessons">
                        Lesson Editor
                    </a>
                </li>
                
            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">
	        	<span id="sub">&mdash;</span>
	        	<span id="add" class="hidden">+</span>
	        </a>
                
                <hr>
				{!! $errors->first('title', '<small style=\'color:red;\'>*:message</small><br>') !!}
				
				{!! Form::open(['class'=>'','url'=>'user/lessons','autocomplete'=>'off']) !!}

					{!! Form::text('title',null,['placeholder'=>'title']) !!}
				
					{!! Form::submit('create') !!}
				
				{!! Form::close() !!}
				
				<hr>
				
				@foreach ($currentUser->lessons as $lesson)
				
                <li>
                    <a href="/user/lessons/{{$lesson->id}}/edit">{{$lesson->title}}</a>
                </li>
				
				@endforeach
				
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
	</div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">                  
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    
                    <a type="button" class="btn btn-xs" data-toggle="collapse" 
	   data-target="#create-course">
	  <span class="glyphicon glyphicon-plus"></span> Create Course
	</a>
	
	<div id="create-course" class="collapse @if ($errors->count() >= 1 ) in @endif">
	 	{!! Form::open(['url'=>'/user/courses']) !!}
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
                    
	                   @yield('window')
	         		</div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

  
    <!-- /#wrapper -->

@stop

@section('scripts')

    <!-- Menu Toggle Script -->
    <script>

    $( "a#menu-toggle" ).click(function() {
    	  $( "#lesson-editor-wrapper" ).toggleClass( "toggled" ).animate('slow');
    	  $( "#add" ).toggleClass( "hidden" ).animate('slow');
    	  $( "#sub" ).toggleClass( "hidden" ).animate('slow');
    	});
    
    </script>
    
@stop