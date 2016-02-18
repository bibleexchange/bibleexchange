{!! Form::open(['url'=>'/user/study-maker/'.$study->id.'/update-main-verse','class'=>'form-inline']) !!}
	<div class="form-group">
        <label class="control-label" for="main_verse">Change Primary Bible Verse: </label>
		<input type="text" name="main_verse" id="main_verse" value="{!! $study->mainVerse->reference or 'NULL' !!}" />
	</div>
		{!! Form::submit('save',['class'=>'btn btn-primary save btn-xs']) !!}
		{!! $errors->first('main_verse', '<span class="help-block">:message</span>') !!}
{!! Form::close() !!}