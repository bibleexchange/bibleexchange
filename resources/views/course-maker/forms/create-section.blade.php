{!! Form::open(['url'=>'/user/course-maker/'.$course->id.'/create-section','class'=>'create-section']) !!}	
	
	{!! Form::text('title',null,['id'=>'title','placeholder'=>'TITLE']) !!}
	{!! $errors->first('title', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
	@if($errors->first('title') === 'Titles must be unique and there is already a study by that name.')
		View existing study <a href="/{!! Input::old('title') !!}">here</a>.
	@endif
	
	{!! Form::textarea('description', null,['id'=>'description','placeholder'=>'DESCRIPTION: Give a brief description of this section']) !!}
	{!! $errors->first('description', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::submit('create',['id'=>'save','class'=>'btn btn-primary']) !!} 			
	
{!!Form::close()!!}