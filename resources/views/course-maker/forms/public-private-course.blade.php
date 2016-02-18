{!! Form::open(['url' => '/user/course-maker/'.$course->id.'/publish','class'=>'form-inline','style'=>'display:inline-block']) !!}
   
   @if($course->isPublic())
   
		{!! Form::submit('make private',['class'=>'btn btn-md btn-default']) !!}
	
	@else
		{!! Form::submit('make public',['class'=>'btn btn-md btn-default btn-danger']) !!}
	@endif
	
{!! Form::close() !!}