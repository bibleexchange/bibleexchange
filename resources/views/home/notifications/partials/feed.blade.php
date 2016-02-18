@foreach($unreadNotifications as $notification)
	<div class="notification {{ $notification->type }}">
	<p class="subject">{{ $notification->subject }}</p>
	<p class="body">{{ $notification->body }}</p>

	@if($notification->type == "FavoriteRecipe" && $notification->hasValidObject())
		<a href="/recipes/{{ $notification->getObject()->id }}">View Recipe</a>
		@end
		</div>
@endforeach