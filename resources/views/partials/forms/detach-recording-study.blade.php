{!! Form::open(['url'=>url('/user/study-maker/'.$study_id.'/recording/'.$recording_id.'/detach'),'class'=>'form-inline']) !!}
	{!! Form::hidden('study_id',$study_id) !!}
	{!! Form::hidden('recording_id', $recording_id) !!}
	{!! Form::submit('X',['class'=>'btn btn-danger btn-xs']) !!}
{!! Form::close() !!}