{!! Form::open(['route'=>'delete_recording','class'=>'form-inline']) !!}
	{!! Form::hidden('recording_id', $recording_id) !!}
	{!! Form::submit('delete recording and all its properties',['class'=>'btn btn-danger btn-xs']) !!}
{!! Form::close() !!}