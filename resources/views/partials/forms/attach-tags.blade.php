{!! Form::open(['url'=>url('/user/study-maker/'.$study->id.'/update-tags'),'class'=>'form-inline']) !!}

	{!! Form::hidden('object_id', $object->id, ['class'=>'form-control']) !!}
	{!! Form::hidden('object_class', get_class($object), ['class'=>'form-control']) !!}
	
	<div class="form-group">
        {!! Form::label('tags','Tags (comma separated):') !!}
		{!! Form::text('tags', $object_tags_string, ['class'=>'form-control']) !!}
	</div>
		{!! Form::submit('save',['class'=>'btn btn-primary save']) !!}
		{!! $errors->first('tags', '<span class="help-block">:message</span>') !!}
{!! Form::close() !!}