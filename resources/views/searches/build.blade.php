@extends('layouts.default')

@section('content')

<h1>Build Results</h1>

<ol class="row">
	
			@foreach($pages AS $p)
			
				<li>
					<a href="{{$p->url}}">{{$p->title}}</a>
					<p>{{$p->summary}}</p>
					<p>Keywords ({{count($p->keywords)}}): 
					@foreach($p->keywords As $key)
						| <a href="/search?q={{$key['word']}}">{{$key['word']}} ({{$key['count']}})</a>
					@endforeach
					</p>
					<p>Scriptures: 
					@foreach($p->scriptures As $b)
						| <a href="/bible/search?v={{$b}}">{{$b}}</a>
					@endforeach
					</p>
				</li>
				
			@endforeach
		
</ol>
	
@stop