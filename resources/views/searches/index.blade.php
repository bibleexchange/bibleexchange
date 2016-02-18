@extends('layouts.default')

@section('content')

<div id="be_sub_banner" class="row orangeBG be_sub_banner" >

	<h1>Search Results for: "{!!$query!!}"</h1>

</div>

@if ($query)
<center>
@if ($bibleVerses->total() >= $studies->total() && $bibleVerses->total() >= $bibleBooks->total())
	{!! $bibleVerses->render() !!}
@elseif ($studies->total() > $bibleVerses->total() && $studies->total() >= $bibleBooks->total())
	{!! $studies->render() !!}
@else {
	{!! $bibleBooks->render() !!}
@endif
</center>
<div class="row">

		@if($studies->count() >= 1)
			<div class="col-md-5">
			<h2>Studies found: ({!! $studies->total() !!})</h2>
			<ul>
			@foreach($studies AS $l)
			
				<li><a href="{!!$l->url()!!}">{!!$l->title!!}</a> by <a href="{!!$l->creator->profileUrl()!!}">{!!$l->creator->fullname!!}</a></li>
				
			@endforeach
			</ul>
			</div>
		@endif
		
		@if($bibleVerses->count() >= 1)
			<div class="col-md-5">
			<h2>Bible Verses found: ({!! $bibleVerses->total() !!})</h2>

			@foreach($bibleVerses AS $v)
			
				<li><a href="{!!$v->url()!!}">{!!$v->reference!!}</a> {!!$v->focus($query)!!}</li>
				
			@endforeach
			</ul>
			</div>
		@endif
		
		@if($bibleBooks->count() >= 1)
			<div class="col-md-2">
			<h2>Bible Books found: ({!! $bibleBooks->total() !!})</h2>
			<ul>
			@foreach($bibleBooks AS $b)
			
				<li><a href="{!!$b->url()!!}">{!!$b->n!!}</a></li>
				
			@endforeach
			</ul>
			</div>
		@endif
</div>

@endif

@stop