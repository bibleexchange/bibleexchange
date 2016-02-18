{!! Form::open(['route'=>'attach_recording_person','class'=>'form-inline']) !!}
	{!! Form::hidden('recording_id',$recording_id) !!}
	{!! Form::select('person_id', $persons) !!}
	
	{!! Form::select('role', ['preacher'=>'preacher','teacher'=>'teacher','singer'=>'singer','host'=>'host','producer'=>'producer','testifier'=>'testifier','Prayer'=>'Prayer']) !!}
	
	{!! Form::text('memo',null, ['placeholder'=>'memo']) !!}
	
	{!! Form::submit('save',['class'=>'btn btn-primary btn-xs']) !!}
{!! Form::close() !!}