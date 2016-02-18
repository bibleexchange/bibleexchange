{!! Form::open(['url'=>'/user/course-maker/'.$course->uuid.'/section/'.$section->id.'/update','class'=>'edit-section']) !!}	
	
	{!! Form::text('title',$section->title,['id'=>'title','placeholder'=>'TITLE']) !!}
	{!! $errors->first('title', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
	{!! Form::textarea('description', $section->description,['id'=>'description','placeholder'=>'DESCRIPTION: Give a brief description of this section']) !!}
	{!! $errors->first('description', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::submit('update',['id'=>'save','class'=>'btn btn-xs btn-info']) !!} 
	
{!!Form::close()!!}