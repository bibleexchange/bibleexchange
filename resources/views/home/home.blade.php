@extends('layouts.user') 
@section('window')

<hr>

@if (Session::has('last_scripture'))
	<hr>
  Continue Reading: <a href="{!! url(Session::get('last_scripture')) !!}">{!! Session::get('last_scripture_readable') !!}</a>
  <hr>
@endif

@if ( $notifications->count() >= 1)
		
	<h2>Notifications 
		<small>
			
		{!! $notifications->count() !!} | 
		   {!! Form::open(['route' => 'read_notifications_path','style'=>'display:inline-block;']) !!}
	            {!! Form::hidden('i_read_notifications', 'yes') !!}
	            <button class="social-sharing-buttons social-amen" type="submit">
					mark as read
	            </button>
	        {!! Form::close() !!}
	        
	        
		<a class="social-sharing-buttons social-amen" href="{!! url('/user/notifications') !!}">more</a>
		</small>
	</h2>
	@foreach ($notifications AS $notification)
		@include('partials.notification')
	@endforeach

@endif

@include('notes.partials.feed')

@stop

@section('scripts')
	<!-- INCLUDE: notes.partials.note-js -->
	<script>@include('notes.partials.note-js')</script>	
@stop