{!! Form::open(['url'=>'/user/course-maker/'.$section->course->id.'/section/'.$section->id.'/attach-study']) !!}	

	{!! Form::select('study',$currentUser->studiesNotUsedList($section->course->studies()->lists('id')),['id'=>'title']) !!}
	{!! $errors->first('study', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::submit('add',['class'=>'btn btn-primary']) !!} 			
	
{!!Form::close()!!}