<div class="note-post">
	
	{!! Form::open(['route' => 'notes_path','files'=>'true','id'=>'publish-note','class'=>'mini-publish-note']) !!}
	
		<!-- Note Form Input -->
		{!! Form::textarea('body', Input::old('body'), ['id'=>'body','class' =>'form-control', 'rows' => 3, 'placeholder' => "Make a Bible note here"]) !!}
		{!! Form::hidden('bible_verse_id','') !!}
	
		<div class="input-group" style="width:100%;">
			<div class="pull-left">
				{!! Form::label('note_image', 'Optional Image: ',['class'=>'pull-left','style'=>'margin-right:10px']) !!}			
				{!! Form::file('note_image',['class'=>'pull-left']) !!}
			</div>
			
			<div class="pull-right">
				(<em id="count"></em>) <span class="toomuch">Whoa! Maybe you should shorten this up a bit? :)</span>
				{!! Form::submit('post',['class' => 'btn btn-success btn-xs']) !!}
			</div>
		</div>
		
	{!! Form::close() !!}
</div>