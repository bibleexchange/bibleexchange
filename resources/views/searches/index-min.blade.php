
<div id="be_sub_banner" class="row orangeBG be_sub_banner" >

	<!--  "{!! $query!!}": -->

@if ($query)
<center id="search-paginator">
@if ($bibleVerses->total() >= $studies->total() && $bibleVerses->total() >= $bibleBooks->total())
	{!! $bibleVerses->render() !!}
@elseif ($studies->total() > $bibleVerses->total() && $studies->total() >= $bibleBooks->total())
	{!! $studies->render() !!}
@else {
	{!! $bibleBooks->render() !!}
@endif
</center>

</div>

<div id="search-results" class="row">

		@if($studies->count() >= 1)
			<div class="col-xs-12">
			<h2>Studies found: ({!! $studies->total() !!})</h2>
			<ul>
			@foreach($studies AS $l)
			
				<li><a href="{!!$l->url()!!}">{!!$l->title!!}</a> by <a href="{!!$l->creator->profileUrl()!!}">{!!$l->creator->fullname!!}</a></li>
				
			@endforeach
			</ul>
			</div>
		@endif
		
		@if($bibleVerses->count() >= 1)
			<div class="col-xs-12" id="bible-results">
			<h2>Bible Verses found: ({!! $bibleVerses->total() !!})</h2>

			@foreach($bibleVerses AS $v)
			
				<li><a id="{{$v->chapter->id}}" href="{!!$v->url()!!}">{!!$v->reference!!}</a> {!!$v->focus($query)!!}</li>
				
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
<hr>
@endif