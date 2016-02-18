@extends('layouts.user-not-setup')

@section('window')
	
		@if($currentUser->isConfirmed())
			@include('home.partials.profile-form')
		@else
				
			<h1>&nbsp;</h1>
			<p>For a quality experience, we need to make sure you're a person :). Check your email for a link to confirm your address.</p>
	
			<p>If you can't find it, resend confirmation email below.</p>
			
					@include('auth.forms.request-confirmation-email')

		@endif
	
@stop