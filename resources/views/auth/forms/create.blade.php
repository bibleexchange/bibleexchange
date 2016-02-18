 
 <?php 
 	if(! isset($redirect))
 	{
 		$redirect = null;
 	}
 ?>
 
 {!! Form::open(['url' => route('login_path')]) !!}
		
	{!! Form::hidden('redirect', $redirect) !!}
	
	 <div class="input-group">
	 	<span class="input-group-addon" id="signin-email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"> email</span></span>
	 	{!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required','aria-describedby'=>'signin-email']) !!}
	 </div>
	
	 <br>
	
	  <div class="input-group">
	 	<span class="input-group-addon" id="signin-password"><span class="glyphicon glyphicon-lock" aria-hidden="true"> password</span></span>
	 	{!! Form::password('password', ['class' => 'form-control', 'required' => 'required','aria-describedby'=>'signin-password']) !!}
	 </div>
	
	 <br>
	
	 <div class="input-group">
	 {!! Form::submit('Sign In', ['class' => 'btn btn-success']) !!}
		 &nbsp;{!! Form::checkbox('remember', 'true') !!} remember me
		 
	</div>
	<span class="pull-right">
		 	 {!! link_to('/password/remind', 'reset your password') !!}
		 </span>
{!! Form::close() !!}