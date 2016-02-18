<ul class="media-list">
   <li class="media">
			
         @include ('users.partials.avatar', ['user' =>$note->user, 'image_class' => 'note-media-object', 'anchor_class'=>'pull-left'])

      <div class="media-body">
         <p class="media-heading">
			{!!$note->user->fullname !!}

			<small class="note-media-time">{!! $note->present()->timeSincePublished() !!}</small>
			<small><a href="{!! $note->verse->url(1) !!}">{!! $note->verse->reference !!}</a></small>

		</p>
		
		@if($note->image !== null)
			<image src="{!! $note->image->src !!}" alt="{!! $note->image->alt_text !!}" width="100%" style="max-width:450px">
			<hr>
		@endif
		
		<p>	
			@include('partials.forms.amen',['amenable'=>$note])

			{!! $note->body !!}

		</p>	
			<span class="actions">
				@if ($currentUser)
				
						<!-- Button trigger modal -->
				<a type="button" class="btn btn-xs"
					data-toggle="modal" data-target="#myModal{!!$note->id!!}"
					><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>comment</a>
				@endif
					<a type="button" class="btn btn-xs" data-toggle="collapse" 
					   data-target="#social-buttons{!!$note->id!!}">
					  <span class="glyphicon glyphicon-share-alt"></span> share
					</a>
					
					<a type="button" class="btn btn-xs" href="{!!$note->url()!!}">
					  <span class="glyphicon glyphicon-arrow-right"></span> more
					</a>
					
					@if($currentUser && $currentUser->id === $note->user_id)
						<a href="/user/note/{{$note->id}}/delete" type="button" class="btn btn-xs" style="color:red">delete</a>	
					@endif
					
					<div id="social-buttons{!!$note->id!!}" class="collapse">
					 	@include('partials.sharing',[
					 		'twitter_text'=> substr(str_replace(' ','+',strip_tags($note->body)),0,33) . '&hellip;',
					 		'object'=>$note,
					 		'fb_share_url'=>$note->fbShareUrl(),'share_url'=>$note->url(),'share_title'=>strip_tags($note->body),'share_media'=>$note->defaultImageUrl(),'editor_url'=>$note->user->url])
					</div>	
			</span>
			
		<!-- Nested media object -->
		@unless ($note->comments->isEmpty())
			@include('partials.comments',['commentable'=> $note])
		@endunless 
		<!-- ./Nested media object -->
   </li>
</ul>

<!-- Modal for comments-->
@if ($currentUser)

<div class="modal fade" id="myModal{!!$note->id!!}" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Comment on this Note</h4>
			</div>
			<div class="modal-body">
				@include('partials.forms.comment',['object'=>$note])
			</div>
			<div class="modal-footer">
				
				<button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
				
			</div>
		</div>
	</div>
</div>
@endif
<!-- ./Modal for comments-->