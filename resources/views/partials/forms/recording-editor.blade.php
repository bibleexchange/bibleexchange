{!!Form::open(['id'=>'recording-editor','class'=>'editor'])!!}	
	
	{!! Form::label('title','Title: ') !!}
	{!! Form::text('title',$form->title,['id'=>'title']) !!}
	
	{!! Form::label('dated','Dated: ') !!}
	{!! Form::text('dated', $form->dated ,['id'=>'dated','placeholder'=>'']) !!}
	{!! $errors->first('dated', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::label('date','Date (deprecated): ') !!}
	{!! Form::text('date', $form->date ,['id'=>'date','placeholder'=>'']) !!}
	{!! $errors->first('date', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	<hr>
	{!! Form::label('description','Description: ') !!}
		
	{!! Form::textarea('description', $form->description,['id'=>'description','placeholder'=>'']) !!}
	{!! $errors->first('description', '<br><small style=\'color:red;\'>*:message</small>') !!}
	
	{!! Form::label('genre','Genre: ') !!}
	{!! Form::select('genre', ['music'=>'music','podcast'=>'podcast','preaching'=>'preaching','testimony'=>'testimony','teaching'=>'teaching'], $form->genre ,['id'=>'genre','placeholder'=>'']) !!}
	{!! $errors->first('genre', '<br><small style=\'color:red;\'>*:message</small>') !!}
	<hr>
	{!! Form::submit('save',['id'=>'save','class'=>'btn btn-success']) !!} 			
	
{!!Form::close()!!}