{!! Form::open() !!}	
	
	{!! Form::hidden('question_id', $question->id) !!}
	
	{!! Form::textarea('answer',$answer,['placeholder'=>'Essay answer','style'=>'width:100%;']) !!}

	{!! Form::submit('save',['id'=>'save','class'=>'btn btn-xs btn-info']) !!} 
	
{!!Form::close()!!}