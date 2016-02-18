<article class="comments__comment media note-media">
	@include ('users.partials.avatar', ['user' =>$comment->owner, 'class' => 'media-object']) <a href="{{ $comment->owner->profileURL() }}">{{ $comment->owner->username }}</a>: {{ $comment->body }}
</article>