{!! Form::open(['url'=>'/user/study-maker/'.$study->id.'/update-description','class'=>'form-inline']) !!}
	<div class="form-group">
        <label class="control-label" for="description">Description: &nbsp;&nbsp;&nbsp;</label>
		<textarea type="text" name="description" id="description" />{!! $study->description !!}</textarea>
	</div>
		{!! Form::submit('save',['class'=>'btn btn-primary save']) !!}
		{!! $errors->first('description', '<span class="help-block">:message</span>') !!}
{!! Form::close() !!}