{!! Form::open(['route'=>'attach_study','class'=>'attach-task-study']) !!}	
	
	{!! Form::hidden('task', $task->model->id) !!}	
	{!! Form::hidden('object_class', 'BibleExchange\Entities\Study') !!}
	
	{!! Form::label('object_id','Which study?') !!}
	{!! Form::select('object_id', $task->globalStudies, null , ['id'=>'study']) !!}
	{!! $errors->first('object_id', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::submit('save to task',['id'=>'save','class'=>'btn btn-primary btn-xs']) !!} 			
	
{!!Form::close()!!}