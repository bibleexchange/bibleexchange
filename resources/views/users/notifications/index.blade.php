@extends('layouts.user')

@section('window')

<h2>Notifications 
<small>@if ($unread_count >= 1 )
	{!! $unread_count !!} | 
	   {!! Form::open(['route' => 'read_notifications_path','style'=>'display:inline-block;']) !!}
            {!! Form::hidden('i_read_notifications', 'yes') !!}
            <button class="button btn-xs" type="submit">
				mark as read
            </button>
        {!! Form::close() !!}
        
        @endif</small></h2>
        
@foreach ($notifications AS $notification)
	@include('partials.notification')
@endforeach

@stop