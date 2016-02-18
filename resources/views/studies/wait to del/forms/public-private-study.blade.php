{!! Form::open(['url' => '/user/study-maker/'.$study->id.'/privatize','class'=>'form-inline','style'=>'display:inline-block']) !!}
   
   @if($study->isPublic())
   
		{!! Form::submit('make private',['class'=>'btn btn-xs btn-default','style'=>'display:inline-block;']) !!}
	
	@else
		{!! Form::submit('make public',['class'=>'btn btn-xs btn-default btn-danger','style'=>'display:inline-block;']) !!}
	@endif
	
{!! Form::close() !!}

