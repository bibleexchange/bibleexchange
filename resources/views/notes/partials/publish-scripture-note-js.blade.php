<div class="note-post">
	
	{!! Form::open(['route' => 'notes_path','files'=>'true','id'=>'publish-note']) !!}
	
	<!-- Note Form Input -->
	<div id="note_body" class="form-group">
		{!! Form::label('body') !!} (<em id="count"></em>) <span class="toomuch">Whoa! Maybe you should shorten this up a bit? :)</span>
		{!! Form::textarea('body', Input::old('body'), ['class' =>'form-control', 'rows' => 3, 'placeholder' => "What's on your mind?"])
		!!}
		
	</div>

	<div class="form-group note-post-submit">
	
		{!! Form::hidden('bible_verse_id','') !!}
	<hr>
	<div class="input-group" style="width:100%">
		<span style="width:80%">
		{!! Form::label('note_image', 'Optional Image: ',['class'=>'pull-left','style'=>'margin-right:10px']) !!}			
		{!! Form::file('note_image',['class'=>'pull-left']) !!}
	</span>
		{!! Form::submit('post',['class' => 'btn btn-xs pull-right']) !!}
	</div>
	</div>
	{!! Form::close() !!}
</div>