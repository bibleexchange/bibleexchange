 @foreach ($commentable->comments as $comment) 

	 <div class="media">

	@include ('users.partials.avatar', ['user' =>$comment->owner, 'image_class' => 'note-media-object', 'anchor_class'=>'pull-left'])

		<p class="media-heading">
			{!! $comment->owner->fullname !!}
		</p>

		<p>
			{!! $comment->body !!}					
			
		<span class="actions comment">
			@if ($currentUser)
				@if($currentUser->id === $comment->user_id)
			<a href="/user/comment/{{$comment->id}}/delete" type="button" class="btn btn-xs">x</a>	
				@endif
				
			@endif
		</span>
		</p>
	 </div>
	 
 @endforeach