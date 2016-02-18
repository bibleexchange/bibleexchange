@extends('bible.common')

@section('window')

<div class="row blueBG" style="margin-bottom:25px; text-align:center;">
	<div class="container">
		<div class="col-xs-12">		
			<!-- INCLUDE: bible.partials.nav -->
			@include('bible.partials.nav',['chapter'=>$verse->chapter,'currentReference'=>$verse->reference])
		</div>
	</div>
</div>

<div id="bible" class="col-md-5 col-md-offset-1">
	<p id="verse{{$verse->v}}" class="verse">{!! $verse->kjvrText() !!}</p>
	
	<a href="{{$verse->url()}}" class="btn btn-success">read {{$verse->book->n}} {{$verse->c}}</a>
	<hr>
	<p><strong>Cross references: </strong> 
		@foreach($verse->crossReferences As $r)
		
			<?php
				$referencedVerse = BibleExchange\Entities\BibleVerse::find($r->sv);
			?>
			
			<!--tooltip-->
			<a href="{!!$referencedVerse->url()!!}" class="showverse">
			    {!!$referencedVerse->reference !!}&nbsp;&nbsp;&nbsp;&nbsp;
			    <span>
			        <img class="callout" src="/images/icon57x57.png" />
			        <strong>{!!$referencedVerse->reference !!}</strong><br />
			       {!!$referencedVerse->t !!}
			    </span>
			</a>
		@endforeach
	</p>
	
</div>

<div id ="feed" class="col-md-5">
	<h2>Notes: </h2>
	@if($currentUser)
		@include('notes.partials.publish-scripture-note-form',['verse' => $verse])
		@include ('notes.partials.notes', ['notes' => $notes])
	@else
		@include ('notes.partials.notes-php', ['notes' => $notes])
		
		<!-- INCLUDE:  bible.partials.more-here-sign-register -->
		@include('bible.partials.more-here-sign-register')
		
	@endif
		
</div>

@include('studies.partials.studies-index',['studies'=>$verse->studies])

@stop
	
@section('scripts')
	<!-- INCLUDE:  notes.partials.note-js -->
	<script>@include('notes.partials.note-js')</script>	
@stop