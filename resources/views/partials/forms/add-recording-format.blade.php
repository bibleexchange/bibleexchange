{!! Form::open(['route'=>'create_recording_format','class'=>'form-inline']) !!}
	<div class="form-group">
		{!! Form::hidden('recording_id', $recording_id) !!}
		
		<label class="control-label" for="file_name">File: </label>
		{!! Form::text('file') !!}
		
		<label class="control-label" for="format">Format: </label>
		{!! Form::select('format', ['mp3'=>'mp3', 'tape'=>'tape', 'godaddy-mp3'=>'godaddy-mp3', 'soundcloud-mp3'=>'soundcloud-mp3','soundcloud-m4a'=>'soundcloud-m4a']) !!}
		
		<label class="control-label" for="memo">Memo: </label>
		{!! Form::text('memo') !!}
		
	</div>
	{!! Form::submit('save',['class'=>'btn btn-primary save']) !!}
	{!! $errors->first('main_verse', '<span class="help-block">:message</span>') !!}
{!! Form::close() !!}