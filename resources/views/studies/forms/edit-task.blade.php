{!! Form::open(['url' => '/user/study-maker/'.$study->id.'/task/'.$task->id.'/update', 'class'=>'edit-task']) !!}	
	
	{!! Form::text('title',$task->title,['id'=>'title','placeholder'=>'TITLE']) !!}
	{!! $errors->first('title', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
	{!! Form::textarea('instructions', $task->instructions,['id'=>'instructions','placeholder'=>'Instructions: Clearly explain how to to complete this task.']) !!}
	{!! $errors->first('instructions', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::text('points',$task->points,['id'=>'title','placeholder'=>'POINTS']) !!}
	{!! $errors->first('points', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::submit('update',['id'=>'save','class'=>'btn btn-xs btn-info']) !!} 
	
{!!Form::close()!!}