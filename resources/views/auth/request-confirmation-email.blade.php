@extends('layouts.default')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<center>
				<img src="/images/be_logo.png?w=500&h=500" id="register-logo">
			</center>
		</div>
		<div class="col-md-6">
			
			<center><h1>Confirm Your Email</h1></center>
			
			<ol>
			
			@if($currentUser)
			
				<li style="color:gray;"><em>Done.</em> Log in To Your Account.</li>
				
				<li style="color:green;">Click button below to request a confirmation email.</li>
			
				@include('auth.forms.request-confirmation-email')
				
			@else
				<li style="color:green;">Log in To Your Account</li>
				
				<!-- INCLUDE: auth.forms.login -->
				@include('auth.forms.create',['redirect'=>'/register/request-confirmation-email'])
				
				<hr>
				
				<li style="color:gray;">Click button below to request a confirmation email.</li>
				
				<button style="" class="disabled" disabled>confirm</button>
				
			@endif

			
			</ol>
			
		</div>
	</div>
</div>

@stop