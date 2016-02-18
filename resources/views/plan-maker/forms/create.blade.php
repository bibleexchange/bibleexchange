{!! Form::open(['class'=>'create-course']) !!}	

	<h2>Title:</h2>
	{!! Form::text('title',$form->title,['id'=>'title','placeholder'=>'TITLE']) !!}
	{!! $errors->first('title', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
	@if($errors->first('title') === 'Titles must be unique and there is already a study by that name.')
		View existing study <a href="/{!! Input::old('title') !!}">here</a>.
	@endif
	<h2>Description:</h2>
	{!! Form::textarea('description', $form->description,['id'=>'description','placeholder'=>'DESCRIPTION: In 1 to 3 sentences explain the purpose of this course.']) !!}
	{!! $errors->first('description', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::submit('save',['id'=>'save','class'=>'btn btn-primary']) !!} 			
	
{!!Form::close()!!}