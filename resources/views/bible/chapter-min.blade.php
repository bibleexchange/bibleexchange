<?php

$go_to_previous = '?bible='.$chapter->previousReference;
$go_to_next = '?bible='.$chapter->nextReference;
$search_here =  '#';
	
?>

<style>

  #feedback	{
  	background-color:#fff;
  	width:100%;
  	z-index:50;
  }

  #dismiss-selectable {
  	z-index:50;
  	width:10000px;
  	height:10000px;
  	position:absolute;
  	top:-2000px;
  	left:0;
  	background: rgba(255, 255, 255, 0.5);
  	z-index:-5;
  }
  
  #feedback.animated.off {
  	display:none;
  }
  
  #feedback {
  	position:fixed;
  	bottom:0;
  	padding: 2rem 5rem 5rem 5rem;
  }
  
  #feedback p {margin:15px;}
  
  #bible .ui-selecting { background: #67818a; }
  #bible .ui-selected { background: #ADD8E6 }
  
  .bible-highlight {
  	border-radius:15%;
  	padding:0;
  	border-style: dashed; 
  	border-left:none; 
  	border-right:none;
	}
  
</style>

	<div id="feedback" class="row animated off">
		
		<button id="dismiss-selectable" class="btn btn-warning btn-xs" onclick="deselectSelectable()">clear</button>
		
		@include('bible.forms.highlight')
		<span id="select-reference"></span>
		<span id="dynamic-verse-info"></span>
		
		@if($currentUser)
			<!-- INCLUDE: notes.partials.publish-scripture-note-js' -->
			@include('notes.partials.publish-scripture-note-js-min')
		@endif
	</div>
		
			<div id="bible">
				
				<span id="search-results"></span>
				
				<h2>Chapter {{$chapter->orderBy}}</h2>
				
				@foreach($chapter->verses AS $v)
					<p title="{{$v->reference}}" id="{{$v->id}}" class="ui-widget-content">
					<sup>{{$v->v}}</sup>

					@if($currentUser && $v->userHighlight($currentUser) !== null)		
							<?php 
							$color = $v->userHighlight($currentUser)->color();
							?>
							<mark class="bible-highlight" style="border-color:{{$color->strong}}; background-color:{{$color->subtle}};">
							 {!! $v->kjvrText() !!}
							</mark>
						
						@else
							{!! $v->kjvrText() !!}
						@endif
					</p>
				@endforeach
				<hr>
				<a id="nextChapterButton" href="{!!$go_to_next!!}" class="btn btn-success">next chapter</a>
				<hr>				
			</div>