{!! Form::open(['url' => '/user/study-maker/'.$study->id.'/publish','class'=>'form-inline','style'=>'display:inline-block']) !!}
   
   {!! Form::submit('publish article changes',['class'=>'btn btn-xs btn-danger','style'=>'display:inline-block;']) !!}

{!! Form::close() !!}