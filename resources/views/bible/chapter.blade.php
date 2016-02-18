@extends('layouts.default')

@section('styles')

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
  
@stop

@section('content')
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
	<div class="row blueBG" style="margin-bottom:25px; text-align:center;">
		<div class="container">
			<div class="col-xs-12">	
				<!-- INCLUDE: bible.partials.nav -->	
				@include('bible.partials.nav')
			</div>
		</div>
	</div>
	
	<div class="row">
	
		<div class="col-md-5 col-md-offset-1">
		
			<div id="bible">
			
				@foreach($chapter->verses AS $v)
					<?php if($v->v == $urlVerse){$selected = 'selectedVerse';}else{$selected = NULL;}?>
					<p title="{{$v->reference}}" id="{{$v->id}}" class="ui-widget-content {{$selected}}">
						<sup>{{$v->v}}</sup>

						@if($currentUser && $v->userHighlight($currentUser) !== null)		
<?php 

$color = $v->userHighlight($currentUser)->color();

/*						
							<?php 
							$words = explode(' ', strip_tags($v->kjvrText()));
							
							?>
							
							@foreach($words AS $word)
									
								<mark class="bible-highlight" style="border-style: solid; border-top:none; border-left:none; border-right:none; border-bottom-color:{{$color}};"> {{ $word }}</mark>
						
							@endforeach
*/
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
				<a href="{!!$chapter->nextURL!!}" class="btn btn-success">next chapter</a>
				<hr>
			</div>
		</div>
		<div class="col-md-5 col-no-padding-mobile">	
			
			@if($currentUser)
			
			<div id="feed" class="bs-example">
				
				<div class="panel-group" id="accordion">
			        <div class="panel panel-default" >
			            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#cStudy">
			                <h4 class="panel-title">
			                    <a data-toggle="collapse" data-parent="#accordion" href="#cStudy">Studies ({!!$chapter->studies->count()!!})<span class="caret pull-right"></span></a>
			                </h4>
			            </div>
			            <div id="cStudy" class="panel-collapse collapse">
			                <div class="panel-body">
			                	<!-- INCLUDE: studies.partials.studies-blocks' -->		
								@include('studies.partials.studies-blocks',['studies'=>$chapter->studies])
			                </div>
			            </div>
			        </div>
			    </div>
				
			    <div class="panel-group" id="accordion">
			        <div class="panel panel-default">
			            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
			                <h4 class="panel-title">
			                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Community Notes ({!!count($chapter->notes)!!})<span class="caret pull-right"></span></a>
			                </h4>
			            </div>
			            <div id="collapseThree" class="panel-collapse collapse in">
			                <div class="panel-body">
								
								<!-- INCLUDE: notes.partials.notes -->
								@include ('notes.partials.notes', ['notes' => $notes])
								
								@section('scripts')
									<!-- INCLUDE: notes.partials.note-js -->
									<script>@include('notes.partials.note-js')</script>	
								@stop
			                </div>
			            </div>
			        </div>
			    </div>
			    
			</div>
				
			@else
				
				<!-- INCLUDE: notes.partials.notes-php -->
				@include ('notes.partials.notes-php', ['notes' => $notes])
				
				<!-- INCLUDE: bible.partials.more-here-sign-register -->
				@include('bible.partials.more-here-sign-register')
				
			@endif
			
		</div>
		
	</div>

@stop

@section('scripts')
	<script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type="text/javascript">
		@include('partials.jquery-selectable-test')
	</script>
@stop