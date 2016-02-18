{!! Form::open() !!}	
	{!! Form::hidden('question_id', $question->id) !!}
	
	<input type="radio" name="answer" value="true" @if($answer === 'true') checked @endif>True
	<input type="radio" name="answer" value="false" @if($answer === 'false') checked @endif>False
	
	{!! Form::submit('save',['id'=>'save','class'=>'btn btn-xs btn-info']) !!} 
	
{!!Form::close()!!}