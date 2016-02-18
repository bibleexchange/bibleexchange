<?php
	
	if(isset($bible) && $bible === true){
		$go_to_previous = '?bible='.$chapter->previousReference;
		$go_to_next = '?bible='.$chapter->nextReference;
		$search_here =  '#';
	}else{
		$go_to_previous = $chapter->previousURL;
		$go_to_next = $chapter->nextURL;
		$search_here =  '#';
	}
	
?>
	
	<a href="{!!$go_to_previous!!}" value="Next"class="btn btn-default" style="border:none; background:transparent;"><span class="glyphicon glyphicon-chevron-left"></span></a>

@include('bible.forms.search')
						
	<a href="{!!$go_to_next!!}" value="Next"class="btn btn-default" style="border:none; background:transparent;"><span class="glyphicon glyphicon-chevron-right"></span></a>
				
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
						<li class="square-list"><a href="/kjv/{{$b->slug}}/{{$c->orderBy}}">{{$c->orderBy}}</a></li>
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