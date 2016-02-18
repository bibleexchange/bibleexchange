{!! Form::open(['route'=>'detach_recording_person','class'=>'form-inline']) !!}
	{!! Form::hidden('recording_id',$recording_id) !!}
	{!! Form::hidden('person_id', $person_id) !!}
	{!! Form::submit('X',['class'=>'btn btn-danger btn-xs']) !!}
{!! Form::close() !!}