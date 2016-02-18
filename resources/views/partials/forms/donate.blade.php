{!! Form::open(['url'=>'https://www.paypal.com/cgi-bin/webscr', 'class'=>'form-inline']) !!}
  {!! Form::hidden('cmd','_s-xclick') !!}   		
  {!! Form::hidden('hosted_button_id','MNDYCC59PET5A') !!}   			
  {!! Form::submit('donate',['class'=>'btn btn-default'])!!}
{!! Form::close() !!}