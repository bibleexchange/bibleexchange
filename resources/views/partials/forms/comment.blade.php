{!! Form::open(['route'=> 'comment_path', 'class' =>'form-inline', 'style'=>'width:80%']) !!}

	{!! Form::hidden('commentable_id',$object->id) !!}
	{!! Form::hidden('commentable_type',get_class($object)) !!}
	
	{!! Form::textarea('body', null, ['class' =>'form-control', 'rows' => 2, 'style'=>'width:80%']) !!}
	
	{!! Form::submit('send',['class'=>'btn btn-md btn-success']) !!}

{!! Form::close() !!}