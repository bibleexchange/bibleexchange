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
			<center><h1>Create Your Free Account</h1></center>
			<!-- INCLUDE: auth.forms.register -->
			@include('auth.forms.register')
		</div>
	</div>
</div>

@stop