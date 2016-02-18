@extends('layouts.default')

@section('content')

<div class="textbook" >
	
	<div class="h1-box">

		<h1 style="padding-left:0;">{!! $page->title !!}</h1>
	
		<div class="h1-underline"></div>
		<div class="h1-underline"></div>
		<div class="h1-underline"></div>
		
	</div>	
	
	@include('partials.courses-list',['courses'=>$courses])

	<center>{!! $courses->render() !!}</center>
	
</div>

@stop