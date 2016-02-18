@extends('layouts.special-sidebar')

@section('sidebar-main')
	
	<img class="study-default-image" src="{{$page->mainImage->src}}" name="{{$page->mainImage->name}}" alt="{{$page->mainImage->alt_text}}">
						
	@if($currentUser && $study->isCreator($currentUser))
		<div class="sidebar-block redBG">
			<h2><a href="{!!$study->editUrl()!!}"><span class="glyphicon glyphicon-edit" aria-hidden="false"></span> Edit</a></h2>
		</div>
	@endif		
	<div class="sidebar-block orangeBG">
		<h2>Author</h2>
		<p> 
			@include ('users.partials.avatar', ['size' => 25,'user'=>$study->creator])
			<a>
				{{$study->creator->fullname}}
			</a> 				
		</p>
		<p class="small">
			Edited by
				@foreach($study->editors() As $editor)
					<a href="{{$editor->profileURL()}}">
					{{$editor->fullname}}
					</a> 
				@endforeach		
		</p>
	</div>
	
@stop

@section('sidebar-secondary')
	
	@include('studies.partials.aside')
	
@stop

@section('main-content')

	@include('studies.partials.textbook')

@stop