<?php 
  		//this is a temporary hack for solving the following problem:
  		//in the event the user has an error registering
  		//default behavior is the user is return to this page
  		//but with the 'LOGIN" tab active instead of the 
  		//registration tab
  			
	if(count($errors) > 0 ){
  		$activeRegister = 'active';
  		$activeSignIn = '';
	}
  			
?>
@extends('layouts.default')

 @section('style_links')
 <link href='/assets/landing.css' rel='stylesheet' type='text/css'>
 @stop
 
 @section('content')

  	<div id="sub_be_banner" class="row redBG">
		<h1>Your place for Bible study and conversation.</h1>
  	</div>

  	<div id="theme-squares">
		<div class="be-logo square"></div>
		<div class="moses square"></div>
		<div class="apostles square"></div>
		<div class="paul square"></div>
		<div class="creation square"></div>		
		<div class="moses square"></div>
	</div>  	
	<div class="row">
		<div class="col-sm-4 col-sm-offset-2">
			<h3>With Bible exchange, you can:</h3>
			<ul>
			     <li>Discover sermons, lessons, poems, images, and stories that relate to the Scripture</li>
			     <li>Make notes on lessons and Bible verses</li>
			     <li>Ask questions and get answers about the Bible and lessons</li>
			     <li>See community notes from others</li>
			     <li>Save bookmarks</li>
			     <li>Follow instructors and see their lessons</li>
			</ul>
		</div>	
  		<div class="col-sm-4">
  			<ul class="nav nav-tabs">
			  <li role="presentation" class="{{$activeSignIn or 'active'}}"><a href="#sign-in" data-toggle="tab">Sign In</a></li>
			  <li role="presentation" class="{{$activeRegister or ''}}"><a href="#register" data-toggle="tab">Register</a></li>
			</ul>
  			
  			 <div id="my-tab-content" class="tab-content">
		        <div class="tab-pane {{$activeSignIn or 'active'}}" id="sign-in">
		        	<br>
		        	<!-- INCLUDE:  auth.forms.create -->
					@include('auth.forms.create')
		        </div>
		        <div class="tab-pane {{$activeRegister or ''}}" id="register">
		        	<br>
		        	<!-- INCLUDE:  auth.forms.register -->
					@include('auth.forms.register')
		        </div>
		    </div>

		</div>
	</div>	
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; margin-top: 1rem; margin-bottom: 1rem;} .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style>
			<div class='embed-container'>
				<iframe src='https://player.vimeo.com/video/120753625' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			</div>
		</div>
	</div>

		<div class="row heading-box" style="background-color:#FFB657;">
				<div class="col-md-12">
					<h2>Launched February 20, 2015</h2>
					<p>Journey with Us While We Grow</p>
					
					<p>
						<a href="https://twitter.com/bible_exchange">
							<img class="logo center-block" src="/svg/twitter-logo.svg" alt="follow us on Twitter">
						</a>
						<a href="https://www.facebook.com/thebibleexchange">
							<img class="logo center-block" src="/svg/facebook-logo.svg" alt="like us on Facebook">
						</a>
					</p>
				</div>	
		</div>	
 
		<div class="row heading-box" style="background-color:rgb(0, 201, 137);">
			<div class="col-md-12">
				<h2>We Gain by Trading</h2>
			
				<div class="center">		
				
				<p>&hellip;when he was returned &hellip; he commanded these servants to be called unto him, &hellip; that he might know how much every man had gained by trading. &mdash; Luke 19:15</p>
				
				</div>
			</div>
		</div>
@stop