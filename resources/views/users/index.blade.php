@extends('layouts.default')

@section('content')

    <h1 class="page-header">All Members</h1>
		{!! $users->render() !!}
		
		 @foreach ($users as $user)
			<div id="sub_be_banner" class="row redBG">
		<div class="col-xs-12">
			<div class="profile-pic"> @include ('users.partials.avatar', ['size' => 58,'user'=>$user])</div>
			<h1 class="username">{!! $user->fullname !!}</h1>			
			<p class="user-info">Member since: {{{$user->joined()}}}</p>
			<p class="user-info">{!! $user->present()->statusCount !!}</p>
			<p class="user-info">{{ $user->present()->followerCount }}</P>
			
			<span class="pull-right">
				@unless ($user->is($currentUser))
		           @include ('users.partials.follow-form',['user'=>$user])
		        @endif</span>
			</div>
		</div>
		<hr>
	@endforeach

@stop