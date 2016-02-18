<h1>{{ $note->edamNote->title }}</h1>

<article>
{!! $note->getContent() !!}
</article>

	@if($note->resources !== null)
	
<h2>Attachments</h2>

		@foreach($note->resources AS $resource)
			
			<?php
				$resUrl = 'https://sandbox.evernote.com/shard/s1' . '/res/' . $resource->guid;
			?>

			size: {{ $resource->data->size }}
			name: {{ $resource->attributes->fileName }}
			<br>
			
			@if($resource->mime === "audio/mpeg")
				<audio controls>
				  <source src="{{$resUrl}}" type="{{ $resource->mime }}">
				Your browser does not support the audio element.
				</audio>	
			
			@elseif($resource->mime === "image/png")
			
				<img src="{{$resUrl}}" />
			
			@endif
			
			
			
		@endforeach

	@endif