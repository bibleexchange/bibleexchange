@extends('layouts.default')

{{-- Content --}}
@section('content')

<div id="sub_be_banner" class="row redBG" >

		<div class="col-xs-12">
		
		@if($currentUser->isConfirmed())
			<h2>Hi! We are so glad to have you on Bible exchange.</h2>
	
			<p>First off, let's get to know a little more about you so we can personalize your account.</p>
			
		@else
			<h1>Please Confirm Your email. </h1>
		@endif
			
		</div>

</div>

	<div class="row">
		<!-- Navbar -->
		<div class="col-sm-3" >
			
				<div class="media">
					<div class="pull-left">
						<?php $user = $currentUser; ?>
						@include ('users.partials.avatar', ['size' => 50])
					</div>

					<div class="media-body">
						
					
						</ul>
						
						<ul class="nav">
							<li>Member since: {{{$currentUser->joined()}}}</li>
							<li><a href="{{route('home')}}"><span class='glyphicon glyphicon-home'></span> Your Home</a></li>
						</ul>

					</div>
				</div>
		</div>
		
		<div class="col-sm-9">
		
			@yield('window')
		
		</div>

	</div>

@stop