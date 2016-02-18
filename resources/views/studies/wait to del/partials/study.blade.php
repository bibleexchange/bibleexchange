		@include('studies.partials.headline')
		
		<p class="long-description">
			{!! $study->description !!}
		</p>
		
		<hr>
		
		@foreach($study->recordings()->soundcloud()->get() AS $s)
		
		    @foreach($s->formats()->soundcloud()->get() AS $sc)
		    		{!! $sc->stream !!}
		    @endforeach
		    	
		@endforeach   
	
		<hr>
		
	<article>
	
	{!! $study->mainVerse->quote or "" !!}
		
		@if ( $article === "" )
			<p class="text-muted"><em>This article hasn't been published, yet.</em></p>
		@else	
			{!! $article !!}
		@endif
	
	</article>