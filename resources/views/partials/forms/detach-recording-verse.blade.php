{!! Form::open(['route'=>'detach_recording_verse','class'=>'form-inline']) !!}
	{!! Form::hidden('recording_id',$recording_id) !!}
	{!! Form::hidden('verse_id', $verse_id) !!}
	{!! Form::submit('X',['class'=>'btn btn-danger btn-xs']) !!}
{!! Form::close() !!}