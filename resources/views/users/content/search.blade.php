<h1>Search Results "{{$search_term}}"</h1>

<ul id="notesList">
	
	@foreach($notes AS $note)
	
		<li>
			<a href="/user/content/evernote/note/{{$note->guid }}">
				{{ $note->title }}
			</a>
		</li>
		
	@endforeach

	</ul>