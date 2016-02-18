<div class="panel panel-default panel-study pub_{{$study->is_published}}">
  <a href="{!!$study->url()!!}" ><img class="study-object-default-image" src="{{$study->defaultImage->src}}?h=600&w=600" name="{{$study->defaultImage->name}}" alt="{{$study->defaultImage->alt_text}}"></a>
  
  <div class="panel-heading">
  
  	<a href="{!!$study->url()!!}">
  	
	    <h3 class="panel-title">
	    	{{ $study->present()->title }}
	    </h3>
    </a>
  </div>
  <div class="panel-body">
  		{{ $study->present()->description }}
  		<span style="display:block; clear:both; margin-bottom:5px;"></span>
		@foreach($study->editors() As $editor)
			<a href="{{$editor->profileURL()}}" title="{!!$editor->fullname!!}">@include ('users.partials.avatar', ['size' => 25,'user'=>$editor])</a> 
		@endforeach
     
  </div>
  <div class="panel-footer">
		
			@if($study->isPublic())
			<a href="{!!$study->url()!!}" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Open</a>
			
			@else
			<a class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a>
			
			@endif
		
  	 	
 		
 		@if ($currentUser)
		
	  	 	{!! Form::open(['url'=>'/user/bookmarks']) !!}
				<input type="hidden" name="url" value="{!!url($study->url())!!}">
				<button type="submit" value="Next"class="btn btn-info" >
					<span class="glyphicon glyphicon-bookmark"></span> <span class="hidden-md">Bookmark</span>
				</button>
			{!! Form::close()!!}
	  	 	 
	  	 	@if ($study->isCreator($currentUser))
				<a class="btn btn-warning" role="button" href="{!!$study->editUrl()!!}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <span class="hidden-xs hidden-md">Edit</span></a>
			@endif
		
		@endif
  	 	 
  		<span class="updated"><span class="glyphicon glyphicon-time"></span> <!--Sept 16th, 2012-->{{ $study->present()->lastChangeWasMade }}</span>
  	
  </div>
</div>