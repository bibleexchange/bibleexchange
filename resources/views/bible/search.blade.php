@extends('bible.common')

@section('window')

<div class="row blueBG" style="margin-bottom:25px; text-align:center;">
	<div class="container">
		<div class="col-xs-12">		
			@include('bible.nav',['chapter'=>$verses[0]->chapter,'currentReference'=>$search])
		</div>
	</div>
</div>

<main>
@if(count($verses) >= 1)


	<article>		
		@foreach ($verses as $verse)
			<p><span class="versetext"> <a href="{!!$verse->url()!!}"><strong>{!!$verse->reference!!}</strong></a>  {!!$verse->t!!}</span>	
			</p>
		@endforeach
		
	</article>
			

@else
	
Sorry, couldn't find anything that matched your search.
@endif
</main>

@stop