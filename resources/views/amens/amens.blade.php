@extends('users.public')

@section('window')

	 @if(count($amens) < 1)
	<p>No Amens here yet.</p>
	
	@else
	
	<div id="noteFeed"></div>
	
	<center>
		<img id="loadinggif" src="{!!url('/assets/images/loader.gif')!!}">
		<button class="load_more">Loading...</button>
	</center>
		
	@endif
    
@stop

@section('scripts')
	<script>@include('amens.amen-js')</script>	
@stop