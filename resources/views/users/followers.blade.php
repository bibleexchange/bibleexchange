@extends('users.public')

@section('window')

@foreach($users_list AS $info)

<div id="sub_be_banner" class="row redBG">
		<div class="col-xs-12">
			<div class="profile-pic"> @include ('users.partials.avatar', ['size' => 58,'user'=>$info])</div>
			<h1 class="username">{!! $info->fullname !!}</h1>			
			<p class="user-info">Member since: {{{$info->joined()}}}</p>
			<p class="user-info">{!! $info->present()->statusCount !!}</p>
			<p class="user-info">{{ $info->present()->followerCount }}</P>
			
			<span class="pull-right">
				@unless ($info->is($currentUser))
		           @include ('users.partials.follow-form',['user'=>$info])
		        @endif</span>
		</div>
	</div>
	<hr>
@endforeach

@stop