@extends('layouts.default')

@section('content')

	<div id="sub_be_banner" class="row redBG">
		<div class="col-sm-5">
			<div class="profile-pic"> 
		        
		        @include ('users.partials.avatar', ['size' => 58])
		        
			</div>
			<h1 class="username">
				{!! $user->fullname !!}
			</h1>			
			<p class="user-info">Member since: {{{$user->joined()}}}
			  	@unless ($user->is($currentUser))
		           @include ('users.partials.follow-form')
		        @endif
			</p>			
		</div>
		
		<div class="col-sm-7">
			
			<?php 
			if(Request::is('*amens*')){
				$amenState = 'active';
			}else if (Request::is('*notes*')){
				$noteState = 'active';
			}else if (Request::is('*studies*')){
				$studyState = 'active';
			}else if (Request::is('*courses*') | isset($versePage)){
				$courseState = 'active';
			}else if (Request::is('*following*') | isset($versePage)){
				$followingState = 'active';
			}else if (Request::is('*followers*') | isset($versePage)){
				$followerState = 'active';
			}else{
				$noteState = 'active';
			}
			?>
			<style>
				#profile-menu .btn{vertical-align:middle; border-radius:0; margin-top:12px;}
				#profile-menu .badge{border-radius: 1px;  font-size:170%;}
				#profile-menu hr {margin-top:15px; margin-bottom:15px;}
				
				@media(max-width:998px){
					#profile-menu {clear:both;}
				}
				
			</style>
			
			<div id="profile-menu">
		      <div class="btn-group">
		        <a href="{{$user->profileUrl()}}/amens" class="btn btn-danger {{$amenState or null}}"><span class="badge badge-warning">{{$user->amens->count()}}</span><hr>Amens</a>
		        <a href="{{$user->profileUrl()}}/notes" class="btn btn-danger {{$noteState or null}}"><span class="badge badge-warning">{{$user->notes->count()}}</span><hr>Notes</a>
		        <a href="{{$user->profileUrl()}}/studies" class="btn btn-danger {{$studyState or null}}"><span class="badge badge-warning">{{$user->studies()->public()->count()}}</span><hr>Studies</a>
		        <a href="{{$user->profileUrl()}}/courses" class="btn btn-danger {{$courseState or null}}"><span class="badge badge-warning">{{$user->courses()->public()->count()}}</span><hr>Courses</a>
		      </div>
		      <div class="btn-group" role="group" aria-label="Second group">
		        <a href="{{$user->profileUrl()}}/following" class="btn btn-danger {{$followingState or ""}}"><span class="badge badge-warning">{{$user->followedUsers->count()}}</span><hr>Following</a>
		        <a href="{{$user->profileUrl()}}/followers" class="btn btn-danger {{$followerState or ""}}"><span class="badge badge-warning">{{$user->followers->count()}}</span><hr>Followers</a>
		        
		      </div>
		      
			</div>
						
		</div>
	</div>
      
     <hr>
      
	@yield('window')

@stop