@extends('layouts.default')

@section('content')

<div id="sub_be_banner" class="row greenBG" >
	<div class="col-sm-5">
		<div class="profile-pic">@include ('users.partials.avatar', ['size' => 80,'user'=> $currentUser])</div>
		<h1 class="username">{{ $currentUser->fullname}}</h1>
		<p class="user-info">Member since: {{{$currentUser->joined()}}}</p>
	</div>
	
	<div class="col-sm-7">
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
		        <a href="{{$currentUser->profileUrl()}}/amens" class="btn btn-success {{$amenState or null}}"><span class="badge badge-warning">{{$currentUser->amens->count()}}</span><hr>Amens</a>
		        <a href="/user/notes" class="btn btn-success {{$noteState or null}}"><span class="badge badge-warning">{{$currentUser->notes->count()}}</span><hr>Notes</a>
		        <a href="/user/study-maker" class="btn btn-success {{$studyState or null}}"><span class="badge badge-warning">{{$currentUser->studies()->count()}}</span><hr>Studies</a>
		        <a href="/user/course-maker" class="btn btn-success {{$courseState or null}}"><span class="badge badge-warning">{{$currentUser->courses()->count()}}</span><hr>Courses</a>
		      </div>
		      <div class="btn-group" role="group" aria-label="Second group">
		        <a href="{{$currentUser->profileUrl()}}/following" class="btn btn-success {{$followingState or ""}}"><span class="badge badge-warning">{{$currentUser->followedUsers->count()}}</span><hr>Following</a>
		        <a href="{{$currentUser->profileUrl()}}/followers" class="btn btn-success {{$followerState or ""}}"><span class="badge badge-warning">{{$currentUser->followers->count()}}</span><hr>Followers</a>
		      </div>
			</div>
	</div>
</div>

	<div class="row">
		<!-- Navbar -->
		<div class="col-md-4 hidden-sm hidden-xs">	
			<div class="media">
				<div class="media-body">						
					<div class="sidebar-left">
						<ul class="nav">
							<!-- INCLUDE: partials.user-nav-list -->
							@include('partials.user-nav-list')	
						</ul>
					</div>
					<hr>
					<div class="sidebar-left">
						<h2>following:</h2>
						@foreach ($currentUser->followedUsers as $f)
							<!-- INCLUDE: users.partials.avatar -->
							@include ('users.partials.avatar', ['size' => 25, 'user' => $f])
						@endforeach
					</div>
					<hr>
					<div class="sidebar-left">
						<h2>followers:</h2>
						@foreach ($currentUser->followers as $follower)
							<!-- INCLUDE: users.partials.avatar -->
							@include ('users.partials.avatar', ['size' => 25, 'user' => $follower])
						@endforeach
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-8">
		
			@yield('window')
		
		</div>

	</div>

@stop