{!! Form::open() !!}	
	{!! Form::hidden('question_id', $question->id) !!}
	<?php 
		$options_array = explode('+',$question->options);
		$options[0] = 'choose';
		foreach($options_array AS $o){
			$options[trim($o)] = trim($o);
		}
	?>
	
	{!! Form::select('answer',$options, $answer) !!}

	{!! Form::submit('save',['id'=>'save','class'=>'btn btn-xs btn-info']) !!} 
	
{!!Form::close()!!}