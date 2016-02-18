{{ Form::open(array('files'=>'true')) }}
	<h2>Change Your Profile Image:</h2>
	
	{{ Form::hidden('user_id',$currentUser->id) }}
	{{--
	<div class="form-group">
		{{ Form::label('title','Title:') }}
		{{ Form::text('title',null,['class'=>'form-control']) }}
	</div>
	--}}
	<div class="form-group">
		{{ Form::file('fileName') }}
	</div>
	
	<div class="form-group">
		{{ Form::submit('Upload Image',['class'=>'btn btn-primary']) }}
	</div>

{{ Form::close() }}