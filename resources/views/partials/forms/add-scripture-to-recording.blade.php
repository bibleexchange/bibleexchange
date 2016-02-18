{!! Form::open(['route'=>'add_scripture_to_recording','class'=>'form-inline']) !!}
	<div class="form-group">
		{!! Form::hidden('recording_id', $recording_id) !!}
		
		<label class="control-label" for="memo">Scripture Reference: </label>
		{!! Form::text('reference') !!}
		{!! $errors->first('reference', '<span class="help-block">:message</span>') !!}
	</div>
	{!! Form::submit('save',['class'=>'btn btn-primary save']) !!}
	
{!! Form::close() !!}