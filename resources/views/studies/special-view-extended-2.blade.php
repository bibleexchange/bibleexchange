@extends('layouts.special-sidebar')

@section('sidebar-main')
	
	@if($study->exists)
	
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
	
	@else
		
		BLANK
	
	@endif
	
@stop

@section('sidebar-secondary')
	
	@if($study->exists)
		@include('studies.partials.aside')
	@else
		BLANK
	@endif
	
@stop

@section('main-content')

	@if($study->exists && $bible)
		
		<div style="width:55%;">
			@include('studies.partials.textbook')
		</div>
		<div id="bible-panel" style="width:30%; position:fixed; right:20px; bottom:0; ">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<a href="#bible-text" data-toggle="collapse" data-parent="#bible-panel">
					<h3 class="panel-title">Resources</h3>
				</a>
			  </div>
			  <div id="bible-text" class="panel-body panel-collapse collapse in" style="max-height:600px; height:600px; overflow:scroll; overflow-x:hidden;">
				@include('bible.chapter-min')
			  </div>
			</div>
		</div>
	
	@elseif($study->exists && $bible === false)
	
		@include('studies.partials.textbook')
		
	@elseif($study->exists === false && $bible != false)
	
		@include('bible.chapter-min')
	
	@else
		
		BLANK
	
	@endif
	
@stop

@section('scripts')
	<script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type="text/javascript">
		@include('partials.jquery-selectable-test')
	</script>
@stop