<p>
     	@foreach($recording->formats AS $format)
     		
     		@if ($currentUser && $currentUser->can('delete_be_recording_format') && Request::is('r/*'))
     			@include('partials.forms.delete-recording-format',['recording_id'=>$recording->id, 'format_id'=>$format->id])
     		@endif
     		{!! $format->stream !!} <span class="pull-right">{!! $format->download !!}</span><hr>
     		
     		<?php 
     			$arrayOfFormats[] = $format->format; 
     		?>
	     		
	     	@endforeach
	     	
	    </p>
	    <p>
	     	@if( ! empty($arrayOfFormats) && empty(array_intersect(['soundcloud-mp3','soundcloud-m4a'], $arrayOfFormats)) )
	     		If you would like this made available on SoundCloud just 
			
			<a HREF="mailto:?
				subject=digitize sermon #'.$this->id.' request&
				body=Hi,I would enjoy having this recording in a digital format
			"> let us know</a>.
			
		Please consider helping us with the expense by donating.
		
		@include('partials.forms.donate')
		
		</p>
	     	
	     	@endif
	     	
	     	@if(count($recording->formats) < 1 )
	     	
	     		<p>We are working to make our entire archive available online. This will take some time and resources. We appreciate your patience and support.</p>

				@include('partials.forms.donate')
	     		
	     	@endif
</p>