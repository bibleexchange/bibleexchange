{!!Form::open(['id'=>'studyeditor','class'=>'editor'])!!}	

		{!! Form::label('title','Title: ') !!}
		{!! Form::text('title',$form->title,['id'=>'title']) !!}
		
		{!! $errors->first('title', '<br><small style=\'color:red;\'>*:message</small>') !!}
			
		@if($errors->first('title') === 'Titles must be unique and there is already a study by that name.')
			View existing study <a href="/{!! Input::old('title') !!}">here</a>.
		@endif
		
		{!! Form::label('comment','Editing Comments: ') !!}
		{!! Form::text('comment', $form->comment ,['id'=>'comment','placeholder'=>'EXAMPLE: This is the first text written in this study']) !!}
		{!! $errors->first('comment', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
		{!! Form::label('description','Description (1-3 sentences): ') !!}
		{!! Form::textarea('description', $form->description,['id'=>'description','placeholder'=>'Briefly explain the context or limits of this study.']) !!}
		{!! $errors->first('description', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
		{!! Form::label('text','Body: ') !!}
			<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">
			 (optional) upload from .md file
			</button>
			
		{!! Form::textarea('text', $form->body,['id'=>'text','placeholder'=>'Start the body of your study here. Use markdown to style the text. ']) !!}
		{!! $errors->first('text', '<br><small style=\'color:red;\'>*:message</small>') !!}
		
		{!! Form::submit('save',['id'=>'save','class'=>'btn btn-success']) !!} 			
		
	{!!Form::close()!!}