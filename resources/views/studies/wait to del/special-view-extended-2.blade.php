@extends('layouts.special-sidebar')

@section('sidebar-main')
	
	@if($study->exists)
	
	<style>
		#bible-text {padding:0; margin:0; background-color:#fff;}
		#bible-panel p {color:black; text-align:left;}
		
		#bible-panel .panel-title {color:black; text-align:center; overflow:hidden;}
		#bible-panel #bible-text {padding:0;}
		
		#bible-text h2 {
			color:black;
		}
		
	</style>	
		
		<img class="study-default-image" src="{{$page->mainImage->src}}" name="{{$page->mainImage->name}}" alt="{{$page->mainImage->alt_text}}">
		
		<div id="bible-panel" class="sidebar-block blueBG" style="padding-left:0; padding-right:0;">
				
					<h2><a id="bible-text-toggle" href="#bible-text" data-toggle="collapse" data-parent="#bible-panel" class="collapsed">Scripture</a></h2>				
				
			<div class="blueBG" style="margin-bottom:25px; text-align:center; width:100%; display:block; position:absolute:top;">
			<!-- INCLUDE: bible.partials.nav -->	
			<?php
		$go_to_previous = '?bible='.$chapter->previousReference;
		$go_to_next = '?bible='.$chapter->nextReference;
		$search_here =  '#';

?>
	
	<a id="previousChapter" href="{!!$go_to_previous!!}" value="Next"class="btn btn-default" style="border:none; background:transparent;"><span class="glyphicon glyphicon-chevron-left"></span></a>

@include('bible.forms.search')
						
	<a id="nextChapter" href="{!!$go_to_next!!}" value="Next"class="btn btn-default" style="border:none; background:transparent;"><span class="glyphicon glyphicon-chevron-right"></span></a>
				
<!-- Button that triggers modal -->
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" style="border:none; background:transparent;">
 	<span class="glyphicon glyphicon-th"></span>
</button>	
		
@if($currentUser)
	<!-- partials.bookmark-it -->
	@include('partials.bookmark-it')
@endif

<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">
	      
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Choose a book and chapter to open</h4>
	      </div>
	      
	      <div class="modal-body">
	      
        		@foreach($booksOftheBible AS $b)
					<div class="btn-group">
					  <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" style="width:75px; height:50px; overflow:hidden;">
						<strong>{{strtoupper(substr($b->n,0,4))}}</strong>
					  </a>
					  <ul class="dropdown-menu" role="menu">
						@foreach($b->chapters AS $c)
						<li class="square-list"><a class="chapter-link" id="{{$c->id}}" href="#">{{$c->orderBy}}</a></li>
						@endforeach
					  </ul>
					</div>
				@endforeach	
		  </div>
		  
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	      
	    </div>
	</div>
</div>
	</div>
			 
			  <div id="bible-text" class="panel-body panel-collapse collapse" style="max-height:600px; overflow:scroll; overflow-x:hidden;">
					<div id="bibleWindow" style="color:black;"></div>
			  </div>
		</div>
				
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

	@if($study->exists)
		
		@include('studies.partials.textbook')
	
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