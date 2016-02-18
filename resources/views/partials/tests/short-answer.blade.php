{!! Form::open() !!}
	{!! Form::hidden('question_id', $question->id) !!}
	{!! Form::text('answer',$answer,['placeholder'=>'single word or short phrase expected','style'=>'width:80%;']) !!}
		
	{!! Form::submit('save',['id'=>'save','class'=>'btn btn-xs btn-info']) !!} 
	
{!!Form::close()!!}