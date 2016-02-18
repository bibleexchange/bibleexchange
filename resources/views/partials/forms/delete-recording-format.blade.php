{!! Form::open(['route'=>'delete_recording_format','class'=>'form-inline']) !!}
	{!! Form::hidden('format_id',$format_id) !!}
	{!! Form::hidden('recording_id', $recording_id) !!}
	{!! Form::submit('X',['class'=>'btn btn-danger btn-xs']) !!}
{!! Form::close() !!}