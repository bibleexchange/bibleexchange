@extends('bible.common')

@section('window')
<div id="be_sub_banner" class="container-fluid greenBG be_sub_banner" >
	<h1>The Book of {{$book->n}}</h1>
</div>
<div class="row">
	@foreach($book->chapters AS $c)
		<div class="col-xs-3" style="border:solid gray 1px;">
			<a href="/kjv/{{strtolower($book->n)}}/{{$c->orderBy}}">Chapter {{$c->orderBy}} ({{count($c->verses)}} verses)</a>
			<p>{{ $c->summary }}</p>
		</div>

	@endforeach
</div>
@stop