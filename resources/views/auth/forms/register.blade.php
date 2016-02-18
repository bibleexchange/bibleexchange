{!! Form::open(['route'=>'register_path']) !!}
    <fieldset>
    	 <br>
		  <div class="input-group">
		 	<span class="input-group-addon" id="email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> email (confirmation req.)</span>	 	
		 	{!! Form::text('email', Input::old('email'),['class'=>'form-control','placeholder'=>'ava_lee_1987@mail.com','required' => 'required','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('email', '<small style=\'color:red;\'>*:message</small>') !!}
		 </div>
		 
    	 <br>
 
		<div class="input-group">
		 	<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock" aria-hidden="true"> password</span></span>
		 	{!! Form::password('password', ['placeholder'=>'minimum 8 characters','class' => 'form-control', 'required' => 'required','aria-describedby'=>'basic-addon2']) !!}
		 	{!! $errors->first('password', '<small style=\'color:red;\'>*:message</small>') !!}
		 </div>
	 
    	 <br>
		<div class="input-group">
		 	<span class="input-group-addon" id="password_confirmation"><span class="glyphicon glyphicon-lock" aria-hidden="true"> password confirmation</span></span>
		 	{!! Form::password('password_confirmation', ['placeholder'=>'minimum 8 characters','class' => 'form-control', 'required' => 'required','aria-describedby'=>'password_confirmation']) !!}
		 	{!! $errors->first('password_confirmation', '<small style=\'color:red;\'>*:message</small>') !!}
		 </div>
        
         <br>
         
        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">Create new account</button>
        </div>
    </fieldset>
{!! Form::close() !!}