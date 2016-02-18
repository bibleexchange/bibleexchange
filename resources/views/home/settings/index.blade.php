@extends('layouts.user')

@section('window')
<div class="page-header">
	<h1>Your Profile Settings</h1>
</div>

@include('home.partials.profile-form')

<hr>

	@if($currentUser->profile_image !== null)
			{!! Form::open(['action'=>'UserSettingsController@deleteProfileImage']) !!}
				{!! Form::hidden('user_id',$currentUser->id) !!}
				<div class="form-group">
					<label for="delete_profile_image"><img src="{!!$currentUser->present()->gravatar!!}">
					
					{!! Form::hidden('delete_profile_image',1,['class'=>'form-control']) !!}
					{!! Form::submit('delete',['class'=>'btn btn-sm btn-danger']) !!}
					 Your Profile Image &amp; Use <a href="//en.gravatar.com/support/how-to-sign-up/">Gravatar</a> instead.</label>
					
				</div>
			
			{!! Form::close() !!}
			@endif
<hr>

<h2>Login Settings:</h2>

<ul>
    <li><a href="/password/remind">Change Password</a></li>
</ul>

<h2>Connect Your Accounts</h2>

@include('home.partials.evernote-form')

<hr>
@stop