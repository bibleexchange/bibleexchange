{!! Form::open(['route'=>'settings_path','files'=>'true']) !!}
	
    <fieldset>
    	 <br>
		  <div class="input-group">
		 	<span class="input-group-addon" id="firstname"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"></span> First Name: </span>	 	

		 	{!! Form::text('firstname', $currentUser->firstname,['class'=>'form-control','placeholder'=>'my firstname','required' => 'required','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('firstname', '<small style=\'color:red;\'>*:message</small>') !!}
			</div>

    	 <br>
 		  <div class="input-group">
		 	<span class="input-group-addon" id="middlename"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"></span> Middle Name: </span>	 	
			
			{!! Form::text('middlename', $currentUser->middlename,['class'=>'form-control','placeholder'=>'my middlename or initial','required' => 'required','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('middlename', '<small style=\'color:red;\'>*:message</small>') !!}
			
			</div>

    	 <br>
    	 		  <div class="input-group">
		 	<span class="input-group-addon" id="lastname"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"></span> Last Name: </span>	 	
			
			{!! Form::text('lastname', $currentUser->lastname,['class'=>'form-control','placeholder'=>'my lastname','required' => 'required','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('lastname', '<small style=\'color:red;\'>*:message</small>') !!}

			</div>

    	 <br>
    	 <div class="input-group">
		 	<span class="input-group-addon" id="suffix"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"></span> Suffix: </span>	 	

			{!! Form::text('suffix', $currentUser->suffix,['class'=>'form-control','placeholder'=>'jr, sr, III or whatever you tag on to the end of your name :)','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('suffix', '<small style=\'color:red;\'>*:message</small>') !!}
			</div>

    	 <br>
		<div class="input-group">
		 	<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"> Gender: </span></span>
			{!! Form::select('gender',['lady'=>'lady','gentleman'=>'gentleman'] ,$currentUser->gender,['class'=>'form-control','placeholder'=>'jr, sr, III or whatever you tag on to the end of your name :)','required' => 'required','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('gender', '<small style=\'color:red;\'>*:message</small>') !!}
		 </div>
        
		
		 <br>
		<div class="input-group">
		 	<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"> Location: </span></span>
			{!! Form::text('location',$currentUser->location,['class'=>'form-control','be as specific/non-specific as you like: Portland, Maine or CANADA','required' => 'required','aria-describedby'=>'basic-addon1']) !!}
			{!! $errors->first('location', '<small style=\'color:red;\'>*:message</small>') !!}
		 </div>
		
         <br>
         
          <div class="input-group">
		 	<span class="input-group-addon" id="profile_image"><span class="glyphicon glyphicon-gravatar" aria-hidden="true"></span> Pofile Image*: </span>	 	

			{!! Form::file('profile_image',['class'=>'btn btn-default']) !!}
			{!! $errors->first('profile_image', '<small style=\'color:red;\'>*:message</small>') !!}
			</div>
	<p>*To continue using Gravator as your profile image just skip this field.</p>
	<br><br>
        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </fieldset>
{!! Form::close() !!}
